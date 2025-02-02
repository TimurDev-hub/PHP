# Website of passenger transport company (pet project #1);

## Description:
The application is in the early stages of development.

## Available functions (02.02.2025):
* User registration;
* User's personal account;
* Admin panel;
* Editing username;
* Adding "product cards" (via the admin panel);
* Editing "product cards" (via the admin panel);
* Deleting "product cards" (via the admin panel);

## Technology stack:
* PHP 8.4.1
* Composer 2.8.3
* Node.js 20.18.0
* PostgreSQL 17
* SCSS 1.80.6
* TypeScript 5.7.2
* HTML5
* CSS3

## To run it is used on Apache 2.4.62;

# Instructions:
1. Make sure you have up-to-date versions of PHP, Composer, Node.js, PostgreSQL installed;
2. Copy the repository: ;
3. Install PHP dependencies: `composer install`;
4. Install Node.js dependencies: `npm install`;
5. Create a file `app/src/core/config/env.php` with the following contents:
	```php
	<?php

	namespace Core\Config;

	class env
	{
		public static $dbHost = 'YOUR_LOCALHOST';
		public static $dbName = 'YOUR_DB_NAME';
		public static $dbUser = 'YOUR_DB_USERNAME';
		public static $dbPassword = 'YOUR_DB_PASSWORD';
	}
	```
6. Create new PostgreSQL database;
7. Create table **users**:
	```sql
	CREATE TABLE users (
	user_id SERIAL PRIMARY KEY,
	user_name VARCHAR(255) NOT NULL UNIQUE,
	user_email VARCHAR(255) NOT NULL UNIQUE,
	user_password VARCHAR(255) NOT NULL
	);
	```
8. Create table **cards**:
	```sql
	CREATE TABLE users (
	id SERIAL PRIMARY KEY,
	c_route VARCHAR(255) NOT NULL UNIQUE,
	c_num VARCHAR(255) NOT NULL UNIQUE,
	c_time VARCHAR(255) NOT NULL,
	c_price VARCHAR(255) NOT NULL
	);
	```
9. Configure your web server appropriately to run the application.
10. To add an admin panel, go to the registration page, in the input fields specify:
	1. *username:* admin
	2. *email:* admin@gmail.com
	3. Random password