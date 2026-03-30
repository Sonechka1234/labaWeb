<?php
// ========================================
// ПОИСК ТОВАРОВ ПО САЙТУ
// Лабораторная работа №2
// ========================================

// Многомерный массив с информацией о товарах
$products = array(
    array(
        'id' => 1,
        'name' => 'Кроссовки Winx',
        'category' => 'Кроссовки',
        'price' => '6 990 ₽',
        'description' => 'Стильные и удобные кроссовки Winx для повседневной носки. Яркий дизайн и комфорт для активных девушек.',
        'characteristics' => array(
            'Материал верха' => 'Искусственная кожа + текстиль',
            'Подкладка' => 'Текстиль',
            'Подошва' => 'Резина',
            'Размеры' => '36-40',
            'Цвет' => 'Розово-белый',
            'Вес' => '320г (пара)'
        ),
        'image' => 'https://main-cdn.sbermegamarket.ru/big3/hlr-system/1718471/100023595181b0.jpeg',
        'page' => 'product1.html'
    ),
    array(
        'id' => 2,
        'name' => 'Туфли Jimmy Choo',
        'category' => 'Туфли',
        'price' => '45 000 ₽',
        'description' => 'Роскошные туфли от всемирно известного бренда Jimmy Choo. Идеальны для особых случаев.',
        'characteristics' => array(
            'Материал верха' => 'Натуральная кожа',
            'Подкладка' => 'Натуральная кожа',
            'Подошва' => 'Кожаная',
            'Высота каблука' => '10 см',
            'Размеры' => '36-40',
            'Цвет' => 'Чёрный'
        ),
        'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCWnZlhwdnYp6D5s_tsuk-3BUat7rwuiM98g&s',
        'page' => 'product2.html'
    ),
    array(
        'id' => 3,
        'name' => 'Туфли Valentino',
        'category' => 'Туфли',
        'price' => '38 500 ₽',
        'description' => 'Элегантные туфли от итальянского дома моды Valentino. Утончённый дизайн и безупречное качество.',
        'characteristics' => array(
            'Материал верха' => 'Натуральная кожа',
            'Подкладка' => 'Кожа',
            'Подошва' => 'Кожаная',
            'Высота каблука' => '8.5 см',
            'Размеры' => '36-41',
            'Цвет' => 'Nude (бежевый)'
        ),
        'image' => 'https://www.yoox.com/images/items/17/17568014NC_14_f.jpg?impolicy=crop&width=387&height=490',
        'page' => 'product3.html'
    ),
    array(
        'id' => 4,
        'name' => 'Тапочки Victoria\'s Secret',
        'category' => 'Тапочки',
        'price' => '3 200 ₽',
        'description' => 'Мягкие и уютные тапочки от Victoria\'s Secret. Идеальны для домашнего использования.',
        'characteristics' => array(
            'Материал верха' => 'Искусственный мех',
            'Подкладка' => 'Мягкий флис',
            'Подошва' => 'Нескользящая резина',
            'Размеры' => '36-40',
            'Цвет' => 'Розовый',
            'Вес' => '180г (пара)'
        ),
        'image' => 'https://angelsshop.com.ua/content/images/50/825x1100l85nn0/kaptsi-pink-faux-fur-closed-toe-slippersid-25014762295791.jpg',
        'page' => 'product4.html'
    )
);

// Ассоциированный массив для быстрого поиска по названию
$productNames = array(
    'кроссовки' => 0,
    'winx' => 0,
    'туфли' => 1,
    'jimmy' => 1,
    'choo' => 1,
    'valentino' => 2,
    'тапочки' => 3,
    'victoria' => 3,
    'secret' => 3
);

