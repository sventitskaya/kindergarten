<?php
include '../../src/session-helper.php';
startSession();
include '../../src/db-config.php';
include '../../src/redirect-guard.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($conn)) {
        try {
            $selectUserQuery = "SELECT u.user_id, u.username, u.password, r.role_name
                            FROM Users u
                            INNER JOIN Roles r ON u.role_id = r.role_id
                            WHERE u.username = :username";
            $stmt = $conn->prepare($selectUserQuery);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $hashedPassword = $row['password'];
//                if (password_verify($password, $hashedPassword)) {
                if (hash_equals($hashedPassword, hash("sha256", $password))) {
                    if ($row['role_name'] === 'Родитель') {
                        // Проверка наличия запроса на регистрацию в статусе "Pending"
                        $selectRequestQuery = "SELECT status FROM RegistrationRequests WHERE user_id = :userId";
                        $stmt = $conn->prepare($selectRequestQuery);
                        $stmt->bindParam(':userId', $row['user_id']);
                        $stmt->execute();

                        $requestRow = $stmt->fetch(PDO::FETCH_ASSOC);
                        if ($requestRow !== false) {
                            if ($requestRow['status'] === 'Pending') {
                                echo "Ваш запрос на регистрацию ожидает одобрения администратора. Статус запроса: " . $requestRow['status'];
                            } else {
                                $_SESSION['username'] = $username;
                                redirectByRole($row['role_name']);
                            }
                        } else {
                            echo "Данные запроса не найдены.";
                        }
                    } else {
                        $_SESSION['username'] = $username;
                        redirectByRole($row['role_name']);
                    }
                } else {
                    echo "Неверное имя пользователя или пароль.";
                }
            } else {
                echo "Неверное имя пользователя или пароль.";
            }
        } catch (PDOException $e) {
            echo "Ошибка при выполнении запроса: " . $e->getMessage();
        }
    }
}