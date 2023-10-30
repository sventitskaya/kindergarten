<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($conn) && isset($_GET['group_id'])) {
        try {
            $groupId = $_GET['group_id'];
            $deleteGroupQuery = "DELETE FROM ChildrenGroups WHERE group_id = :groupId";
            $stmt = $conn->prepare($deleteGroupQuery);
            $stmt->bindParam(':groupId', $groupId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }

        // Перенаправляем обратно на страницу dashboard-admin.php
        header("Location: ../dashboard-admin.php");
        exit;
    }
}
?>
