<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: index.html');
    exit;
}

$user = $_SESSION['user'];

$hours = (int)date('H');
if ($hours < 12) {
    $greeting = '🌅 Доброе утро';
} elseif ($hours < 18) {
    $greeting = '☀️ Добрый день';
} else {
    $greeting = '🌙 Добрый вечер';
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - Сити-Класс</title>
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
            <form action="logout.php" method="post">
                <span style="color:white; font-weight:bold; display:block; margin-bottom:8px;">
                    <?= htmlspecialchars($user['login']) ?>
                </span>
                <button type="submit">выйти</button>
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
            <h1>ЛИЧНЫЙ КАБИНЕТ</h1>
            <hr>

            <div class="account-info">
                <h2 id="greeting"><?= $greeting ?>, <span><?= htmlspecialchars($user['name']) . ' ' . htmlspecialchars($user['surname']) ?></span>!</h2>

                <h3>📌 Ваши данные:</h3>
                <ul>
                    <li><strong>Имя:</strong> <?= htmlspecialchars($user['name']) ?></li>
                    <li><strong>Фамилия:</strong> <?= htmlspecialchars($user['surname']) ?></li>
                    <li><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></li>
                    <li><strong>Телефон:</strong> <?= htmlspecialchars($user['phone'] ?: 'Не указан') ?></li>
                    <li><strong>Логин:</strong> <?= htmlspecialchars($user['login']) ?></li>
                    <li><strong>Дата регистрации:</strong> <?= htmlspecialchars($user['registered']) ?></li>
                </ul>

                <h3>📦 Мои заказы:</h3>
                <table border="1" cellpadding="10" class="info-table">
                    <tr>
                        <th>№ заказа</th>
                        <th>Дата</th>
                        <th>Товар</th>
                        <th>Сумма</th>
                        <th>Статус</th>
                    </tr>
                    <tr>
                        <td>001</td>
                        <td>15.03.2026</td>
                        <td>Кроссовки Winx</td>
                        <td>6 990 ₽</td>
                        <td class="status-delivered">✅ Доставлен</td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>16.03.2026</td>
                        <td>Туфли Valentino</td>
                        <td>38 500 ₽</td>
                        <td class="status-processing">🔄 В обработке</td>
                    </tr>
                </table>
            </div>
        </main>

        <aside class="right-sidebar">
            <div class="banner">
                <a href="delivery.html">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQxbGjbxj0oPxJz_Dk8G3tuIlVLmPiE_x8_SQ&s" alt="Бесплатная доставка" width="180">
                    <p>🚚 Бесплатная доставка</p>
                </a>
            </div>
            <div class="banner">
                <a href="catalog.html">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT8Yhd3NrRexdGSo1C6mSpyZUZh2gEGNKq3og&s" alt="Новая коллекция" width="180">
                    <p>✨ Новая коллекция</p>
                </a>
            </div>
            <div class="banner">
                <a href="discounts.html">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2Howx1kBT1KffR3kuPvFpRAb6RnygHH73ow&s" alt="Скидки 50%" width="180">
                    <p>🔥 Скидки 50%</p>
                </a>
            </div>
        </aside>
    </div>

    <footer class="footer">
        <p>&copy; 2026 Сити-Класс. Все права защищены</p>
    </footer>
    <button class="cart" id="cart">
        <img class="cart__image" src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Cart">
        <div class="cart__num" id="cart_num">0</div>
    </button>

    <div class="popup">
        <div class="popup__container" id="popup_container">
            <div class="popup__item">
                <h1 class="popup__title">Оформление заказа</h1>
            </div>

            <div class="popup__item" id="popup_product_list"></div>

            <div class="popup__item">
                <div class="popup__cost">
                    <h2 class="popup__cost-title">Итого</h2>
                    <output class="popup__cost-value" id="popup_cost">0 ₽</output>
                </div>
                <div class="popup__cost">
                    <h2 class="popup__cost-title">Скидка</h2>
                    <output class="popup__cost-value" id="popup_discount">0 ₽</output>
                </div>
                <div class="popup__cost">
                    <h2 class="popup__cost-title">Итого со скидкой</h2>
                    <output class="popup__cost-value" id="popup_cost_discount">0 ₽</output>
                </div>

                <button class="popup__clear" id="popup_clear">Очистить корзину</button>
            </div>

            <button class="popup__close" id="popup_close">&times;</button>
        </div>
    </div>

    <script src="cart.js"></script>
</body>
</html>