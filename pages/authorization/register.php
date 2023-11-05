<?php
include('../../src/db-config.php'); // Подключаем конфигурацию базы данных

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newUsername = $_POST['newUsername'];
    $newPassword = $_POST['newPassword'];
    // Генерация хеша пароля
//    $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $passwordHash = hash("sha256", $newPassword);
    $newEmail = $_POST['newEmail'];
    $firstName = $_POST['firstName'];
    $middleName = $_POST['middleName'];
    $lastName = $_POST['lastName'];
    $address = $_POST['address'];
    $contactPhone = $_POST['contactPhone'];

    if (isset($conn)) {
        try {
            // Получение role_id по имени роли (в данном случае, 'Родитель')
            $roleName = 'Родитель';
            $getRoleIdQuery = "SELECT role_id FROM Roles WHERE role_name = :roleName";
            $stmt = $conn->prepare($getRoleIdQuery);
            $stmt->bindParam(':roleName', $roleName);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $role_id = $row['role_id'];

            // Проверка, существует ли уже имя пользователя или email
            $checkUserQuery = "SELECT * FROM Users WHERE username = :newUsername OR email = :newEmail";
            $stmt = $conn->prepare($checkUserQuery);
            $stmt->bindParam(':newUsername', $newUsername);
            $stmt->bindParam(':newEmail', $newEmail);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Пользователь с таким именем уже существует.";
            } else {
                // Вставка новой записи о пользователе
                $insertUserQuery = "INSERT INTO Users (username, password, email, first_name, middle_name, last_name, contact_phone, address, role_id) VALUES (:newUsername, :passwordHash, :newEmail, :firstName, :middleName, :lastName, :contactPhone, :address, :role_id)";
                $stmt = $conn->prepare($insertUserQuery);
                $stmt->bindParam(':newUsername', $newUsername);
                $stmt->bindParam(':passwordHash', $passwordHash);
                $stmt->bindParam(':newEmail', $newEmail);
                $stmt->bindParam(':firstName', $firstName);
                $stmt->bindParam(':middleName', $middleName);
                $stmt->bindParam(':lastName', $lastName);
                $stmt->bindParam(':contactPhone', $contactPhone);
                $stmt->bindParam(':address', $address);
                $stmt->bindParam(':role_id', $role_id);
                $stmt->execute();

                // Получение идентификатора вновь созданного пользователя
                $userId = $conn->lastInsertId();

                // Добавление заявки на регистрацию для нового пользователя
                $insertRequestQuery = "INSERT INTO RegistrationRequests (user_id, status) VALUES (:userId, 'Pending')";
                $stmt = $conn->prepare($insertRequestQuery);
                $stmt->bindParam(':userId', $userId);
                $stmt->execute();

                echo "Регистрация успешно завершена. <a href='login.php'>Войти</a>";
            }
        } catch
        (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Регистрация</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../../styles/main.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/login.scss">
</head>
<body>
<h2>Регистрация</h2>
<form method="post" action="">
    <input type="text" name="newUsername" placeholder="Имя пользователя" required><br><br>
    <input type="password" name="newPassword" placeholder="Пароль" required><br><br>
    <input type="email" name="newEmail" placeholder="Адрес электронной почты" required><br><br>
    <input type="text" name="lastName" placeholder="Фамилия" required><br><br>
    <input type="text" name="firstName" placeholder="Имя" required><br><br>
    <input type="text" name="middleName" placeholder="Отчество" required><br><br>
    <input type="text" name="address" placeholder="Адрес" required><br><br>
    <input type="tel" name="contactPhone" placeholder="Номер телефона" required><br><br>
    <input type="submit" value="Зарегистрироваться">
</form>
<a href='login.php'>Вернуться назад</a>
</body>
</html>
