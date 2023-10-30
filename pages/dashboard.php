<?php
include '../src/auth-guard.php';

$isRole = isset($role);
$isAdmin = isset($role) && $role === 'Заведующая';
$isEducator = isset($role) && $role === 'Воспитатель';
$isTeacher = isset($role) && $role === 'Учитель';
$isParent = isset($role) && $role === 'Родитель';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Панель управления</title>
    <link rel="stylesheet" type="text/css" href="../styles/main.scss">
</head>
<body>
<h2>Добро пожаловать,<br/><?php if(isset($user_full_name)) echo $user_full_name; ?>!</h2>
<div class="links-container flex-column">
    <?php if ($isAdmin) echo "<a href='administration/dashboard-admin.php'>Страница Заведующей</a>" ?>
    <?php if ($isAdmin || $isEducator || $isTeacher) echo "<a href='education/dashboard-educator.php'>Страница Воспитателя</a>" ?>
    <?php if ($isRole) echo "<a href='parenting/dashboard-parent.php'>Страница Родителя</a>" ?>
</div>
<div class="logout-container">
    <a href="authorization/logout.php">Выйти</a>
</div>
</body>
</html>