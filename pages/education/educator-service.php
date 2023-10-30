<?php
include('../../src/auth-guard.php'); // Проверка авторизации воспитателя
include '../../src/redirect-guard.php';

if (isset($conn) && isset($role) && isset($isTeacher) && isset($isEducator) && isset($isAdmin)) {
    if ($isTeacher || $isEducator || $isAdmin) {
        try {
            if ($isEducator) {
                // Получаем список групп, привязанных к воспитателю
                $getGroupsQuery = "SELECT g.group_id, g.group_name 
                                   FROM ChildrenGroups g
                                   WHERE g.educator_id = :educatorId";
                $stmt = $conn->prepare($getGroupsQuery);
                $stmt->bindParam(':educatorId', $user_id);
                $stmt->execute();
                $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if ($isTeacher) {
                // Получаем список групп
                $getGroupsQuery = "SELECT g.group_id, g.group_name FROM ChildrenGroups g";
                $stmt = $conn->prepare($getGroupsQuery);
                $stmt->execute();
                $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if ($isAdmin) {
                // Получите список учителей/воспитателей из вашей базы данных
                $getTeachersQuery = "SELECT user_id, 
                                            CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name 
                                     FROM Users 
                                     WHERE role_id IN (SELECT role_id 
                                                       FROM Roles 
                                                       WHERE role_name = 'Воспитатель' OR role_name = 'Учитель')";
                $stmt = $conn->prepare($getTeachersQuery);
                $stmt->execute();
                $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Получаем список всех групп
                $getGroupsQuery = "SELECT g.group_id, g.group_name FROM ChildrenGroups g";
                $stmt = $conn->prepare($getGroupsQuery);
                $stmt->execute();
                $groups = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            // Обработка отправки формы для обновления учителя/воспитателя
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateTeacher']) && $isAdmin) {
                $lessonId = $_POST['lessonId'];
                $selectedTeacher = $_POST['teacherId'];

                // Обновление учителя/воспитателя для занятия
                $updateTeacherQuery = "UPDATE Lessons SET teacher_id = :teacherId WHERE lesson_id = :lessonId";
                $stmt = $conn->prepare($updateTeacherQuery);
                $stmt->bindParam(':teacherId', $selectedTeacher);
                $stmt->bindParam(':lessonId', $lessonId);

                if ($stmt->execute()) {
                    echo "Учитель/воспитатель для занятия успешно обновлен.";
                } else {
                    echo "Ошибка при обновлении учителя/воспитателя для занятия.";
                }
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    } else {
        // Если текущий пользователь не является воспитателем или заведующим, перенаправляем на другую страницу
        redirectByRole($role);
    }
}