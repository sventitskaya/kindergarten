<?php
include('../../../src/auth-guard.php');

if (isset($conn) && isset($role)) {
    try {
        // Обработка отправки формы для редактирования урока
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lessonId = $_POST['lessonId']; // Получаем ID урока, который нужно отредактировать
            $lessonName = $_POST['lessonName'];
            $startDatetime = $_POST['startDatetime'];
            $endDatetime = $_POST['endDatetime'];
            $selectedTeacher = $_POST['teacherName'];
            if (isset($_POST['selectedGroups'])) {
                $selectedGroups = $_POST['selectedGroups']; // Получаем выбранные группы как массив
            }

            // Обновляем данные урока в базе данных
            $updateLessonQuery = "UPDATE Lessons
                                  SET lesson_name = :lessonName, 
                                      start_datetime = :startDatetime,
                                      end_datetime = :endDatetime, 
                                      teacher_id = :teacherId
                                  WHERE lesson_id = :lessonId";
            $stmt = $conn->prepare($updateLessonQuery);
            $stmt->bindParam(':lessonName', $lessonName);
            $stmt->bindParam(':startDatetime', $startDatetime);
            $stmt->bindParam(':endDatetime', $endDatetime);
            $stmt->bindParam(':teacherId', $selectedTeacher);
            $stmt->bindParam(':lessonId', $lessonId);
            $stmt->execute();

            // Удаляем старые связи между уроком и группами
            $deleteRelationQuery = "DELETE FROM LessonGroupRelation WHERE lesson_id = :lessonId";
            $stmt = $conn->prepare($deleteRelationQuery);
            $stmt->bindParam(':lessonId', $lessonId);
            $stmt->execute();

            if (isset($selectedGroups) && count($selectedGroups) > 0) {
                // Создаем новые связи между уроком и выбранными группами
                $insertRelationQuery = "INSERT INTO LessonGroupRelation (lesson_id, group_id) VALUES (:lessonId, :groupId)";
                $stmt = $conn->prepare($insertRelationQuery);
                $stmt->bindParam(':lessonId', $lessonId);

                // Перебираем выбранные группы и создаем связи
                foreach ($selectedGroups as $groupId) {
                    $stmt->bindParam(':groupId', $groupId);
                    $stmt->execute();
                }
            }

            header('Location: ../dashboard-educator.php');
        }
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }
}
?>
