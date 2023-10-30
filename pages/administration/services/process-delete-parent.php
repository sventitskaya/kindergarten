<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($conn) && isset($_GET['parent_id'])) {
        try {
            $parentId = $_GET['parent_id'];

            $deleteParentRequestQuery = "DELETE FROM RegistrationRequests WHERE user_id = :parentId;";
            $stmt = $conn->prepare($deleteParentRequestQuery);
            $stmt->bindParam(':parentId', $parentId);
            $stmt->execute();

            $deleteParentQuery = "DELETE FROM Users WHERE user_id = :parentId;";
            $stmt = $conn->prepare($deleteParentQuery);
            $stmt->bindParam(':parentId', $parentId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Ошибка  при выполнении запроса: " . $e->getMessage();
        }

        // Перенаправляем обратно на страницу dashboard-admin.php
        header("Location: ../dashboard-admin.php");
        exit;
    }
}
?>