<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $groupName = $_POST['groupName'];
    $educatorId = $_POST['educatorName'];

    if (isset($conn)) {
        try {
            // Проверка, существует ли уже группа с таким названием
            $checkGroupQuery = "SELECT * FROM ChildrenGroups WHERE group_name = :groupName";
            $stmt = $conn->prepare($checkGroupQuery);
            $stmt->bindParam(':groupName', $groupName);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Группа с таким названием уже существует.";
            } else {
                // Вставка новой записи о группе
                $insertGroupQuery = "INSERT INTO ChildrenGroups (group_name, educator_id) VALUES (:groupName, :educatorId)";
                $stmt = $conn->prepare($insertGroupQuery);
                $stmt->bindParam(':groupName', $groupName);
                $stmt->bindParam(':educatorId', $educatorId);
                if ($stmt->execute()) {
                    header('Location: ../dashboard-admin.php');
                    exit;
                } else {
                    echo "Ошибка при добавлении записи в таблицу ChildrenGroups.";
                }
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}
?>
