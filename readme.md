# Laravel Backend-API - Example XAMPP local setup

## Step 1 - Setup XAMPP
Setup your XAMPP environment by placing this project in the XAMPP htdocs folder. Please make use of virtualhosts:
https://delanomaloney.com/2013/07/10/how-to-set-up-virtual-hosts-using-xampp/
Make sure to link the virtualhost to the public Laravel folder.

Create an empty database called "api" in PHPMyAdmin

## Step 2 - Install
Change directory to the project folder and install the project by running the following command in a command line tool:
composer install

Create the tables and setup data by running:
composer install
php artisan db:seed

## Step 3 - Configure API
Go to LaravelAPI\Config\api.php and change the default domain to use for the API routes

Edit