<?php
include 'admin-service.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Дашборд заведующей</title>
    <link rel="stylesheet" type="text/css" href="../../styles/main.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/page.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/modal.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/table.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/select.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/tab.scss">
</head>
<body>
<div class="header">
    <h2>Дашборд заведующей<br/><?php if (isset($user_full_name)) echo $user_full_name ?></h2>

    <div class="top-panel">
        <?php if (isset($user_full_name)) : ?>
            <a href="../authorization/logout.php">Выйти</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="sidebar">
        <div class="links-container flex-column">
            <a href='dashboard-admin.php'>Страница Заведующей</a>
            <a href='../education/dashboard-educator.php'>Страница Воспитателя</a>
            <a href='../parenting/dashboard-parent.php'>Страница Родителя</a>
        </div>
    </div>

    <div class="content">
        <div class="tab-container">
            <ul class="tab-list">
                <li class="main-tab" data-tab="approvals">Запросы на регистрацию</li>
                <li class="main-tab" data-tab="educators">Воспитатели</li>
                <li class="main-tab" data-tab="teachers">Учителя</li>
                <li class="main-tab" data-tab="groups">Группы</li>
                <li class="main-tab" data-tab="children">Воспитанники</li>
                <li class="main-tab" data-tab="parents">Родители</li>
            </ul>

            <div class="main-tab-content">
                <?php include 'registration-requests-tab.php'; ?>
                <?php include 'educators-tab.php'; ?>
                <?php include 'teachers-tab.php'; ?>
                <?php include 'groups-tab.php'; ?>
                <?php include 'children-tab.php'; ?>
                <?php include 'parents-tab.php'; ?>
            </div>
        </div>
    </div>


</div>
<script src="../../scripts/tabs.js" type="text/javascript"></script>
</body>
</html>
