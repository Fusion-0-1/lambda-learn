# lambda-learn
Lambda - Learn | Learning Management System for Higher Education


## Built with
- JS, HTML, CSS


### 1. Prerequisites
Install php. Install composer from `https://getcomposer.org/download/`.


### 2. Installation
Update the dependencies by executing below command in the root directory.
> composer update


### 3. Initialize dot environment file
Create a .env file in the root directory and enter the following details,
```dotenv
# ----- Dev/Prod Environment ----- #
#Server Configuration
SERVER_DOMAIN="<domain>"
SERVER_PORT="<port>"

#DB Configuration
DB_HOST="<host>" % default 127.0.0.1
DB_USER="<user>"
DB_PASS="<password>"
DB_NAME="lambda-learn"
DB_PORT="<port>" % default 8889 on MAMP

#SMTP Configuration
SMTP_HOST="smtp.gmail.com" % configured for gmail
SMTP_PORT="465" % configured for gmail
SMTP_USER="<email>"
SMTP_PASS="<app_password>"
SMTP_FROM="<email>"
SMTP_FROM_NAME="<sender_name>"
SMTP_SECURE="ssl" % ssl/tls
```
Duplicate above file as `.env.test` for testing environment setup.


### 4. Database
4.1. Import the database from `./database/lambda-learn.sql`. <br>
4.2. Import triggers/functions and procedures from `./database/functions_procedures_triggers.sql`. If all the triggers/
functions/procedures not inserted automatically, please insert manually by copying and pasting the script.<br>
4.3. Import data from `./database/insert-data.sql`.


### 5. Start the server - Auto
Start the server from the root directory with the following command,
> ./start.sh 

Stop the server from the root directory using the following command,
> scripts/./stop.sh

Note: `./start.sh and ./stop.sh` are only for Mac. For other operating system, need follow the manual setup.


### 5. Start the server - Manual
Start the server from the `./public/` directory,
> php -S 127.0.0.1:8080

Open `127.0.0.1:8080` in browser.
