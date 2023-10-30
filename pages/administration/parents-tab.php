<div class="tab-panel" data-tab="parents">
    <?php if (!empty($parents)) : ?>
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
                <?php foreach ($parents as $parent) : ?>
                    <tr>
                        <td><?php echo $parent['full_name']; ?></td>
                        <td><?php echo $parent['address']; ?></td>
                        <td><?php echo $parent['contact_phone']; ?></td>
                        <td><?php echo $parent['email']; ?></td>
                        <td>
                            <div class="button-row">
                                <button class="edit-parent"
                                        data-parent-id="<?php echo $parent['user_id']; ?>"
                                        data-parent-first-name="<?php echo $parent['first_name']; ?>"
                                        data-parent-middle-name="<?php echo $parent['middle_name']; ?>"
                                        data-parent-last-name="<?php echo $parent['last_name']; ?>"
                                        data-parent-address="<?php echo $parent['address']; ?>"
                                        data-parent-phone="<?php echo $parent['contact_phone']; ?>">
                                    Изменить
                                </button>
                                <?php
                                    $deleteClass = 'delete-parent';
                                    if (isset($conn)) {
                                        $getChildrenCountQuery = "SELECT COUNT(*) as children_count
                                                                FROM ParentChildRelation pcr
                                                                WHERE pcr.parent_id = :parentId";
                                        $stmt = $conn->prepare($getChildrenCountQuery);
                                        $stmt->bindParam(':parentId', $parent['user_id']);
                                        $stmt->execute();
                                        $resultChildren = $stmt->fetch(PDO::FETCH_ASSOC);

                                        if (isset($resultChildren) && $resultChildren['children_count'] > 0) {
                                            $deleteClass = 'confirm-delete-parent';
                                        }
                                    }
                                ?>
                                <button class="<?php echo $deleteClass; ?>"
                                        data-parent-id="<?php echo $parent['user_id']; ?>">
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
        <p>Нет родителей для отображения.</p>
    <?php endif; ?>
    <?php include 'parent-modal.php'; ?>
    <?php include 'delete-parent-modal.php'; ?>
    <script src="../../scripts/parents.js" type="text/javascript"></script>
</div>
