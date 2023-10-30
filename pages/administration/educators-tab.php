<div class="tab-panel" data-tab="educators">
    <?php if (!empty($educators)) : ?>
        <div class="group-tabs page-table-container">
            <table class="page-table">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Адрес</th>
                    <th>Номер телефона</th>
                    <th>Адрес электронной почты</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($educators as $educator) : ?>
                    <tr>
                        <td><?php echo $educator['full_name']; ?></td>
                        <td><?php echo $educator['address']; ?></td>
                        <td><?php echo $educator['contact_phone']; ?></td>
                        <td><?php echo $educator['email']; ?></td>
                        <td>
                            <div class="button-row">
                                <button class="edit-educator"
                                        data-educator-id="<?php echo $educator['user_id']; ?>"
                                        data-educator-first-name="<?php echo $educator['first_name']; ?>"
                                        data-educator-middle-name="<?php echo $educator['middle_name']; ?>"
                                        data-educator-last-name="<?php echo $educator['last_name']; ?>"
                                        data-educator-address="<?php echo $educator['address']; ?>"
                                        data-educator-phone="<?php echo $educator['contact_phone']; ?>">
                                    Изменить
                                </button>
                                <?php
                                    $deleteClass = 'delete-educator';
                                    if (isset($conn)) {
                                        // Получаем количество групп, привязанных к воспитателю
                                        $getGroupsCountQuery = "SELECT COUNT(*) as group_count
                                                                FROM ChildrenGroups g
                                                                WHERE g.educator_id = :educatorId";
                                        $stmt = $conn->prepare($getGroupsCountQuery);
                                        $stmt->bindParam(':educatorId', $educator['user_id']);
                                        $stmt->execute();
                                        $resultGroups = $stmt->fetch(PDO::FETCH_ASSOC);

                                        $getLessonsCountQuery = "SELECT COUNT(*) as lesson_count
                                                                FROM Lessons l
                                                                WHERE l.teacher_id = :educatorId";
                                        $stmt = $conn->prepare($getLessonsCountQuery);
                                        $stmt->bindParam(':educatorId', $educator['user_id']);
                                        $stmt->execute();
                                        $resultLessons = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if ((isset($resultGroups) && $resultGroups['group_count'] > 0) ||
                                            (isset($resultLessons) && $resultLessons['lesson_count'] > 0)) {
                                            $deleteClass = 'confirm-delete-educator';
                                        }
                                    }
                                ?>
                                <button class="<?php echo $deleteClass; ?>"
                                        data-educator-id="<?php echo $educator['user_id']; ?>">
                                    Уволить
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>Нет воспитателей для отображения.</p>
    <?php endif; ?>
    <?php include 'educator-modal.php'; ?>
    <?php include 'delete-educator-modal.php'; ?>
    <a id="add-educator">Добавить Воспитателя</a>
    <script src="../../scripts/educators.js" type="text/javascript"></script>
</div>
