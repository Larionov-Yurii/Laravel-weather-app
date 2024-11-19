Brief description about the project and how to start it

1. Download and install Composer on your computer from the official (https://getcomposer.org/) website, considering what OS you have (Windows, Linux or macOS)
2. Also install Node.js and npm (Node Package Manager) from the official website: https://nodejs.org/
3. Install a relational database management system (RDBMS) like a MySQL
4. We also need an application with a web interface for administering the RDBMS, it can be phpmyadmin (https://www.phpmyadmin.net/) or workbench (https://www.mysql.com/products/workbench/)
5. For testing the API, we can use the Postman application, which can be downloaded from here (https://www.postman.com/downloads/) and installed, taking into account which operating system you have
6. Open your IDE and create a folder and using Git, clone the repository there: git clone https://github.com/Larionov-Yurii/Laravel-weather-app.git
7. After cloning the repository, using terminal in IDE, we need to use the command (cd) change to the directory: cd Laravel-weather-app
8. After that we need to run (composer install) or (php composer.phar install)
9. Using the command (cp) copy the (.env.example) file and create a new (.env) file in the same directory: cp .env.example .env
10. After that we need to set (.env) file and namely: 1) DB_DATABASE - your database name 2) DB_USERNAME - username in Mysql 3) DB_PASSWORD - password in MySQL 4) APP_KEY - to get this key, we need to run command in terminal like: php artisan key:generate
11. Then we can run migrations: php artisan migrate (if we have not created a database before, then thanks to this command, it will be able to automatically create a database and fill it with the necessary tables)
12. Install Frontend Dependencies in weather-frontend directory with the command: npm install
13. And finally we can start the project for that we need have two terminals in first we use command (php artisan serve) in directory Laravel-weather-app and in second terminal we use command (npm start) in weather-frontend directory
14. And finally we can test our weather forecast application which should open in the browser
