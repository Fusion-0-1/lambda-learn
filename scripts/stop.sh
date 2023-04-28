#!/bin/bash
# Path: scripts/stop.sh
. scripts/read_env_variables.sh

PID_PERFORMANCE=$(ps aux | grep "performance_tracking.sh" |  grep -v grep | awk '{print $2}')
PID_PHP=$(ps aux | grep "php -S $HOST:$PORT" | grep -v grep | awk '{print $2}')
PID_PHP_TEST=$(ps aux | grep "php -S $HOST_TEST:$PORT_TEST" | grep -v grep | awk '{print $2}')

if [ "$PID_PERFORMANCE" != "" ]; then
  echo "Stopping performance_tracking.sh running on $PID_PERFORMANCE"
  kill "$PID_PERFORMANCE"
fi
if [ "$PID_PHP" != "" ]; then
  echo "Stopping PHP server on $HOST:$PORT"
  kill "$PID_PHP"
fi
if [ "$PID_PHP_TEST" != "" ]; then
  echo "Stopping PHP server on $HOST_TEST:$PORT_TEST"
  kill "$PID_PHP_TEST"
fi

OS=$(scripts/./os.sh)
echo "Detected Operating System: $OS"
if [ "$OS" == "Mac" ]; then
  echo "Stopping MySQL and Apache server on default ports configured in MAMP."
  $MAMP./stop.sh
fi
