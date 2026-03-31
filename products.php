<?php
require_once 'databaseconnect.php';

$sort = $_GET['sort'] ?? 'id';

$allowedSort = ['id', 'name', 'price', 'available'];
if (!in_array($sort, $allowedSort)) {
    $sort = 'id';
}

$sql = "SELECT * FROM product ORDER BY $sort";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Товары из БД</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="main-content" style="max-width:1200px; margin:30px auto;">
        <h1>Товары из базы данных</h1>

        <p>
            Сортировать:
            <a href="products.php?sort=id">по ID</a> |
            <a href="products.php?sort=name">по названию</a> |
            <a href="products.php?sort=price">по цене</a> |
            <a href="products.php?sort=available">по доступности</a>
        </p>

        <p>
            <a href="add_product.php">Добавить товар</a>
        </p>

        <table class="info-table">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Краткое описание</th>
                <th>Цена</th>
                <th>Доступность</th>
                <th>Изображение</th>
                <th>Действие</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['short_description']) ?></td>
                    <td><?= number_format($row['price'], 2, '.', ' ') ?></td>
                    <td><?= $row['available'] ? 'Есть' : 'Нет' ?></td>
                    <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="" width="80"></td>
                    <td>
                    <a href="edit_product.php?id=<?= $row['id'] ?>">Редактировать</a> |
                    <a href="delete_product.php?id=<?= $row['id'] ?>" onclick="return confirm('Удалить товар?');">Удалить</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
<?php mysqli_close($conn); ?>