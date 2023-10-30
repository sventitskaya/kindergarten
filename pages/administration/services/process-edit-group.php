<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $groupId = $_POST['groupId']; // ID группы, которую вы хотите редактировать
    $groupName = $_POST['groupName']; // Новое название группы
    $educatorId = $_POST['educatorName']; // Новый идентификатор воспитателя

    if (isset($conn)) {
        try {
            // Проверка, существует ли уже группа с таким названием, исключая текущую группу
            $checkGroupQuery = "SELECT * FROM ChildrenGroups WHERE group_name = :groupName AND group_id != :groupId";
            $stmt = $conn->prepare($checkGroupQuery);
            $stmt->bindParam(':groupName', $groupName);
            $stmt->bindParam(':groupId', $groupId);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Группа с таким названием уже существует.";
            } else {
                // Обновление записи о группе
                $updateGroupQuery = "UPDATE ChildrenGroups 
                                    SET group_name = :groupName, educator_id = :educatorId 
                                    WHERE group_id = :groupId";
                $stmt = $conn->prepare($updateGroupQuery);
                $stmt->bindParam(':groupId', $groupId);
                $stmt->bindParam(':groupName', $groupName);
                $stmt->bindParam(':educatorId', $educatorId);
                if ($stmt->execute()) {
                    header('Location: ../dashboard-admin.php');
                    exit;
                } else {
                    echo "Ошибка при обновлении записи в таблице ChildrenGroups.";
                }
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}
?>
