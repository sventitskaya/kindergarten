<?php
include 'parent-service.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Дашборд родителя</title>
    <link rel="stylesheet" type="text/css" href="../../styles/main.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/page.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/modal.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/table.scss">
</head>
<body>
<div class="header">
    <h2>Дашборд родителя<br/><?php if (isset($user_full_name)) echo $user_full_name ?></h2>
    <div class="top-panel">
        <a href="../authorization/logout.php">Выйти</a>
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
                echo "<a href='../education/dashboard-educator.php'>Страница Воспитателя</a>"
            ?>
            <a href='dashboard-parent.php'>Страница Родителя</a>
        </div>
    </div>

    <div class="content">
        <?php if (isset($children) && count($children) > 0): ?>
            <h3>Ваши дети</h3>
            <div class="page-table-container">
                <table class="page-table">
                    <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Дата рождения</th>
                        <th>Пол</th>
                        <th>Группа</th>
                        <th>Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($children as $child): ?>
                        <tr>
                            <td><?php echo $child['full_name']; ?></td>
                            <td><?php echo date("d.m.Y", strtotime($child['birth_date'])); ?></td>
                            <td><?php echo $child['gender']; ?></td>
                            <td><?php echo !empty($child['child_group_name']) ? $child['child_group_name'] : 'Не привязан к группе'; ?></td>
                            <td>
                                <button class="edit-child"
                                        data-child-id="<?php echo $child['child_id']; ?>"
                                        data-child-first-name="<?php echo $child['first_name']; ?>"
                                        data-child-middle-name="<?php echo $child['middle_name']; ?>"
                                        data-child-last-name="<?php echo $child['last_name']; ?>"
                                        data-child-birth-date="<?php echo $child['birth_date']; ?>"
                                        data-child-group-id="<?php echo $child['child_group_id']; ?>">
                                    Изменить
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>У вас нет зарегистрированных детей.</p>
        <?php endif; ?>
        <!-- Форма для добавления ребенка -->
        <a id="add-child">Добавить ребенка</a>
    </div>
</div>

<?php include 'child-modal.php'; ?>

<script src="../../scripts/children.js" type="text/javascript"></script>
</body>
</html>
