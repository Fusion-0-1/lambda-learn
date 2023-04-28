#!/bin/bash
. scripts/read_env_variables.sh

#---------------------parameter reads---------------------
# reading the first parameter --env and assigning it to env. cut: separate the value.
# -d=: Specifies the delimiter to be the equal sign (=).
# -f2: Specifies the field to extract as the second field after the delimiter.
params=$(echo "$1")
env=$($params | cut -d= -f2)

#-----------------------start mysql-----------------------
chmod +x scripts/performance_tracking.sh scripts/os.sh

OS=$(scripts/./os.sh)
echo "Detected Operating System: $OS"
if [ "$OS" == "Mac" ]; then
  echo "Starting MySQL and Apache server on default ports configured in MAMP."
  $MAMP./start.sh
fi

#--------------------performance script-------------------
echo "Starting performance tracking script. Logs are in scripts/logs/performance.log"
nohup scripts/./performance_tracking.sh $params >> scripts/logs/performance.log &

#----------------------server starts----------------------
cd public/
# sed: the command to invoke the sed utility
# -i: tells sed to edit the file in place
# -e: specifies that the next parameter is a script to be executed
# "16s@\$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env');@\$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.test');@":
# the script to be executed. In this case, it tells sed to substitute the string "$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env');", which is found on line 16 of the index.php file, with "$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.test');".
# index.php: the file to be edited.
if [ "$env" == "test" ]; then
  sed -i -e "16s@\$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env');@\$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.test');@" index.php
  nohup php -S "$HOST_TEST":"$PORT_TEST" >> ../scripts/logs/server.log &
  echo "[TESTING_ENV] : $HOST_TEST:$PORT_TEST"
fi
if [ "$env" == "dev" ] || [ "$env" == "" ]; then
  sed -i -e "16s@\$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env.test');@\$dotenv = Dotenv::createImmutable(dirname(__DIR__), '.env');@" index.php
  nohup php -S "$HOST":"$PORT"  >> ../scripts/logs/server_test.log &
  echo "[DEV_ENV] : $HOST:$PORT"
elif [ "$env" != "test" ]; then
  echo "Unknown environment. Please use --env=test or --env=dev. Defaulting to dev."
fi

echo ""
