<div class="tab-panel" data-tab="groups">
    <?php if (!empty($groups)) : ?>
        <div class="group-tabs page-table-container">
            <table class="page-table">
                <thead>
                <tr>
                    <th>Имя</th>
                    <th>Воспитатель</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($groups as $group) : ?>
                    <tr>
                        <td><?php echo $group['group_name']; ?></td>
                        <td><?php echo $group['educator_full_name']; ?></td>
                        <td>
                            <div class="button-row">
                                <button class="edit-group"
                                        data-group-id="<?php echo $group['group_id']; ?>"
                                        data-group-name="<?php echo $group['group_name']; ?>"
                                        data-group-educator-id="<?php echo $group['educator_id']; ?>">
                                    Изменить
                                </button>
                                <?php
                                    $deleteClass = 'delete-group';
                                    if (isset($conn)) {
                                        // Получаем количество детей, привязанных к группе
                                        $getChildrenCountQuery = "SELECT COUNT(*) as children_count
                                                                FROM Children c
                                                                WHERE c.group_id = :groupId";
                                        $stmt = $conn->prepare($getChildrenCountQuery);
                                        $stmt->bindParam(':groupId', $group['group_id']);
                                        $stmt->execute();
                                        $resultChildren = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if (isset($resultChildren) && $resultChildren['children_count'] > 0) {
                                            $deleteClass = 'confirm-delete-group';
                                        }
                                    }
                                ?>
                                <button class="<?php echo $deleteClass; ?>"
                                        data-group-id="<?php echo $group['group_id']; ?>">
                                    Удалить
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else : ?>
        <p>Нет групп для отображения.</p>
    <?php endif; ?>
    <?php include 'group-modal.php'; ?>
    <?php include 'delete-group-modal.php'; ?>
    <a id="add-group">Добавить Группу</a>
    <script src="../../scripts/groups.js" type="text/javascript"></script>
</div>
