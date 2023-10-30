<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($conn) && isset($_GET['child_id'])) {
        try {
            $childId = $_GET['child_id'];

            $deleteChildParentLinkQuery = "DELETE FROM ParentChildRelation
                                    WHERE child_id = :childId;";
            $stmt = $conn->prepare($deleteChildParentLinkQuery);
            $stmt->bindParam(':childId', $childId);
            $stmt->execute();

            $deleteChildQuery = "DELETE FROM Children
                                    WHERE child_id = :childId;";
            $stmt = $conn->prepare($deleteChildQuery);
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
