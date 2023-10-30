<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($conn) && isset($_GET['teacher_id'])) {
        try {
            $teacherId = $_GET['teacher_id'];

            $deleteTeacherQuery = "UPDATE Users 
                                    SET role_id = (SELECT role_id FROM Roles WHERE role_name = 'Родитель') 
                                    WHERE user_id = :teacherId;";
            $stmt = $conn->prepare($deleteTeacherQuery);
            $stmt->bindParam(':teacherId', $teacherId);
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
