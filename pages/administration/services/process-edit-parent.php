<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['parentId']; // ID пользователя, который будет редактироваться
    $parentLastName = $_POST['parentLastName'];
    $parentFirstName = $_POST['parentFirstName'];
    $parentMiddleName = $_POST['parentMiddleName'];
    $parentAddress = $_POST['parentAddress'];
    $parentPhone = $_POST['parentPhone'];

    if (isset($conn)) {
        try {
            // Обновление записи о пользователе
            $updateUserQuery = "UPDATE Users 
                                    SET first_name = :parentFirstName, middle_name = :parentMiddleName, last_name = :parentLastName, 
                                    address = :parentAddress, contact_phone = :parentPhone 
                                    WHERE user_id = :user_id";
            $stmt = $conn->prepare($updateUserQuery);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':parentFirstName', $parentFirstName);
            $stmt->bindParam(':parentMiddleName', $parentMiddleName);
            $stmt->bindParam(':parentLastName', $parentLastName);
            $stmt->bindParam(':parentAddress', $parentAddress);
            $stmt->bindParam(':parentPhone', $parentPhone);

            if ($stmt->execute()) {
                header('Location: ../dashboard-admin.php');
                exit;
            } else {
                echo "Ошибка при обновлении записи в таблице Users.";
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}
?>
