<?php
$db_host = 'gerusjmw.beget.tech';
$db_name = 'gerusjmw_kinder';
$db_user = 'gerusjmw_kinder';
$db_password = '1234Root';
$db_host = 'gerusjmw.beget.tech';
$db_name = 'gerusjmw_kinder';
$db_user = 'gerusjmw_kinder';
$db_password = '1234Root';

$conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);