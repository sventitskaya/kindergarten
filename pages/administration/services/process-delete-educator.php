<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($conn) && isset($_GET['educator_id'])) {
        try {
            $educatorId = $_GET['educator_id'];

            $deleteEducatorQuery = "UPDATE Users 
                                    SET role_id = (SELECT role_id FROM Roles WHERE role_name = 'Родитель') 
                                    WHERE user_id = :educatorId;";
            $stmt = $conn->prepare($deleteEducatorQuery);
            $stmt->bindParam(':educatorId', $educatorId);
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
