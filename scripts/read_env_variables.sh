#!/bin/bash

SERVER_DOMAIN="SERVER_DOMAIN"
SERVER_PORT="SERVER_PORT"

export MAMP="/Applications/MAMP/bin/"

# Source .env not being used since only required to read the server domain and port.
export HOST_TEST=$(grep "$SERVER_DOMAIN=" .env.test | cut -d\" -f2)
export PORT_TEST=$(grep "$SERVER_PORT=" .env.test | cut -d\" -f2)

export HOST=$(grep "$SERVER_DOMAIN=" .env | cut -d\" -f2)
export PORT=$(grep "$SERVER_PORT=" .env | cut -d\" -f2)
