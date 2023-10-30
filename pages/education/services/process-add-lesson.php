<?php
include('../../../src/auth-guard.php');

if (isset($conn) && isset($role) && isset($user_id)) {
    try {
        // Обработка отправки формы для создания занятия
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lessonName = $_POST['lessonName'];
            $startDatetime = $_POST['startDatetime'];
            $endDatetime = $_POST['endDatetime'];
            $selectedGroups = $_POST['selectedGroups']; // Получаем выбранные группы как массив
            $selectedTeacher = $user_id;
            if ($_POST['teacherName']) {
                $selectedTeacher = $_POST['teacherName'];
            }

            // Вставка нового занятия в базу данных
            $insertLessonQuery = "INSERT INTO Lessons (lesson_name, start_datetime, end_datetime, teacher_id)
                          VALUES (:lessonName, :startDatetime, :endDatetime, :teacherId)";
            $stmt = $conn->prepare($insertLessonQuery);
            $stmt->bindParam(':lessonName', $lessonName);
            $stmt->bindParam(':startDatetime', $startDatetime);
            $stmt->bindParam(':endDatetime', $endDatetime);
            $stmt->bindParam(':teacherId', $selectedTeacher);
            $stmt->execute();

            // Получаем ID только что созданного урока
            $lessonId = $conn->lastInsertId();

            // Добавляем связи между уроком и выбранными группами
            $insertRelationQuery = "INSERT INTO LessonGroupRelation (lesson_id, group_id)
                                       VALUES (:lessonId, :groupId)";
            $stmt = $conn->prepare($insertRelationQuery);
            $stmt->bindParam(':lessonId', $lessonId);

            // Перебираем выбранные группы и создаем связи
            foreach ($selectedGroups as $groupId) {
                $stmt->bindParam(':groupId', $groupId);
                $stmt->execute();
            }

            header('Location: ../dashboard-educator.php');
        }
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }
}
?>
