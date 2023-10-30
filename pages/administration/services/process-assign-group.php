<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($conn)) {
        try {
            $groupId = $_POST['childrenGroupName'];
            $childId = $_POST['childId'];

            $updateGroupQuery = "UPDATE Children SET group_id = :groupId WHERE child_id = :childId";
            $stmt = $conn->prepare($updateGroupQuery);
            $stmt->bindParam(':groupId', $groupId);
            $stmt->bindParam(':childId', $childId);

            if ($stmt->execute()) {
                // Перенаправляем обратно на страницу dashboard-admin.php
                header('Location: ../dashboard-admin.php');
                exit;
            } else {
                echo "Ошибка при добавлении записи в таблицу Children.";
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}
?>
