const currentDate = document.querySelector(".current-date");
daysTag = document.querySelector(".days");
prevNextIcon = document.querySelectorAll(".icons span");

let date = new Date();
currYear = date.getFullYear();
currMonth = date.getMonth();

const months = ["January","February","March","April","May","June","July","August","September","October","November","December"];
const renderCalender = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(); //getting first day of month
    let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(); //getting last date of month
    let lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(); //getting last day of month
    let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); //getting last date of previous month


    let liTag ="";
    for (let i = firstDayofMonth; i > 0 ; i--) {
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }
    for(let i = 1; i <= lastDateofMonth;i++){
        let isToday = i === date.getDate() && currMonth === new Date().getMonth()
            && currYear === new Date().getFullYear() ? "active": "";//highlight current date
        liTag += `<li class="${isToday}">${i}</li>`;
    }
    for (let i = lastDayofMonth; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`;
    }
    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;
}
renderCalender();
prevNextIcon.forEach(icon =>{
    icon.addEventListener("click", ()=>{ //add click arrow button
        currMonth = icon.id === "prev" ? currMonth - 1: currMonth + 1;

        if (currMonth <0 || currMonth > 11){
            date = new Date(currYear, currMonth);
            currYear = date.getFullYear();
            currMonth = date.getMonth()
        }else {
            renderCalender();
        }
        renderCalender();
    });
})

// --------------------------- Due Date Styling -----------------------------------

const taskduedate = document.querySelectorAll('.task-date');

console.log(taskduedate);
for (let i = 0; i < taskduedate.length; i++) {
    const taskdate = taskduedate[i].innerText;
    console.log(taskdate);
    const duedate = new Date(Date.parse(taskdate.replace(/-/g, "/").split(" ")[0]));
    console.log(duedate);
    const currentDate = new Date();

    if (currentDate > duedate) {
        taskduedate[i].style.color = '#ff0000';
        taskduedate[i].style.fontWeight = 'bold';
    }
}

