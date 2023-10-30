<?php
include 'login-service.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Вход</title>
    <link rel="stylesheet" type="text/css" href="../../styles/main.scss">
    <link rel="stylesheet" type="text/css" href="../../styles/login.scss">
</head>
<body>
<h2>Вход</h2>
<form method="post" action="">
    <input type="text" name="username" placeholder="Имя пользователя" required><br><br>
    <input type="password" name="password" placeholder="Пароль" required><br><br>
    <input type="submit" value="Войти">
</form>
<a href="register.php">Зарегистрироваться</a>
<?php if (isset($error_message)) echo $error_message; ?>
</body>
</html>
