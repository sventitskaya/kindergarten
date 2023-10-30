<div class="tab-panel" data-tab="children">
    <div class="group-tabs page-table-container">
        <?php
        if (isset($conn)) {
            // Получаем список детей для каждой группы
            $getChildrenQuery = "SELECT c.child_id,
                                            c.birth_date,
                                            c.gender,
                                            CONCAT(c.first_name, ' ', c.middle_name, ' ', c.last_name) AS full_name,
                                            cg.group_id,
                                            cg.group_name
                                     FROM Children c LEFT JOIN ChildrenGroups cg ON c.group_id = cg.group_id";
            $stmt = $conn->prepare($getChildrenQuery);
            $stmt->bindParam(':group_id', $group['group_id']);
            $stmt->execute();
            $children = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if (!empty($children)) {
            ?>
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
                    <?php foreach ($children as $child) : ?>
                        <tr>
                            <td><?php echo $child['full_name']; ?></td>
                            <td><?php echo date("d.m.Y", strtotime($child['birth_date'])); ?></td>
                            <td><?php echo $child['gender']; ?></td>
                            <td><?php echo $child['group_name']; ?></td>
                            <td>
                                <div class="button-row">
                                    <button class="remove-group-children"
                                            data-child-id="<?php echo $child['child_id']; ?>"
                                            <?php if (!isset($child['group_id'])): ?>hidden<?php endif; ?>>
                                        Отвязать
                                    </button>

                                    <button class="add-children-to-group"
                                            data-child-id="<?php echo $child['child_id']; ?>"
                                            <?php if (isset($child['group_id'])): ?>hidden<?php endif; ?>>
                                        Привязать
                                    </button>

                                    <button class="delete-child"
                                            data-child-id="<?php echo $child['child_id']; ?>"
                                            <?php if (isset($child['group_id'])): ?>hidden<?php endif; ?>>
                                        Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php } else {
            echo '<p>В данной группе нет детей.</p>';
        } ?>
        <?php include 'children-modal.php'; ?>
        <script src="../../scripts/children-groups.js" type="text/javascript"></script>
    </div>
</div>