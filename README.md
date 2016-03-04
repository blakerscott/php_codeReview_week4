## Epicodus PHP Course - Week 4: Database Extended Code Review

### By: Blake Scott

### Description

This is an application for a hair salon.  It provides a graphical user interface to allow the salon owner to create, read, update and destroy a record for each stylist at the salon.  It also allows the owner to create, read, update and destroy a record for each of the stylist's clients.

### Known Bugs

No known bugs at this time.

###MYSQL commands used:

Last login: Fri Mar  4 09:18:11 on ttys000
epicodus-1:~ Guest$ mysql.server start
Starting MySQL
 SUCCESS!
epicodus-1:~ Guest$ mysql -uroot -proot
mysql: [Warning] Using a password on the command line interface can be insecure.
Welcome to the MySQL monitor.  Commands end with ; or \g.
Your MySQL connection id is 2
Server version: 5.7.10 Homebrew

Copyright (c) 2000, 2015, Oracle and/or its affiliates. All rights reserved.

Oracle is a registered trademark of Oracle Corporation and/or its
affiliates. Other names may be trademarks of their respective
owners.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

mysql> show databases;
+--------------------+
| Database           |
+--------------------+
| information_schema |
| hair_salon         |
| hair_salon_test    |
| mysql              |
| performance_schema |
| sys                |
+--------------------+
6 rows in set (0.03 sec)

mysql> create database shoes;
Query OK, 1 row affected (0.01 sec)

mysql> use shoes;
Database changed
mysql> create table stores (id serial PRIMARY KEY, name VARCHAR(255));
Query OK, 0 rows affected (0.07 sec)

mysql> CREATE TABLE brands (id serial PRIMARY KEY, name VARCHAR(255));
Query OK, 0 rows affected (0.08 sec)

mysql> CREATE TABLE stores_brands (id serial PRIMARY KEY, stores_id int, brands_id int));
ERROR 1064 (42000): You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near ')' at line 1
mysql> CREATE TABLE stores_brands (id serial PRIMARY KEY, stores_id int, brands_id int);
Query OK, 0 rows affected (0.08 sec)

mysql> show tables;
+-----------------+
| Tables_in_shoes |
+-----------------+
| brands          |
| stores          |
| stores_brands   |
+-----------------+
3 rows in set (0.00 sec)

mysql> 


### Setup

Clone this repo on to your desktop, make sure that you have Composer installed on your computer and then:
* navigate into the project folder.
* In your terminal, run the command:
```shell
composer install
```
* Once it is finished installing, navigate to the 'web' directory.
* In the 'web' directory, start the server with this command (if you are using a mac):
```shell
php -S localhost:8000
```
* Go to your browser and for the URL, type in: localhost:8000

* To access the database, in a separate terminal window, navigate to your project folder and enter:
```shell
apachectl start
```
followed by:
```shell
mysql.server start
mysql -uroot -uroot
```
* In a new window in your web browser, type in: localhost:8080/phpmyadmin

* Login and click on the import tab. Under choose file, choose the file from the project folder ending in .sql and click go.

* You can now access the hair_salon database!

* If sql file does not properly work, you can enter the following into your designated mySQL terminal:
```shell
CREATE DATABASE hair_salon;
USE hair_salon;
CREATE TABLE stylists (name VARCHAR (255), id serial PRIMARY KEY);
CREATE TABLE clients (name VARCHAR (255), phone VARCHAR (255), stylist_id INT, id serial PRIMARY KEY);
```

### Technologies Used
* html
* CSS
* PHP
* Silex
* Twig
* MySQL
* Apache
* PHPUnit
* Bootstrap v3.3.6

###Copyright & Licensing

Copyright (c) 2015 **Blake Scott**

*This software is licensed under the MIT license.*

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
