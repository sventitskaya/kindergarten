<?php
include('../../src/auth-guard.php');

if (isset($user_id) && isset($conn) && isset($role)) {
    try {
        // Запрос списка детей для текущего родителя
        $parent_id = $user_id; // ID родителя

        // SQL-запрос для получения детей текущего родителя через таблицу ParentChildRelation
        $getChildQuery = "SELECT c.child_id,
                                 c.birth_date,
                                 c.gender,
                                 c.first_name,
                                 c.middle_name,
                                 c.last_name,
                                 CONCAT(c.first_name, ' ', c.middle_name, ' ', c.last_name) AS full_name,
                                 cg.group_id as child_group_id,
                                 cg.group_name AS child_group_name
                          FROM Children c
                          INNER JOIN ParentChildRelation pcr ON c.child_id = pcr.child_id
                          LEFT JOIN ChildrenGroups cg ON c.group_id = cg.group_id
                          WHERE pcr.parent_id = :parent_id";
        $stmt = $conn->prepare($getChildQuery);
        $stmt->bindParam(':parent_id', $parent_id);
        $stmt->execute();
        $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Получаем список всех групп
        $getGroupsQuery = "SELECT g.group_id, g.group_name FROM ChildrenGroups g";
        $stmt = $conn->prepare($getGroupsQuery);
        $stmt->execute();
        $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }
}