<?php
require_once 'databaseconnect.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $manufacturer_id = (int)$_POST['manufacturer_id'];
    $name = trim($_POST['name']);
    $alias = trim($_POST['alias']);
    $short_description = trim($_POST['short_description']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $image = trim($_POST['image']);
    $available = (int)$_POST['available'];
    $meta_keywords = trim($_POST['meta_keywords']);
    $meta_description = trim($_POST['meta_description']);
    $meta_title = trim($_POST['meta_title']);

    $stmt = mysqli_prepare($conn, "INSERT INTO product 
    (manufacturer_id, name, alias, short_description, description, price, image, available, meta_keywords, meta_description, meta_title)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    mysqli_stmt_bind_param(
        $stmt,
        "issssdsisss",
        $manufacturer_id,
        $name,
        $alias,
        $short_description,
        $description,
        $price,
        $image,
        $available,
        $meta_keywords,
        $meta_description,
        $meta_title
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Товар успешно добавлен.";
    } else {
        $message = "Ошибка при добавлении товара.";
    }

    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить товар</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-content" style="max-width:900px; margin:30px auto;">
    <h1>Добавление товара</h1>
    <p><a href="products.php">Назад к списку товаров</a></p>

    <?php if ($message): ?>
        <div class="success-message show"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>ID производителя:
            <input type="number" name="manufacturer_id" required>
        </label>

        <label>Название:
            <input type="text" name="name" required>
        </label>

        <label>Alias:
            <input type="text" name="alias" required>
        </label>

        <label>Краткое описание:
            <textarea name="short_description" required></textarea>
        </label>

        <label>Полное описание:
            <textarea name="description" required></textarea>
        </label>

        <label>Цена:
            <input type="number" step="0.01" name="price" required>
        </label>

        <label>Изображение:
            <input type="text" name="image" required>
        </label>

        <label>Доступность:
            <select name="available">
                <option value="1">Есть</option>
                <option value="0">Нет</option>
            </select>
        </label>

        <label>Meta keywords:
            <input type="text" name="meta_keywords" required>
        </label>

        <label>Meta description:
            <input type="text" name="meta_description" required>
        </label>

        <label>Meta title:
            <input type="text" name="meta_title" required>
        </label>

        <button type="submit">Добавить товар</button>
    </form>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>