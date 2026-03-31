CREATE DATABASE IF NOT EXISTS city_class
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE city_class;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    short_description TEXT NOT NULL,
    full_description TEXT NOT NULL,
    characteristics TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(500) NOT NULL,
    page_link VARCHAR(100) NOT NULL
);

INSERT INTO products (name, short_description, full_description, characteristics, price, image, page_link) VALUES
(
    'Кроссовки Winx',
    'Стильные и удобные кроссовки Winx для повседневной носки. Яркий дизайн и комфорт для активных девушек.',
    'Кроссовки Winx — это идеальное сочетание стиля и комфорта. Яркий дизайн с элементами любимых персонажей сделает ваш образ неповторимым. Удобная колодка и качественная подошва обеспечат комфорт в течение всего дня.',
    'Материал верха: Искусственная кожа + текстиль; Подкладка: Текстиль; Подошва: Резина; Размеры: 36-40; Цвет: Розово-белый; Вес: 320г (пара)',
    6990.00,
    'https://main-cdn.sbermegamarket.ru/big3/hlr-system/1718471/100023595181b0.jpeg',
    'product1.html'
),
(
    'Туфли Jimmy Choo',
    'Роскошные туфли от всемирно известного бренда Jimmy Choo. Идеальны для особых случаев и торжественных мероприятий.',
    'Туфли Jimmy Choo — это воплощение роскоши и элегантности. Легендарный бренд, любимый звёздами Голливуда, теперь доступен и вам. Безупречное качество материалов и идеальная посадка обеспечат комфорт даже при длительной носке.',
    'Материал верха: Натуральная кожа; Подкладка: Натуральная кожа; Подошва: Кожаная; Высота каблука: 10 см; Размеры: 36-40; Цвет: Чёрный',
    45000.00,
    'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSCWnZlhwdnYp6D5s_tsuk-3BUat7rwuiM98g&s',
    'product2.html'
),
(
    'Туфли Valentino',
    'Элегантные туфли от итальянского дома моды Valentino. Утончённый дизайн и безупречное качество.',
    'Туфли Valentino — это квинтэссенция итальянского стиля и мастерства. Классическая модель в нюдовых тонах станет универсальным дополнением вашего гардероба. Легендарное качество Valentino гарантирует долговечность и комфорт.',
    'Материал верха: Натуральная кожа; Подкладка: Кожа; Подошва: Кожаная; Высота каблука: 8.5 см; Размеры: 36-41; Цвет: Nude (бежевый)',
    38500.00,
    'https://www.yoox.com/images/items/17/17568014NC_14_f.jpg?impolicy=crop&width=387&height=490',
    'product3.html'
),
(
    'Тапочки Victoria''s Secret',
    'Мягкие и уютные тапочки от Victoria''s Secret. Идеальны для домашнего использования и создания атмосферы комфорта.',
    'Тапочки Victoria''s Secret — это воплощение уюта и комфорта. Мягкий искусственный мех и тёплая подкладка из флиса создадут ощущение домашнего тепла. Идеальный выбор для холодных вечеров и расслабленного отдыха.',
    'Материал верха: Искусственный мех; Подкладка: Мягкий флис; Подошва: Нескользящая резина; Размеры: 36-40; Цвет: Розовый; Вес: 180г (пара)',
    3200.00,
    'https://angelsshop.com.ua/content/images/50/825x1100l85nn0/kaptsi-pink-faux-fur-closed-toe-slippersid-25014762295791.jpg',
    'product4.html'
);