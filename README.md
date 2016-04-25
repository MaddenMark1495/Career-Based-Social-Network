# Career Based Social Network

A social network where students can broadcast their skills and connect with potential employers to simplify the employment searching process.

## Deployment Instructions
This app requires a web server with PHP and a MySQL Database.  It was developed on Microsoft Azure using an Ubuntu VM running Apache and an Azure MySQL Database.

Once you have your stack set up:
1. Set up the database.

	In the DDL folder, find 'LinkedOut.sql' and run that on your database to create all the tables.
	Our database on Azure was named linkedout so that is what is reflected in the .sql file.
	If yours is different and you can't create a new schema (Azure won't let you), you may have to edit the .sql
	file to match your database.

2. Set up back-end web server stuff:

	In the web accessible directory, create a new directory called 'secure'.
	Create file in the new directory named 'db.conf' who's contents is:
```php
<?php
	$dbhost = '';
	$dbuser = '';
	$dbpass = '';
	$dbname = '';
?>
```
	Where the values on the right are the credentials for your database inside the quotes.
	You will want to restrict access to the 'secure' directory so it cannot be accessed by the general public

3. Clone the repo to your web accessible directory and navigate to: 

	yourserveraddress/Career-Based-Social-Network.
