<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($conn) && isset($_GET['lesson_id'])) {
        try {
            $lessonId = $_GET['lesson_id'];
            $deleteLessonGroupQuery = "DELETE FROM LessonGroupRelation WHERE lesson_id = :lessonId;";
            $stmt = $conn->prepare($deleteLessonGroupQuery);
            $stmt->bindParam(':lessonId', $lessonId);
            $stmt->execute();

            $deleteLessonQuery = "DELETE FROM Lessons WHERE lesson_id = :lessonId;";
            $stmt = $conn->prepare($deleteLessonQuery);
            $stmt->bindParam(':lessonId', $lessonId);
            $stmt->execute();
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }

        // Перенаправляем обратно на страницу dashboard-educator.php
        header("Location: ../dashboard-educator.php");
        exit;
    }
}
?>
