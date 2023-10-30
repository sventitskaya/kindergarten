<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($conn) && isset($_GET['child_id'])) {
        try {
            $childId = $_GET['child_id'];
            $updateGroupQuery = "UPDATE Children SET group_id = null WHERE child_id = :childId";
            $stmt = $conn->prepare($updateGroupQuery);
            $stmt->bindParam(':childId', $childId);
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
