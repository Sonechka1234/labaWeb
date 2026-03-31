<?php
require_once 'databaseconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $advantages = isset($_POST['plus']) ? implode(', ', $_POST['plus']) : '';
    $notifications = isset($_POST['notify']) ? 'Да' : 'Нет';
    $rating = (int)($_POST['rating'] ?? 0);
    $brand = trim($_POST['brand'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($username === '' || $email === '' || $message === '') {
        echo "Ошибка: заполнены не все обязательные поля.";
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO feedback
        (username, email, gender, advantages, notifications, rating, brand, city, message)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param(
        $stmt,
        "sssssisss",
        $username,
        $email,
        $gender,
        $advantages,
        $notifications,
        $rating,
        $brand,
        $city,
        $message
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "Ошибка при сохранении отзыва.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>