<?php
include '../../src/session-helper.php';
startSession();
destroySession();
header('Location: login.php');
?>