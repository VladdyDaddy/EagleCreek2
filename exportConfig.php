<?php
//DB details
$dbHost     = 'localhost';
$dbUsername = 'vladdydaddy';
$dbPassword = '@\8Fn:f/BS7uS';
$dbName     = 'newsletter';

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if($db->connect_error){
    die("Unable to connect database: " . $db->connect_error);
}
