<?php

$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "coderslab";
$DB_DBNAME = "Twitter";

$conn = new PDO(
        'mysql:host=' . $DB_HOST . ';dbname=' . $DB_DBNAME . ';charset=utf8;', $DB_USER, $DB_PASSWORD, [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
);
