<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['teacherId']; // ID пользователя, который будет редактироваться
    $teacherLastName = $_POST['teacherLastName'];
    $teacherFirstName = $_POST['teacherFirstName'];
    $teacherMiddleName = $_POST['teacherMiddleName'];
    $teacherAddress = $_POST['teacherAddress'];
    $teacherPhone = $_POST['teacherPhone'];

    if (isset($conn)) {
        try {
            $updateUserQuery = "UPDATE Users 
                                    SET first_name = :teacherFirstName, middle_name = :teacherMiddleName, last_name = :teacherLastName, 
                                    address = :teacherAddress, contact_phone = :teacherPhone 
                                    WHERE user_id = :user_id";
            $stmt = $conn->prepare($updateUserQuery);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':teacherFirstName', $teacherFirstName);
            $stmt->bindParam(':teacherMiddleName', $teacherMiddleName);
            $stmt->bindParam(':teacherLastName', $teacherLastName);
            $stmt->bindParam(':teacherAddress', $teacherAddress);
            $stmt->bindParam(':teacherPhone', $teacherPhone);

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
