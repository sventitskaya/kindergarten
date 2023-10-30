<?php
include('../../../src/auth-guard.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $teacherLastName = $_POST['teacherLastName'];
    $teacherFirstName = $_POST['teacherFirstName'];
    $teacherMiddleName = $_POST['teacherMiddleName'];
    $teacherAddress = $_POST['teacherAddress'];
    $teacherPhone = $_POST['teacherPhone'];
    $teacherUsername = $_POST['teacherUsername'];
    $teacherPassword = $_POST['teacherPassword'];
    $passwordHash = hash("sha256", $teacherPassword);
    $teacherEmail = $_POST['teacherEmail'];

    if (isset($conn)) {
        try {
            // Получение role_id по имени роли (в данном случае, 'Учитель')
            $roleName = 'Учитель';
            $getRoleIdQuery = "SELECT role_id FROM Roles WHERE role_name = :roleName";
            $stmt = $conn->prepare($getRoleIdQuery);
            $stmt->bindParam(':roleName', $roleName);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $role_id = $row['role_id'];

            // Проверка, существует ли уже имя пользователя или email
            $checkUserQuery = "SELECT * FROM Users WHERE username = :teacherUsername OR email = :teacherEmail";
            $stmt = $conn->prepare($checkUserQuery);
            $stmt->bindParam(':teacherUsername', $teacherUsername);
            $stmt->bindParam(':teacherEmail', $teacherEmail);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                echo "Пользователь с таким именем или адресом электронной почты уже существует.";
            } else {
                // Вставка новой записи о пользователе
                $insertUserQuery = "INSERT INTO Users (username, password, email, role_id, first_name, middle_name, last_name, address, contact_phone) VALUES (:teacherUsername, :teacherPassword, :teacherEmail, :role_id, :teacherFirstName, :teacherMiddleName, :teacherLastName, :teacherAddress, :teacherPhone)";
                $stmt = $conn->prepare($insertUserQuery);
                $stmt->bindParam(':teacherUsername', $teacherUsername);
                $stmt->bindParam(':teacherPassword', $passwordHash);
                $stmt->bindParam(':teacherEmail', $teacherEmail);
                $stmt->bindParam(':role_id', $role_id);
                $stmt->bindParam(':teacherFirstName', $teacherFirstName);
                $stmt->bindParam(':teacherMiddleName', $teacherMiddleName);
                $stmt->bindParam(':teacherLastName', $teacherLastName);
                $stmt->bindParam(':teacherAddress', $teacherAddress);
                $stmt->bindParam(':teacherPhone', $teacherPhone);

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
