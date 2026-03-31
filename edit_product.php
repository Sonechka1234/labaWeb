<?php
require_once 'databaseconnect.php';

$id = (int)($_GET['id'] ?? 0);
$message = '';

if ($id <= 0) {
    die('Некорректный ID товара');
}

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

    $stmt = mysqli_prepare($conn, "UPDATE product SET
        manufacturer_id = ?,
        name = ?,
        alias = ?,
        short_description = ?,
        description = ?,
        price = ?,
        image = ?,
        available = ?,
        meta_keywords = ?,
        meta_description = ?,
        meta_title = ?
        WHERE id = ?");

    mysqli_stmt_bind_param(
        $stmt,
        "issssdsisssi",
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
        $meta_title,
        $id
    );

    if (mysqli_stmt_execute($stmt)) {
        $message = "Товар успешно обновлён.";
    } else {
        $message = "Ошибка при обновлении товара.";
    }

    mysqli_stmt_close($stmt);
}

$res = mysqli_query($conn, "SELECT * FROM product WHERE id = $id");
$product = mysqli_fetch_assoc($res);

if (!$product) {
    die('Товар не найден');
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать товар</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="main-content" style="max-width:900px; margin:30px auto;">
    <h1>Редактирование товара</h1>
    <p><a href="products.php">Назад к списку товаров</a></p>

    <?php if ($message): ?>
        <div class="success-message show"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>ID производителя:
            <input type="number" name="manufacturer_id" value="<?= htmlspecialchars($product['manufacturer_id']) ?>" required>
        </label>

        <label>Название:
            <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
        </label>

        <label>Alias:
            <input type="text" name="alias" value="<?= htmlspecialchars($product['alias']) ?>" required>
        </label>

        <label>Краткое описание:
            <textarea name="short_description" required><?= htmlspecialchars($product['short_description']) ?></textarea>
        </label>

        <label>Полное описание:
            <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        </label>

        <label>Цена:
            <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>
        </label>

        <label>Изображение:
            <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" required>
        </label>

        <label>Доступность:
            <select name="available">
                <option value="1" <?= $product['available'] == 1 ? 'selected' : '' ?>>Есть</option>
                <option value="0" <?= $product['available'] == 0 ? 'selected' : '' ?>>Нет</option>
            </select>
        </label>

        <label>Meta keywords:
            <input type="text" name="meta_keywords" value="<?= htmlspecialchars($product['meta_keywords']) ?>" required>
        </label>

        <label>Meta description:
            <input type="text" name="meta_description" value="<?= htmlspecialchars($product['meta_description']) ?>" required>
        </label>

        <label>Meta title:
            <input type="text" name="meta_title" value="<?= htmlspecialchars($product['meta_title']) ?>" required>
        </label>

        <button type="submit">Сохранить изменения</button>
    </form>
</div>
</body>
</html>
<?php mysqli_close($conn); ?>