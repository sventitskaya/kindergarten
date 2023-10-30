<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['educatorId']; // ID пользователя, который будет редактироваться
    $educatorLastName = $_POST['educatorLastName'];
    $educatorFirstName = $_POST['educatorFirstName'];
    $educatorMiddleName = $_POST['educatorMiddleName'];
    $educatorAddress = $_POST['educatorAddress'];
    $educatorPhone = $_POST['educatorPhone'];

    if (isset($conn)) {
        try {
            // Обновление записи о пользователе
            $updateUserQuery = "UPDATE Users 
                                    SET first_name = :educatorFirstName, middle_name = :educatorMiddleName, last_name = :educatorLastName, 
                                    address = :educatorAddress, contact_phone = :educatorPhone 
                                    WHERE user_id = :user_id";
            $stmt = $conn->prepare($updateUserQuery);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':educatorFirstName', $educatorFirstName);
            $stmt->bindParam(':educatorMiddleName', $educatorMiddleName);
            $stmt->bindParam(':educatorLastName', $educatorLastName);
            $stmt->bindParam(':educatorAddress', $educatorAddress);
            $stmt->bindParam(':educatorPhone', $educatorPhone);

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
