<?php
//$db_host = 'gerusjmw.beget.tech'; // For local run with remote db use this
$db_host = 'localhost';
$db_name = 'gerusjmw_kinder';
$db_user = 'gerusjmw_kinder';
$db_password = '1234Root';

$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);