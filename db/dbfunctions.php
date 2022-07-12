<?php

//Подключение к базе данных
$host = "localhost";
$database = "PHPProject-1";
$user = "root";
$password = "root";
$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка" . mysqli_error($link));
$link->set_charset('utf8');
session_start();
$_SESSION["link"] = $link;

//Функция регистрации, принимает массив данных.
//Обращается к функции insert().
//Возвращает true в случае успегного выполнения (в противном случае false).
function register(array $data) {
    $values = [
        $data['email'],
        $data['name'],
        $data['surname'],
        $data['secondname'],
        $data['password']
    ];

    return insert($values);
}

//Функция запроса к базе данных.
//Поиск в базе данных пользвателя по email и password.
//Принимает email, password.
//Возвращает объект mysqli_result.
function selectByEmailAndPassword($email, $password) {
    $link = $_SESSION["link"];
    $hash = md5($password);
    $query = "SELECT * FROM users WHERE email = '$email' and password = '$hash'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе данных пользователя по email.
//Принимает email.
//Возвращает объект mysqli_result.
function getUserByEmail($email) {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Добавление пользователя в базу данных.
//Принимает  массив данных.
//Возвразает true в случае успегного выполнения (в противном случае false).
function insert(array $data) {
    $link = $_SESSION["link"];
    $email = $data[0];
    $name = $data[1];
    $surname = $data[2];
    $secondname = $data[3];
    $password = md5($data[4]);
    $address = "";
    $number_of_phone = "";
    $type_of_user = "client";

    $query = "INSERT INTO users (email, password, name, surname, secondname, address, number_of_phone, type_of_user) 
                VALUES ('$email', '$password', '$name', '$surname', '$secondname', '$address', '$number_of_phone', '$type_of_user')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе данных пользователей с типом "клиент".
//Возвращает объект mysqli_result.
function getClients() {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM users WHERE type_of_user = 'client'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе данных категорий товаров.
//Возвращает объект mysqli_result.
function getCategories() {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM categories";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе данных товаров.
//Возвращает объект mysqli_result.
function getProducts() {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе товаров по категории.
//Принимает id категории.
//Возвращает объект mysqli_result.
function getProductsFromCategory($id) {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id 
                WHERE products.category_id = '$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе товаров по id.
//Принимает id товара.
//Возвращает объект mysqli_result.
function getProductsFromId($id) {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id 
                WHERE products.product_id = '$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе товаров конечного номера заказа.
//Возвращает объект mysqli_result.
function getNumberOfOrder() {
    $link = $_SESSION["link"];
    $query = "SELECT MAX(number_of_order) FROM orders";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе корзин по id.
//Принимает id корзины.
//Возвращает объект mysqli_result.
function getBaskets($id){
    $link = $_SESSION["link"];
    $query = "SELECT * FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id 
                RIGHT OUTER JOIN baskets ON products.product_id = baskets.product_id WHERE baskets.user_id = '$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе заказов по id пользователя.
//Принимает id пользователя.
//Возвращает объект mysqli_result.
function getOrders($id){
    $link = $_SESSION["link"];
    $query = "SELECT orders.order_id, categories.category, products.sort, orders.kol, orders.cost, 
                orders.address, orders.number_of_phone, orders.status, orders.number_of_order 
                FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id 
                RIGHT OUTER JOIN orders ON products.product_id = orders.product_id 
                WHERE orders.user_id = '$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе заказов по номеру заказа.
//Принимает номер заказа.
//Возвращает объект mysqli_result.
function getOrderByNumber($number_of_order){
    $link = $_SESSION["link"];
    $query = "SELECT orders.order_id, categories.category, products.sort, orders.kol, orders.cost,
                orders.address, orders.number_of_phone, orders.status, orders.number_of_order, products.product_id 
                FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id 
                RIGHT OUTER JOIN orders ON products.product_id = orders.product_id
                WHERE orders.number_of_order = '$number_of_order'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе заказов всех заказов.
//Возвращает объект mysqli_result.
function getAllOrders(){
    $link = $_SESSION["link"];
    $query = "SELECT orders.order_id, categories.category, products.sort, orders.kol, orders.cost, 
                orders.address, orders.number_of_phone, orders.status, orders.number_of_order, users.email 
                FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id 
                RIGHT OUTER JOIN orders ON products.product_id = orders.product_id
                INNER JOIN users ON orders.user_id = users.user_id";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Поиск в базе продуктов по названию.
//Возвращает объект mysqli_result.
function searchProduct($what){
    $link = $_SESSION["link"];
    $query = "SELECT * FROM products RIGHT OUTER JOIN categories ON products.category_id = categories.category_id
                WHERE `category` LIKE '%$what%' OR `sort` LIKE '%$what%';";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));

    if ($result) {
        return $result;
    }
    else return false;
}

//Функция запроса к базе данных.
//Добавление в базу категорий.
//Принимает название категории и путь к изображению.
//Возвращает true в случае успегного выполнения (в противном случае false).
function insertCategory($category, $photo) {
    $link = $_SESSION["link"];
    $query = "INSERT INTO categories (category, category_photo) VALUES ('$category', '$photo')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Добавление в базу товаров.
//Принимает id категории, сорт, цену и количество к изображению.
//Возвращает true в случае успегного выполнения (в противном случае false).
function insertProduct($category, $sort, $price, $kol) {
    $link = $_SESSION["link"];
    $query = "INSERT INTO products (category_id, sort, price, max_kol) VALUES ('$category', '$sort', '$price', '$kol')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Добавление в базу корзин.
//Принимает id пользователя и id товара.
//Возвращает true в случае успегного выполнения (в противном случае false).
function insertBasket($id, $userId) {
    $link = $_SESSION["link"];
    $query = "INSERT INTO baskets (user_id, product_id) VALUES ('$userId', '$id')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Добавление в базу заказов.
//Принимает номер заказа,  id пользователя, id товара, стоимость и количество, адресс и номер телефона.
//Возвращает true в случае успегного выполнения (в противном случае false).
function insertOrder($number_of_order, $user_id, $product_id, $kol, $cost, $address, $number_of_phone) {
    $link = $_SESSION["link"];
    $query = "INSERT INTO orders (number_of_order, user_id, product_id, kol, cost, address, number_of_phone, status)
                VALUES ('$number_of_order', '$user_id', '$product_id', '$kol', '$cost', '$address', '$number_of_phone', 'в обработке')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Удаление из базы категорий.
//Принимает id категории.
//Сначала происходит проверка нахождения товара с соответствующей категорией в базе заказов.
//Возвращает true в случае успегного выполнения (в противном случае false).
function deleteCategory($id) {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM orders RIGHT OUTER JOIN products ON orders.product_id = products.product_id
                WHERE (products.category_id = '$id' AND orders.status != 'доставлен')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $rows = mysqli_num_rows($result);
    if ($rows == 0) {
        $query = "DELETE FROM categories WHERE category_id = '$id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        if ($result) {
            return true;
        }
        else return false;
    }
    else return "cannot";
}

//Функция запроса к базе данных.
//Удаление из базы товаров.
//Принимает id товара.
//Сначала происходит проверка нахождения товара в базе заказов.
//Возвращает true в случае успегного выполнения (в противном случае false).
function deleteProduct($id) {
    $link = $_SESSION["link"];
    $query = "SELECT * FROM orders WHERE (orders.product_id = '$id' AND orders.status != 'доставлен')";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    $rows = mysqli_num_rows($result);
    if ($rows == 0) {
        $query = "DELETE FROM products WHERE product_id = '$id'";
        $result = mysqli_query($link, $query) or die(mysqli_error($link));
        if ($result) {
            return true;
        }
        else return false;
    }
    else return "cannot";
}

//Функция запроса к базе данных.
//Удаление из базы корзин.
//Принимает id пользователя и id товара.
//Возвращает true в случае успегного выполнения (в противном случае false).
function deleteBasket($user_id, $product_id) {
    $link = $_SESSION["link"];
    $query = "DELETE FROM baskets WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    } else return false;
}

//Функция запроса к базе данных.
//Удаление из базы заказов.
//Принимает номер заказа.
//Возвращает true в случае успегного выполнения (в противном случае false).
function deleteOrder($number_of_order) {
    $link = $_SESSION["link"];
    $query = "DELETE FROM orders WHERE number_of_order = '$number_of_order'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    } else return false;
}

//Функция запроса к базе данных.
//Обновление в базе товаров количества продуктов.
//Принимает id товара и количество.
//Возвращает true в случае успегного выполнения (в противном случае false).
function updateProductKol($id, $kol) {
    $link = $_SESSION["link"];
    $query = "UPDATE products SET max_kol = max_kol + '$kol' WHERE product_id = '$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Обновление в базе товаров цены продуктов.
//Принимает id товара и цену.
//Возвращает true в случае успегного выполнения (в противном случае false).
function updateProductPrice($id, $price) {
    $link = $_SESSION["link"];
    $query = "UPDATE products SET price = '$price' WHERE product_id = '$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Обновление в базе заказов статуса заказа.
//Принимает номер заказа и статус.
//Возвращает true в случае успегного выполнения (в противном случае false).
function updateStatus($number_of_order, $status) {
    $link = $_SESSION["link"];
    $query = "UPDATE orders SET status = '$status' WHERE number_of_order = '$number_of_order'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}

//Функция запроса к базе данных.
//Обновление в базе заказов данных пользователя.
//Принимает id пользователя, фамилия, имя, отчество, адрес, номер телефона.
//Возвращает true в случае успегного выполнения (в противном случае false).
function updateAccount($id, $surname, $name, $secondname, $address, $number_of_phone) {
    $link = $_SESSION["link"];
    $query = "UPDATE users SET name = '$name', surname = '$surname', secondname = '$secondname', 
                 address = '$address', number_of_phone = '$number_of_phone' WHERE user_id = '$id'";
    $result = mysqli_query($link, $query) or die(mysqli_error($link));
    if ($result) {
        return true;
    }
    else return false;
}
?>
