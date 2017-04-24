# AMSS Automated Mail Sending System

## Introduction

The aim of this project is to offer a scalable mail sending system. It should let users programm when their mails will be sent over the Internet. This project is based on an API developed to be independent of the web interface. That's why this project can easily communicate with other services and can be integrated in a more complex system.

(c) Pierre HUBERT 2017 - Licensed under the MIT License

## Project structure

- `system` : System folder, which will contains methods commons to all website
  - `classes` : Common classes
  - `config` : Configuration files
  - `functions` : Common fuctions
  - `helpers` : Project helpers
  - `RestServer` : Contains the RestServer framework (RestEasy (c) 2009 Jacob Wright)
  - `RestServerControllers` : This folder contains the RestServer controllers
  - `init.inc.php` : Page initiator. Used to connect to database, as instance.

- `application` : Main application folder
  - `pages` : Contains all the pages of the website
  - `data` : Protected data folder
    - `database.sqlite` : This database stores mails
    - `logs` : This folder contains recent logs

- `assets` : This folder contains all static files and especially the adminLTE framework

- `README.md` : current file
- `index.php` : main file, it is the first file to receive requests
- `api.php` : This file handles API requests
- `cron.php` : This file, called by the server, let mails being sent automaticaly.


## Installation

In order to install AMSS correctly, 
* Please make sure you have a recent version of PHP (PHP 7.0 is recommended), a server with mail sending abilities. 
* To check the project configuration, edit the files contained in the following folder : `system/config/`
* Make sure that the `cron.php` file at the root of the project is installed as a cron file in the system.
* The `application/data/logs` folder must be accessible as writable by the server.
* Create the `application/data/database.sqlite` file using the SQL file `application/data/dbStructure.sql`