<?php
include('../../../src/auth-guard.php');

if (isset($conn) && isset($role)) {
    try {
        // Вставка данных о ребенке в базу данных
        if (isset($user_id)) {
            // SQL-запрос для получения данных родителя
            $getParentQuery = "SELECT CONCAT(p.first_name, ' ', p.middle_name, ' ', p.last_name) AS full_name
                                   FROM Users p
                                   WHERE p.user_id = :user_id";
            $stmt = $conn->prepare($getParentQuery);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            $parentInfo = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($parentInfo) {
                $parent_id = $user_id; // ID родителя

                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $first_name = $_POST['childFirstName'];
                    $middle_name = $_POST['childMiddleName'];
                    $last_name = $_POST['childLastName'];
                    $birth_date = $_POST['childBirthDate'];
                    $gender = $_POST['gender'];

                    // Вставка данных о ребенке в базу данных
                    $insertChildQuery = "INSERT INTO Children (first_name, middle_name, last_name, birth_date, gender) VALUES (:first_name, :middle_name, :last_name, :birth_date, :gender)";
                    $stmt = $conn->prepare($insertChildQuery);
                    $stmt->bindParam(':first_name', $first_name);
                    $stmt->bindParam(':middle_name', $middle_name);
                    $stmt->bindParam(':last_name', $last_name);
                    $stmt->bindParam(':birth_date', $birth_date);
                    $stmt->bindParam(':gender', $gender);

                    if ($stmt->execute()) {
                        // Успешное добавление ребенка
                        $child_id = $conn->lastInsertId(); // Получаем ID добавленного ребенка

                        // Добавление записи в таблицу ParentChildRelation
                        $insertRelationQuery = "INSERT INTO ParentChildRelation (parent_id, child_id) VALUES (:parent_id, :child_id)";
                        $stmt = $conn->prepare($insertRelationQuery);
                        $stmt->bindParam(':parent_id', $parent_id);
                        $stmt->bindParam(':child_id', $child_id);

                        if ($stmt->execute()) {
                            // Успешное добавление записи в таблицу ParentChildRelation

                            $insertRequestQuery = "INSERT INTO RegistrationRequests (user_id, status) VALUES (:userId, 'Approved')";
                            $stmt = $conn->prepare($insertRequestQuery);
                            $stmt->bindParam(':userId', $parent_id);

                            if ($stmt->execute()) {
                                // Перенаправление на дашборд родителя
                                header('Location: ../dashboard-parent.php');
                                exit;
                            } else {
                                echo "Ошибка при добавлении записи в таблицу RegistrationRequests.";
                            }

                        } else {
                            // Ошибка при добавлении записи в таблицу ParentChildRelation
                            echo "Ошибка при добавлении записи в таблицу ParentChildRelation.";
                        }
                    } else {
                        // Ошибка при добавлении ребенка в детский сад
                        echo "Ошибка при добавлении ребенка в детский сад.";
                    }
                }
            }
        }
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }
}
?>
