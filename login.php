<?php
session_start();
require_once 'databaseconnect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

$login = trim($_POST['login'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($login === '' || $password === '') {
    $_SESSION['login_error'] = 'Введите логин и пароль.';
    header('Location: index.html');
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, name, surname, email, phone, login, password, created_at FROM users WHERE login = ?");
mysqli_stmt_bind_param($stmt, "s", $login);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$user = mysqli_fetch_assoc($result);

if (!$user) {
    $_SESSION['login_error'] = 'Пользователь не найден.';
    header('Location: index.html');
    exit;
}

if ($password !== $user['password']) {
    $_SESSION['login_error'] = 'Неверный пароль.';
    header('Location: index.html');
    exit;
}

$_SESSION['user'] = [
    'id' => $user['id'],
    'name' => $user['name'],
    'surname' => $user['surname'],
    'email' => $user['email'],
    'phone' => $user['phone'],
    'login' => $user['login'],
    'registered' => date('d.m.Y', strtotime($user['created_at']))
];

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Location: account.php');
exit;
?>