// Получаем и обрабатываем поисковый запрос
$searchQuery = '';
$searchResults = array();
$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Валидация: получаем и очищаем запрос
    $searchQuery = isset($_POST['search_q']) ? trim($_POST['search_q']) : '';
    $searchQuery = htmlspecialchars($searchQuery); // Защита от XSS
    
    // Валидация: проверка на пустоту
    if (empty($searchQuery)) {
        $errorMessage = '⚠️ Введите поисковый запрос!';
    } else {
        // Поиск по массиву товаров
        $searchQueryLower = mb_strtolower($searchQuery);
        
        foreach ($products as $index => $product) {
            $productNameLower = mb_strtolower($product['name']);
            $productCategoryLower = mb_strtolower($product['category']);
            
            // Ищем совпадения в названии или категории
            if (strpos($productNameLower, $searchQueryLower) !== false || 
                strpos($productCategoryLower, $searchQueryLower) !== false ||
                isset($productNames[$searchQueryLower])) {
                $searchResults[] = $product;
            }
        }
        
        // Если ничего не найдено
        if (empty($searchResults)) {
            $errorMessage = '❌ По запросу "' . $searchQuery . '" ничего не найдено.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск товаров - Сити-Класс</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Ваш style.css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Шапка сайта -->
    <header class="header">
        <div class="logo">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRvd-KsgNyl7pBfn2IEu7-Uu8fhbkM8LjqYvQ&s" 
                 alt="Логотип Winx" width="140">
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

    <!-- Навигационное меню -->
    <nav class="top-menu">
        <a href="index.html">🏠 Главная</a>
        <a href="catalog.html">👟 Наша обувь</a>
        <a href="about.html">🏢 О магазине</a>
        <a href="contacts.html">📞 Контакты</a>
    </nav>

    <div class="container">
        <!-- Левое меню -->
        <aside class="left-sidebar">
            <h3>📋 Меню</h3>
            <ul class="side-menu">
                <li><a href="index.html">🏠 Главная</a></li>
                <li><a href="catalog.html">👟 Каталог</a></li>
                <li><a href="about.html">🏢 О нас</a></li>
                <li><a href="contacts.html">📞 Контакты</a></li>
            </ul>
            
            <!-- Форма поиска -->
            <h3>🔍 Поиск</h3>
            <form name="f1" method="post" action="search.php" class="search-form">
                <input type="search" name="search_q" placeholder="Введите название товара" 
                       value="<?php echo htmlspecialchars($searchQuery); ?>" class="form-control">
                <br>
                <input type="submit" value="Поиск" class="btn btn-primary w-100">
            </form>
        </aside>

        <!-- Основной контент -->
        <main class="main-content">
            <h1>🔍 ПОИСК ТОВАРОВ</h1>
            <hr>
            
            <?php if ($errorMessage): ?>
                <div class="alert alert-danger">
                    <?php echo $errorMessage; ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($searchResults)): ?>
                <h2>Найдено товаров: <?php echo count($searchResults); ?></h2>
                
                <div class="catalog-grid">
                    <?php foreach ($searchResults as $product): ?>
                        <div class="product-card">
                            <a href="<?php echo $product['page']; ?>">
                                <img src="<?php echo $product['image']; ?>" 
                                     alt="<?php echo $product['name']; ?>" 
                                     width="200" height="150">
                                <h3><?php echo $product['name']; ?></h3>
                                <p class="price"><?php echo $product['price']; ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($errorMessage)): ?>
                <div class="alert alert-info">
                    📝 Введите первую букву или название товара для поиска.
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <h3>Как пользоваться поиском:</h3>
                    <ul>
                        <li>Введите первую букву названия товара (например, "К" для кроссовок)</li>
                        <li>Или введите полное название (например, "Winx", "Valentino")</li>
                        <li>Или категорию товара (например, "Туфли", "Тапочки")</li>
                    </ul>
                </div>
                
                <h3>Все товары нашего каталога:</h3>
                <div class="catalog-grid">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <a href="<?php echo $product['page']; ?>">
                                <img src="<?php echo $product['image']; ?>" 
                                     alt="<?php echo $product['name']; ?>" 
                                     width="200" height="150">
                                <h3><?php echo $product['name']; ?></h3>
                                <p class="price"><?php echo $product['price']; ?></p>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </main>

        <!-- Правое меню с баннерами -->
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

    <!-- Подвал -->
    <footer class="footer">
        <p>&copy; 2026 Сити-Класс. Все права защищены</p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>