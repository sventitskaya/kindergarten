<?php
include 'educator-service.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Дашборд воспитателя</title>
    <link rel="stylesheet" type="text/css" href="../../styles/main.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/page.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/modal.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/table.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/select.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/tab.scss">
</head>
<body>
<div class="header">
    <h2>Дашборд воспитателя<br/><?php if (isset($user_full_name)) echo $user_full_name ?></h2>

    <div class="top-panel">
        <?php if (isset($user_full_name)) : ?>
            <a href="../authorization/logout.php">Выйти</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="sidebar">
        <div class="links-container flex-column">
            <?php if (isset($isAdmin) && $isAdmin)
                echo "<a href='../administration/dashboard-admin.php'>Страница Заведующей</a>"
            ?>
            <?php if (
                isset($isAdmin) &&
                isset($isEducator) &&
                isset($isTeacher) &&
                ($isAdmin || $isEducator || $isTeacher))
                echo "<a href='dashboard-educator.php'>Страница Воспитателя</a>"
            ?>
            <a href='../parenting/dashboard-parent.php'>Страница Родителя</a>
        </div>
    </div>

    <div class="content">
        <?php if (isset($groups) && count($groups) > 0) : ?>
            <div class="tab-container">
                <ul class="tab-list">
                    <li class="main-tab" data-tab="lessons">Группы и занятия</li>
                </ul>

                <div class="main-tab-content">
                    <?php include 'lessons-tab.php'; ?>
                </div>
            </div>
        <?php else:
            // Если нет групп, выводим сообщение
            echo "<p>Нет доступных групп.</p>";
        endif;
        ?>
    </div>
</div>
<script src="../../scripts/tabs.js" type="text/javascript"></script>
</body>
</html>
