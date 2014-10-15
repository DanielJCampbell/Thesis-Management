## Synopsis

This is a project for displaying information on ECS Thesis students at Victoria University of Wellington.
It is a webpage that reads from a postgreSQL Database to display all information contained within the database to the user in an easy to read table with several options to change what is displayed to the user by applying filters, a search function and showing and hiding specific columns.

## Files

server/httpd/htdoc - All files related to the website
AllDB.php - php file that will fetch two tables from the database. All students table and supervisor table
index.php - main website page
dataTablesStyle.css - style sheet for formatting of the tables
edit.php - file containing relevant code for editing/add/deleteing students, does not get used as this should be handled in coordinator.php but there is some code that still needs to be transferred
getSupervisor.php - File for getting supervisor ID's for editing a student.
staffPage.css - style sheet for formatting the main page
tables.js - javascript file that handles formatting of the table susing Datatables and handles othe roperations such as requesting the tables, applying filters, etc.
vuw-logo.png - the logo for VUW

server/DatabasePopulator - all files to do with the SQL database and test data populator
heroku.sql - sql script to clear the database, reinitilaize the schema and populate it with the test data
tables.sql - sql schema for creating the postgreSQL database 
DatabasePopulator - Program to generate test data for the sql server

## Initial Setup

Set up a postgreSQL server and a webserver with php, we used heroku for this.
SQL schema is the file server/DatabasePopulator/tables.sql

(Optional) To fill the database with some test data run the database populator program. This will create the test-data.txt file in the programs root directory. Edit heroku.sql to point to the correct path of test-data.txt and tables.sql. Run heroku.sql on the database server.

Edit AllDB.php so that it will point to your postgreSQL server. The code should be at the start of the file:
```php
$location = "ec2-54-83-204-104.compute-1.amazonaws.com";
$username = "poacfvyhdhwtsx";
$password = "nVJ0Via96oYvrOfrSs3ECsVR1W";
$database = "ddf40gpbvva8uo";
```
(These similar lines of code exist in edit.php and getsupervisor.php but these files are not currently accessable from the main index page.)

Supply the webserver with all of the files contained within server/httpd/htdoc
Access index.php (default page), the page should communicate with the other files and database to display the webpage.

##Contributers
Daniel Campbell
Alvin  Pascual
Reece Patterson
Tomas Cantwell
Nainesh Patel