# Laravel Backend-API

## Step 1 - Setup XAMPP
Setup your XAMPP environment by placing this project in the XAMPP htdocs folder. Please make use of virtualhosts:
https://delanomaloney.com/2013/07/10/how-to-set-up-virtual-hosts-using-xampp/
Make sure to link the virtualhost to the public Laravel folder.

Create an empty database called "api" in PHPMyAdmin

## Step 2 - Install
Change directory to the project folder and install the project by running the following command in a command line tool:<br />
composer install

Create the tables and setup data by running:<br />
php artisan migrate <br />
php artisan db:seed

## Step 3 - Configure API
Go to LaravelAPI\Config\api.php and change the default domain to use for the API routes

## Step 4 - Test calls
First make sure you are logged in by using the route auth/login providing an email and password in the header of the POST-call (can use Postman to test this).
If you are not registered yet use the /auth/signup route and provide a name, email and password in the header of the POST-call. 
After signup the login route is called with the new credentials. The login route will return a JWT-token. This JWT-token needs to be used to do a call to the 
JWT protected routes. In Postman you can do a GET request to the route api/v1/lessons, use the received token from the previous step as header with name "token". 

## Sidenote 
The project AngularJS-frontend is in development and can be used to test the API. This is still a proof of concept of an AngularJS Single Page Application which later 
can be used as input for the new Content Management System of Not On Paper.


