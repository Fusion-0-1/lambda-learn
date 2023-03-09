#!/bin/bash

source ../.env

# import the os.bash script to get the OS
OS=$(/bin/bash ../scripts/os.bash)

while [ true ]
do
    # if the OS is Mac, run the Mac commands
    if [ "$OS" == "Mac" ]; then      
        # sample output from top in Mac
        # Processes: 546 total, 3 running, 543 sleeping, 2823 threads                                                                                                                                                                                           16:58:41
        # Load Avg: 1.52, 2.37, 2.40  
        # CPU usage: 7.12% user, 4.2% sys, 88.85% idle     
        # SharedLibs: 695M resident, 126M data, 61M linkedit. 
        # MemRegions: 297025 total, 4368M resident, 329M private, 3106M shared.
        # PhysMem: 15G used (1915M wired, 1121M compressor), 504M unused. 
        # VM: 231T vsize, 4184M framework vsize, 0(0) swapins, 0(0) swapouts. 
        # Networks: packets: 722101/380M in, 327457/106M out. 
        # Disks: 1312715/19G read, 645156/8806M written.
        
        #  -l 1 : "top" to only run for one iteration and then exit
        TOP=$(top -l 1 -s 0 | head -n 10)
        
        MEM=$(echo $TOP | grep "PhysMem:")  # get the line with the memory information
        TOTAL_MEM=$(sysctl -n hw.memsize) # get the total memory
        TOTAL_MEM=$((TOTAL_MEM/1024**2)) # convert to MB
        # awk will get the 8th column, which is the unused memory and cut will remove the 'G' at the end
        UNUSED_MEM=$(echo $MEM | awk '{print $8}' | cut -d'G' -f1) 
        USED_MEM=$((TOTAL_MEM - UNUSED_MEM)) # calculate the used memory

        # awk will get the 3rd column, which is the CPU usage and cut will remove the '%' at the end
        CPU=$(echo $TOP | grep -o 'CPU usage: [0-9]\+.[0-9]\+%' | awk '{print $3}' | cut -d'%' -f1)

        PROC_COUNT=$(echo $TOP | grep "Processes:" | awk '{print $2}') # awk will get the 2nd column, which is the process count
        PROC_RUNNING=$(echo $TOP | grep "Processes:" | awk '{print $4}') # awk will get the 4th column, which is the process running
        # awk will first select substring upto ` threads` and then get the number of columns
        no_columns=$(echo $TOP | grep "Processes:" | awk -F ' threads' '{ print $1 " threads" }' | awk -F" " "{ print NF }") 

        if [ $no_columns -eq 9 ]; then
            PROC_SLEEPING=$(echo $TOP | grep "Processes:" | awk '{print $6}') # awk will get the 6th column, which is the process sleeping
        else
            PROC_SLEEPING=$(echo $TOP | grep "Processes:" | awk '{print $8}') # awk will get the 7th column, which is the process sleeping
        fi

    # if the OS is Linux, run the Linux commands
    elif [ "$OS" == "Linux" ]; then
        # sample output from top in Linux
        # top - 18:50:03 up 59 min,  1 user,  load average: 0.65, 0.28, 0.20
        # Tasks: 193 total,   1 running, 192 sleeping,   0 stopped,   0 zombie
        # %Cpu(s):  0.0 us,  0.0 sy,  0.0 ni,100.0 id,  0.0 wa,  0.0 hi,  0.0 si,  0.0 st
        # MiB Mem :   1967.5 total,    476.0 free,    649.2 used,    842.3 buff/cache
        # MiB Swap:   2048.0 total,   2048.0 free,      0.0 used.   1084.6 avail Mem 
        
        #  -b: runs in batch mode n1: "top" to only run for one iteration and then exit
        TOP=$(top -bn1 | head -10)

        MEM=$(echo $TOP | grep "MiB Mem :") # get the line with the memory information
        # awk will get the 3rd column, which is the total memory and cut will remove the 'M' at the end
        TOTAL_MEM=$(echo $MEM | awk '{print $3}' | cut -d'M' -f1) 
        USED_MEM=$(echo $MEM | awk '{print $5}' | cut -d'M' -f1) # awk will get the 5th column, which is the used memory
        UNUSED_MEM=$((TOTAL_MEM - USED_MEM)) # calculate the unused memory

        # awk will get the 2nd column, which is the CPU usage and cut will remove the '%' at the end
        CPU=$(echo $TOP | grep "Cpu(s):" | awk '{print $2}' | cut -d'%' -f1)

        PROC_COUNT=$(echo $TOP | grep "Tasks:" | awk '{print $2}') # awk will get the 2nd column, which is the process count
        PROC_RUNNING=$(echo $TOP | grep "Tasks:" | awk '{print $4}') # awk will get the 4th column, which is the process running
        PROC_SLEEPING=$(echo $TOP | grep "Tasks:" | awk '{print $6}') # awk will get the 6th column, which is the process sleeping
    # if the OS is not Mac or Linux, exit
    else 
        echo "OS not supported"
        exit 1
    fi
    
    mysql --user=$DB_USER --password=$DB_PASS $DB_NAME  << EOF
    INSERT INTO PerformanceHistory (cpu_usage, total_memory, used_memory, unused_memory, process_count, process_running, process_sleeping)
    VALUES ($CPU, $TOTAL_MEM, $USED_MEM, $UNUSED_MEM, $PROC_COUNT, $PROC_RUNNING, $PROC_SLEEPING); 
EOF

    sleep 300
done