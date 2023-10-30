<div class="tab-panel" data-tab="children">
    <div class="group-tabs page-table-container">
        <ul class="tab-list">
            <?php if (isset($groups)) foreach ($groups as $group) : ?>
                <li class="tab"
                    data-group-id="<?php echo $group['group_id']; ?>"
                    data-tab="children-tab-<?php echo $group['group_id']; ?>">
                    <?php echo $group['group_name']; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php if (isset($groups) && isset($conn) && isset($childrenGroupsStrings)) foreach ($groups as $group) : ?>
            <div class="group-content tab-panel"
                 data-group-id="<?php echo $group['group_id']; ?>"
                 data-tab="children-tab-<?php echo $group['group_id']; ?>">
                <?php
                // Получаем список детей для каждой группы
                $getChildrenQuery = "SELECT c.child_id,
                                            c.birth_date,
                                            c.gender,
                                            CONCAT(c.first_name, ' ', c.middle_name, ' ', c.last_name) AS full_name
                                     FROM Children c
                                     WHERE c.group_id = :group_id";
                $stmt = $conn->prepare($getChildrenQuery);
                $stmt->bindParam(':group_id', $group['group_id']);
                $stmt->execute();
                $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (!empty($children)) {
                    ?>
                    <div class="page-table-container">
                        <table class="page-table">
                            <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Дата рождения</th>
                                <th>Пол</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($children as $child) : ?>
                                <tr>
                                    <td><?php echo $child['full_name']; ?></td>
                                    <td><?php echo date("d.m.Y", strtotime($child['birth_date'])); ?></td>
                                    <td><?php echo $child['gender']; ?></td>
                                    <td>
                                        <button class="remove-group-children"
                                                data-child-id="<?php echo $child['child_id']; ?>">
                                            Отвязать
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else {
                    echo '<p>В данной группе нет детей.</p>';
                } ?>
            </div>
        <?php endforeach; ?>
        <?php include 'children-modal.php'; ?>
        <a id="add-children-to-group">Добавить Детей</a>
        <script src="../../scripts/children-groups.js" type="text/javascript"></script>
    </div>
</div>