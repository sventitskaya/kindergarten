<?php
include('../../../src/auth-guard.php');
if (isset($conn) && isset($isRole)) {
    try {
        // Взятие данных о существующем ребенке на основе child_id
        if (isset($user_id) && isset($_POST['childId'])) {
            $child_id = $_POST['childId'];
            // SQL-запрос для получения данных о ребенке
            $getChildQuery = "SELECT c.child_id, c.first_name, c.middle_name, c.last_name, c.birth_date, c.group_id as child_group_id
                               FROM Children c
                               INNER JOIN ParentChildRelation pcr ON c.child_id = pcr.child_id
                               WHERE pcr.parent_id = :parent_id AND c.child_id = :child_id";
            $stmt = $conn->prepare($getChildQuery);
            $stmt->bindParam(':parent_id', $user_id);
            $stmt->bindParam(':child_id', $child_id);
            $stmt->execute();

            $child = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$child) {
                // Ребенок с указанным child_id не найден или не принадлежит данному родителю
                echo "Ребенок не найден или не принадлежит вам.";
                exit;
            }

            // Обработка формы для редактирования существующего ребенка
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $first_name = $_POST['childFirstName'];
                $middle_name = $_POST['childMiddleName'];
                $last_name = $_POST['childLastName'];
                $birth_date = $_POST['childBirthDate'];

                // Проверка роли пользователя
                if (isset($isAdmin) && $isAdmin) {
                    // Поле выбора группы, доступное только администратору
                    $child_group_id = $_POST['childGroupId'];
                } else {
                    // Если пользователь не администратор, сохраняем существующую группу ребенка
                    $child_group_id = $child['child_group_id'];
                }

                // SQL-запрос для обновления данных ребенка
                $updateChildQuery = "UPDATE Children SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, birth_date = :birth_date, group_id = :child_group_id WHERE child_id = :child_id";
                $stmt = $conn->prepare($updateChildQuery);
                $stmt->bindParam(':first_name', $first_name);
                $stmt->bindParam(':middle_name', $middle_name);
                $stmt->bindParam(':last_name', $last_name);
                $stmt->bindParam(':birth_date', $birth_date);
                $stmt->bindParam(':child_group_id', $child_group_id);
                $stmt->bindParam(':child_id', $child_id);

                if ($stmt->execute()) {
                    // Успешное обновление данных ребенка

                    // Перенаправление на дашборд родителя
                    header('Location: ../dashboard-parent.php');
                    exit;
                } else {
                    // Ошибка при обновлении данных ребенка
                    echo "Ошибка при обновлении данных ребенка.";
                }
            }
        }
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }
}
?>
