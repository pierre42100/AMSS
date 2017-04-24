<?php

/* 
 * The MIT License
 *
 * Copyright 2017 pierre.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * System init file
 * 
 * @author Pierre HUBERT
 */

//Start session
session_start();

//Define system paths
define("SYSTEM_PATH", __DIR__."/");
define("DATA_PATH", str_replace("system", "application/data", SYSTEM_PATH));
define("PAGES_PATH", str_replace("system", "application/pages", SYSTEM_PATH));

//Auto-inclusion of functions
foreach(glob(SYSTEM_PATH."/functions/*") as $classFile){
    require_once($classFile);
}

//Auto-inclusion of classes
foreach(glob(SYSTEM_PATH."/classes/*") as $classFile){
    require_once($classFile);
}

//Auto-inclusion of required helpers
foreach(glob(SYSTEM_PATH."/helpers/*") as $helperFile){
    require_once($helperFile);
}

//Inclusion of configuration files
$config = new config();
foreach(glob(SYSTEM_PATH."/config/*") as $helperFile){
    require_once($helperFile);
}

//Intialize AMSS main object
$amss = new amss();

//Register config
$amss->register("config", $config);

//Connection to database
$db_verbose = $amss->config->get("site_mode") == "debug";
$database = new DBLibrary($db_verbose);
$database->openSQLite(DATA_PATH.$config->get("database_file"));
$amss->register("db", $database);

//Fast shorcut to access datatable names
define("DB_PREFIX", $amss->config->get("database_prefix"));

//Init user class
$user = new User();
$amss->register("user", $user);

//Init view system
$views = new views();
$amss->register("views", $views);

//Init mail system
$mails = new mails();
$amss->register("mails", $mails);

//Init statistics class
$stats = new Statistics();
$amss->register("stats", $stats);

//Init log system
$log = new Log();
$amss->register("log", $log);