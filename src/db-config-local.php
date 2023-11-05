<?php
$db_host = 'localhost';
$db_name = 'kindergarten';
$db_user = 'root';
$db_password = '12345678';

$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);