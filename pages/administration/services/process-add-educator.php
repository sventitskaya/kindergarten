<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $educatorLastName = $_POST['educatorLastName'];
    $educatorFirstName = $_POST['educatorFirstName'];
    $educatorMiddleName = $_POST['educatorMiddleName'];
    $educatorAddress = $_POST['educatorAddress'];
    $educatorPhone = $_POST['educatorPhone'];
    $educatorUsername = $_POST['educatorUsername'];
    $educatorPassword = $_POST['educatorPassword'];
    $passwordHash = hash("sha256", $educatorPassword);
    $educatorEmail = $_POST['educatorEmail'];

    if (isset($conn)) {
        try {
            // Получение role_id по имени роли (в данном случае, 'Воспитатель')
            $roleName = 'Воспитатель';
            $getRoleIdQuery = "SELECT role_id FROM Roles WHERE role_name = :roleName";
            $stmt = $conn->prepare($getRoleIdQuery);
            $stmt->bindParam(':roleName', $roleName);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $role_id = $row['role_id'];

            // Проверка, существует ли уже имя пользователя или email
            $checkUserQuery = "SELECT * FROM Users WHERE username = :educatorUsername OR email = :educatorEmail";
            $stmt = $conn->prepare($checkUserQuery);
            $stmt->bindParam(':educatorUsername', $educatorUsername);
            $stmt->bindParam(':educatorEmail', $educatorEmail);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Пользователь с таким именем или адресом электронной почты уже существует.";
            } else {
                // Вставка новой записи о пользователе
                $insertUserQuery = "INSERT INTO Users (username, password, email, role_id, first_name, middle_name, last_name, address, contact_phone) VALUES (:educatorUsername, :educatorPassword, :educatorEmail, :role_id, :educatorFirstName, :educatorMiddleName, :educatorLastName, :educatorAddress, :educatorPhone)";
                $stmt = $conn->prepare($insertUserQuery);
                $stmt->bindParam(':educatorUsername', $educatorUsername);
                $stmt->bindParam(':educatorPassword', $passwordHash);
                $stmt->bindParam(':educatorEmail', $educatorEmail);
                $stmt->bindParam(':role_id', $role_id);
                $stmt->bindParam(':educatorFirstName', $educatorFirstName);
                $stmt->bindParam(':educatorMiddleName', $educatorMiddleName);
                $stmt->bindParam(':educatorLastName', $educatorLastName);
                $stmt->bindParam(':educatorAddress', $educatorAddress);
                $stmt->bindParam(':educatorPhone', $educatorPhone);

                if ($stmt->execute()) {
                    header('Location: ../dashboard-admin.php');
                    exit;
                } else {
                    echo "Ошибка при добавлении записи в таблицу Users.";
                }
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}
?>
