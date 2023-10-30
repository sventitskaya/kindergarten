<?php
include 'session-helper.php';
include('db-config.php');
startSession();

if (!isset($_SESSION['username'])) {
    header('Location: ../authorization/login.php');
}

$username = $_SESSION['username'];
if (isset($conn)) {
    $role = getRoleName($conn, $username);
    $user_id = getUserId($conn, $username);
    $user_full_name = getUserFullName($conn, $username);
}

$isRole = false;
$isAdmin = false;
$isEducator = false;
$isTeacher = false;
if (isset($role)) {
    $isRole = true;
    switch ($role) {
        case 'Заведующая':
            $isAdmin = true;
            break;
        case 'Воспитатель':
            $isEducator = true;
            break;
        case 'Учитель':
            $isTeacher = true;
            break;
    }
}

function getRoleName($conn, $username): string
{
    try {
        // Запрос роли пользователя
        $selectRoleQuery = "SELECT r.role_name
                            FROM Users u
                            INNER JOIN Roles r ON u.role_id = r.role_id
                            WHERE u.username = :username";
        $stmt = $conn->prepare($selectRoleQuery);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['role_name']) {
            return $row['role_name'];
        }
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }

    return "";
}

function getUserId($conn, $username): string
{
    try {
        // Запрос пользователя
        $selectUserQuery = "SELECT u.user_id
                            FROM Users u
                            WHERE u.username = :username";
        $stmt = $conn->prepare($selectUserQuery);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['user_id']) {
            return $row['user_id'];
        }
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }

    return "";
}

function getUserFullName($conn, $username): string
{
    try {
        // Запрос пользователя
        $selectUserQuery = "SELECT CONCAT(u.first_name, ' ', u.middle_name, ' ', u.last_name) AS full_name
                            FROM Users u
                            WHERE u.username = :username";
        $stmt = $conn->prepare($selectUserQuery);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && $row['full_name']) {
            return $row['full_name'];
        }
    } catch (PDOException $e) {
        echo "Ошибка при выполнении запроса: " . $e->getMessage();
    }

    return "";
}