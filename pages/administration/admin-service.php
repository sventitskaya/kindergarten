<?php
include('../../src/auth-guard.php');
include '../../src/redirect-guard.php';

if (isset($conn) && isset($role) && isset($isAdmin)) {
    if ($isAdmin) {
        try {
            // Запрос списка ожидающих запросов на регистрацию
            $selectRequestsQuery = "SELECT u.username, CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS full_name, 'Ожидает' as status
                                    FROM Users u
                                    INNER JOIN RegistrationRequests r ON u.user_id = r.user_id
                                    WHERE r.status = 'Pending'";

            $stmt = $conn->prepare($selectRequestsQuery);
            $stmt->execute();

            $requests = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Запрос списка воспитателей
            $selectEducatorsQuery = "SELECT CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS full_name,
                                            u.user_id,
                                            u.first_name,
                                            u.middle_name,
                                            u.last_name,
                                            u.address,
                                            u.email,
                                            u.contact_phone
                                     FROM Users u
                                     WHERE role_id = (SELECT role_id FROM Roles WHERE role_name = 'Воспитатель')";
            $stmt = $conn->prepare($selectEducatorsQuery);
            $stmt->execute();
            $educators = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Запрос списка учителей
            $selectTeachersQuery = "SELECT CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS full_name,
                                           u.user_id,
                                           u.first_name,
                                           u.middle_name,
                                           u.last_name,
                                           u.address,
                                           u.email,
                                           u.contact_phone
                                    FROM Users u 
                                    WHERE role_id = (SELECT role_id FROM Roles WHERE role_name = 'Учитель')";
            $stmt = $conn->prepare($selectTeachersQuery);
            $stmt->execute();
            $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Запрос списка родителей
            $selectParentsQuery = "SELECT CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS full_name,
                                           u.user_id,
                                           u.first_name,
                                           u.middle_name,
                                           u.last_name,
                                           u.address,
                                           u.email,
                                           u.contact_phone
                                    FROM Users u 
                                    WHERE role_id = (SELECT role_id FROM Roles WHERE role_name = 'Родитель')";
            $stmt = $conn->prepare($selectParentsQuery);
            $stmt->execute();
            $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Запрос списка групп
            $selectGroupsQuery = "SELECT cg.group_id, 
                                         cg.group_name, 
                                         cg.educator_id, 
                                         CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS educator_full_name 
                                  FROM ChildrenGroups cg LEFT JOIN Users u on cg.educator_id = u.user_id";
            $stmt = $conn->prepare($selectGroupsQuery);
            $stmt->execute();
            $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Запрос списка воспитанников
            $selectChildrenQuery = "SELECT c.child_id,
                                           CONCAT(c.first_name, ' ', c.middle_name, ' ', c.last_name) AS full_name,
                                           c.birth_date,
                                           c.gender,
                                           c.group_id
                                    FROM Children c";
            $stmt = $conn->prepare($selectChildrenQuery);
            $stmt->execute();
            $children = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $getFreeChildrenQuery = "SELECT c.child_id,
                                            c.birth_date,
                                            c.gender,
                                            CONCAT(c.first_name, ' ', c.middle_name, ' ', c.last_name) AS full_name
                                     FROM Children c
                                     WHERE c.group_id is null";
            $stmt = $conn->prepare($getFreeChildrenQuery);
            $stmt->execute();
            $freeChildren = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $getAssignedChildGroupsQuery = "SELECT cg.group_id
                                    FROM ChildrenGroups cg
                                    LEFT JOIN Children c ON cg.group_id = c.group_id
                                    WHERE c.group_id is not null";

            $stmt = $conn->prepare($getAssignedChildGroupsQuery);
            $stmt->execute();
            $childGroups = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($childGroups as $childGroup) {
                $groupId = $childGroup['group_id'];

                $getChildrenGroupsQuery = "SELECT child_id FROM Children WHERE group_id = :group_id";
                $stmt = $conn->prepare($getChildrenGroupsQuery);
                $stmt->bindParam(':group_id', $groupId);
                $stmt->execute();
                $groupsChildren = $stmt->fetchAll(PDO::FETCH_COLUMN);

                $childrenGroups[$groupId] = $groupsChildren;
            }
            $childrenGroupsStrings = array();
            if (isset($childrenGroups)) foreach ($childrenGroups as $groupId => $groupsChildren) {
                $childrenGroupsString = implode(',', $groupsChildren);
                $childrenGroupsStrings[$groupId] = $childrenGroupsString;
            }

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                foreach ($requests as $request) {
                    $username = $request['username'];
                    if (isset($_POST['confirm_' . $username])) {
                        try {
                            // Обновление статуса запроса на "Approved"
                            $updateStatusQuery = "UPDATE RegistrationRequests SET status = 'Approved' WHERE user_id = (SELECT user_id FROM Users WHERE username = :username)";
                            $stmt = $conn->prepare($updateStatusQuery);
                            $stmt->bindParam(':username', $username);
                            $stmt->execute();

                            // Обновление интерфейса: перезагрузка страницы
                            header("Location: dashboard-admin.php");
                            exit;
                        } catch (PDOException $e) {
                            echo "Ошибка при выполнении запроса: " . $e->getMessage();
                        }
                    }
                    if (isset($_POST['cancel_' . $username])) {
                        try {
                            // Удаление статуса запроса
                            $deleteStatusQuery = "DELETE FROM RegistrationRequests WHERE user_id = (SELECT user_id FROM Users WHERE username = :username)";
                            $stmt = $conn->prepare($deleteStatusQuery);
                            $stmt->bindParam(':username', $username);
                            $stmt->execute();

                            // Обновление интерфейса: перезагрузка страницы
                            header("Location: dashboard-admin.php");
                            exit;
                        } catch (PDOException $e) {
                            echo "Ошибка при выполнении запроса: " . $e->getMessage();
                        }
                    }
                }
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    } else {
        // Если текущий пользователь не является заведующим, перенаправляем на другую страницу
        redirectByRole($role);
    }
}