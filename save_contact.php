<?php
require_once 'databaseconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        echo "Ошибка: заполнены не все обязательные поля.";
        exit;
    }

    $stmt = mysqli_prepare($conn, "INSERT INTO contact_messages
        (name, email, subject, phone, message)
        VALUES (?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param(
        $stmt,
        "sssss",
        $name,
        $email,
        $subject,
        $phone,
        $message
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "Ошибка при сохранении сообщения.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>