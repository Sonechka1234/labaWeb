<?php
require_once 'db.php';

$search_q = '';
$result_data = [];
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $search_q = trim($_POST["search_q"] ?? '');
    $search_q = strip_tags($search_q);

    if ($search_q === '') {
        $error = 'Введите первую букву названия товара.';
    } else {
        $first_letter = mb_substr($search_q, 0, 1, 'UTF-8');
        $first_letter = mb_strtoupper($first_letter, 'UTF-8');
        $search_like = $first_letter . '%';

        $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE name LIKE ?");

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $search_like);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_assoc($res)) {
                $result_data[] = $row;
            }

            mysqli_stmt_close($stmt);

            if (count($result_data) > 0) {
                $success = 'Найдено товаров: ' . count($result_data);
            } else {
                $error = 'По вашему запросу товары не найдены.';
            }
        } else {
            $error = 'Ошибка подготовки SQL-запроса.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск товара - Сити-Класс</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="images/logo.png" alt="Логотип Сити-Класс" width="120">
        </div>
        <div class="site-name">СИТИ-КЛАСС</div>
        <div class="login-form">
            <form action="#" method="post">
                <label>логин: <input type="text" name="login"></label><br>
                <label>пароль: <input type="password" name="password"></label><br>
                <a href="register.html" class="register-link">регистрация</a>
                <button type="submit">войти</button>
            </form>
        </div>
    </header>

    <nav class="top-menu">
        <a href="index.html">🏠 Главная</a>
        <a href="catalog.html">👟 Наша обувь</a>
        <a href="about.html">🏢 О магазине</a>
        <a href="contacts.html">📞 Контакты</a>
        <a href="feedback.html">📝 Отзывы</a>
    </nav>

    <div class="container">
        <aside class="left-sidebar">
            <h3>📋 Меню</h3>
            <ul class="side-menu">
                <li><a href="index.html">🏠 Главная</a></li>
                <li><a href="catalog.html">👟 Каталог</a></li>
                <li><a href="about.html">🏢 О нас</a></li>
                <li><a href="contacts.html">📞 Контакты</a></li>
                <li><a href="feedback.html">📝 Отзывы</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <h1>ПОИСК ТОВАРА</h1>
            <hr>

            <form class="search-form" method="post" action="search.php">
                <label>Введите первую букву названия товара:
                    <input
                        type="search"
                        name="search_q"
                        value="<?= htmlspecialchars($search_q) ?>"
                        placeholder="Например: К"
                        maxlength="50"
                        required
                    >
                </label>
                <button type="submit">Поиск</button>
            </form>

            <?php if ($error): ?>
                <div class="error-message show"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success-message show"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <?php if (!empty($result_data)): ?>
                <h2>Результаты поиска</h2>

                <?php foreach ($result_data as $product): ?>
                    <div class="search-result-card">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>

                        <a href="<?= htmlspecialchars($product['page_link']) ?>">
                            <img
                                src="<?= htmlspecialchars($product['image']) ?>"
                                alt="<?= htmlspecialchars($product['name']) ?>"
                                width="250"
                                class="product-image"
                            >
                        </a>

                        <p class="short-description">
                            <strong>Краткое описание:</strong>
                            <?= htmlspecialchars($product['short_description']) ?>
                        </p>

                        <p class="search-full-description">
                            <strong>Подробное описание:</strong>
                            <?= htmlspecialchars($product['full_description']) ?>
                        </p>

                        <p class="search-full-description">
                            <strong>Характеристики:</strong>
                            <?= htmlspecialchars($product['characteristics']) ?>
                        </p>

                        <p class="price-big">
                            <strong>Цена:</strong>
                            <?= number_format($product['price'], 0, '', ' ') ?> руб.
                        </p>

                        <p>
                            <a href="<?= htmlspecialchars($product['page_link']) ?>">Перейти на страницу товара</a>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </main>

        <aside class="right-sidebar">
            <div class="banner">
                <a href="delivery.html">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxbGjbxj0oPxJz_Dk8G3tuIlVLmPiE_x8_SQ&s"
                         alt="Бесплатная доставка" width="180">
                    <p>🚚 Бесплатная доставка</p>
                </a>
            </div>

            <div class="banner">
                <a href="catalog.html">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8Yhd3NrRexdGSo1C6mSpyZUZh2gEGNKq3og&s"
                         alt="Новая коллекция" width="180">
                    <p>✨ Новая коллекция</p>
                </a>
            </div>

            <div class="banner">
                <a href="discounts.html">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2Howx1kBT1KffR3kuPvFpRAb6RnygHH73ow&s"
                         alt="Скидки 50%" width="180">
                    <p>🔥 Скидки 50%</p>
                </a>
            </div>
        </aside>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Сити-Класс. Все права защищены</p>
    </footer>
</body>
</html>

<?php mysqli_close($conn); ?>