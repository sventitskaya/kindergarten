<?php
include 'admin-service.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Статистика</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../styles/main.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/page.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/modal.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/table.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/select.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/tab.scss">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="header">
    <h2>Статистика<br/><?php if (isset($user_full_name)) echo $user_full_name ?></h2>

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
            <a href='stats-admin.php'>Статистика</a>
            <a href='../education/dashboard-educator.php'>Страница Воспитателя</a>
            <a href='../parenting/dashboard-parent.php'>Страница Родителя</a>
        </div>
    </div>

    <div class="content">
        <div class="tab-container">
            <?php if (isset($groups) && count($groups) > 0) : ?>
            <h3>Количество детей по группам</h3>

            <canvas id="myChart" width="400" height="200"></canvas>
            <script src="../../scripts/chart.js" type="text/javascript"></script>
            <?php else : ?>
                <p>Нет групп для отображения статистики</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="../../scripts/tabs.js" type="text/javascript"></script>
</body>
</html>
