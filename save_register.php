<?php
require_once 'databaseconnect.php';

header('Content-Type: text/plain; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Ошибка: неверный метод запроса.';
    exit;
}

$name = trim($_POST['name'] ?? '');
$surname = trim($_POST['surname'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');
$password_confirm = trim($_POST['password_confirm'] ?? '');

if ($name === '' || $surname === '' || $email === '' || $login === '' || $password === '' || $password_confirm === '') {
    echo 'Ошибка: заполнены не все обязательные поля.';
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Ошибка: некорректный email.';
    exit;
}

if ($password !== $password_confirm) {
    echo 'Ошибка: пароли не совпадают.';
    exit;
}

if (mb_strlen($password) < 6) {
    echo 'Ошибка: пароль должен содержать минимум 6 символов.';
    exit;
}

$checkStmt = mysqli_prepare($conn, "SELECT id FROM users WHERE login = ? OR email = ?");
mysqli_stmt_bind_param($checkStmt, "ss", $login, $email);
mysqli_stmt_execute($checkStmt);
$checkResult = mysqli_stmt_get_result($checkStmt);

if (mysqli_num_rows($checkResult) > 0) {
    echo 'Ошибка: пользователь с таким логином или email уже существует.';
    mysqli_stmt_close($checkStmt);
    mysqli_close($conn);
    exit;
}
mysqli_stmt_close($checkStmt);

$stmt = mysqli_prepare($conn, "INSERT INTO users (name, surname, email, phone, login, password) VALUES (?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssssss", $name, $surname, $email, $phone, $login, $password);

if (mysqli_stmt_execute($stmt)) {
    echo 'success';
} else {
    echo 'Ошибка при регистрации пользователя.';
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>