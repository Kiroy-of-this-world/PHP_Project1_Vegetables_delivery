<?php
require_once '../../db/dbfunctions.php';
require_once '../../functions/functions.php';

//Функция вывода товаров. Принимает объект mysqli_result.
function showProduct($result){
    echo "<div style='display: flex; flex-wrap: wrap; width: 930px; align-content: flex-start;'>";

    $rows = mysqli_num_rows($result);

    //Если товаров нет
    if ($rows == 0) {
        echo "<h4 style='margin: 10px'>Товаров нет</h4>";
        exit();
    }

    for ($i = 0; $i < $rows; ++$i) {
        $row = mysqli_fetch_row($result);

        if (isset($row[1])) {
            $price = priceOutputValidate($row[3]);

            echo "<div style='border: solid 2px black; display: flex; flex-direction: column; align-items: center; width: 280px; padding: 15px 0px; margin: 15px'>
                    <h4 style='margin: 10px 0px'>Категория: " . $row[6] . "</h4>
                    <img src='../$row[7]' style='width: 220px; margin: 15px 0px'>
                    <p>Сорт: " . $row[2] . "</p>
                    <p>Цена: " . str_replace(".", ",", $price) . " р.</p>
                    <p>Количество: " . str_replace(".", ",", $row[4]) . " кг.</p>
                    <button class='to-basket' id='$row[0]'>В корзину</button>
                  </div>";
        }
    }

    echo "</div>";
    echo "<script>
            $('.to-basket').on('click', function(event) {
                event.preventDefault();
                let data = $(this).attr('id');
                toBasket(data);
            });     
          </script>";
}

//При нажатии на кнопку меню "товары"
if ($_GET['type'] == "products") {
    $result = getProducts();
    if ($result) {
        echo "<h2 style='margin: 10px'>Все товары</h2>";

        showProduct($result);
    }
}

//При нажатии на кнопку подменю категории "товары"
if ($_GET['type'] == "category") {
    $result = getProductsFromCategory($_GET['id']);
    if ($result) {
        echo "<h2 style='margin: 10px'>Товары</h2>";

        showProduct($result);
    }
}

//При нажатии на кнопку меню "корзина"
if ($_GET['type'] == "basket") {
    echo "<h2 style='margin: 10px'>Корзина</h2>";

    $result = getBaskets($_SESSION['userId']);
    if ($result) {
        $rows = mysqli_num_rows($result);

        //Если корзина пуста
        if ($rows == 0) {
            echo "<h4 style='margin: 10px'>Корзина пуста</h4>";
            exit();
        }

        //Вывод товаров в корзине
        echo "<form id='toOrder' style='display: flex; flex-direction: column; width: 1080px'>";
        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);
            $price = priceOutputValidate($row[3]);

            if (isset($row[1])) {
                echo "<div style='display: flex; flex-direction: row'>
                        <button class='delete-basket delete-btn' id='$row[0]'>Удалить</button>
                        <p class='product-info'>$row[6]</p>
                        <p class='product-info'>$row[2]</p>
                        <p class='product-info'>" . str_replace(".", ",", $price) . " р/кг</p>
                        <p class='product-info'>" . str_replace(".", ",", $row[4]) . " кг</p>
                        <input type='hidden' name='product-id[]'  value='$row[0]'>
                        <input type='hidden' name='product-price[]'  value='$row[3]'>
                        <input type='hidden' name='product-maxkol[]'  value='$row[4]'>
                        <input type='text' name='order-kol[]' id='order-kol' style='min-width: 300px;' placeholder='Введите количество товара, кг' required>
                      </div>";
            }
        }

        //Заполнение данных пользователя для оформления заказа
        $result = getUserByEmail($_SESSION["userEmail"]);
        if ($result) {
            $rows = mysqli_num_rows($result);

            for ($i = 0; $i < $rows; ++$i) {
                $row = mysqli_fetch_row($result);

                echo "<div style='display: flex; flex-direction: row'>
                        <input type='text' name='address' id='address' placeholder='Введите адрес' value='$row[6]' required>
                        <input type='tel' name='number_of_phone' id='number_of_phone' placeholder='Введите телефон' value='$row[7]' required>
                        <input type='submit' value='Заказать'>
                      </div>
                   </form>";
            }
        }

        echo "<script>
                $('#toOrder').submit(function(event) {
                    event.preventDefault();
                    let formData = new FormData(this);
                    insertOrder(formData);
                });  
                $('.delete-basket').on('click', function(event) {
                    event.preventDefault();
                    let data = $(this).attr('id');
                    if (confirm('Точно хотите удалить?')){
                        deleteBasket(data);
                    }
                });  
              </script>";
    }
}

//При нажатии на кнопку меню "заказы"
if ($_GET['type'] == "order") {
    echo "<h2 style='margin: 10px'>Заказы</h2>";

    $result = getOrders($_SESSION['userId']);
    if ($result) {
        $rows = mysqli_num_rows($result);

        //Если заказов нет
        if ($rows == 0) {
            echo "<h4 style='margin: 10px'>Заказов нет</h4>";
            exit();
        }

        //Сортирование результата в многомерный массив по номеру заказа
        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);
            $cost = $row[4];
            $cost = bcdiv($cost, 1, 2);
            $cost = priceOutputValidate($cost);

            $orders[$row[8]][] = [ 'id' => $row[0], 'category' => $row[1], 'sort' => $row[2], 'kol' => $row[3], 'cost' => $cost,
                'address' => $row[5], 'number_of_phone' => $row[6], 'status' => $row[7] ];
        }

        //Вывод заказов на основе массива
        echo "<div style='display: flex; flex-direction: column; width: 1080px'>";
        foreach ($orders as $key => $values) {
            echo "<div style='display: flex; flex-direction: column; width: 1080px'><span style='margin: 15px 0'>Номер заказа: $key</span>";

            //Вывод товаров заказа
            foreach ($values as $value) {
                echo "<div style='display: flex; flex-direction: row;'>
                        <p class='product-info'>" . $value["category"] . "</p>
                        <p class='product-info'>" . $value["sort"] . "</p>
                        <p class='product-info'>" . str_replace(".", ",", $value["kol"]) . " кг</p>
                        <p class='product-info'>" . str_replace(".", ",", $value["cost"]) . " р</p>
                        <input type='hidden' name='product-id[]'  value='" . $value["id"] . "'>
                        <input type='hidden' name='product-price[]'  value='" . $value["cost"] . "'>
                      </div>";
            }

            //Вывод общей информации заказа
            echo "<div style='display: flex; flex-direction: row'>
                    <p class='product-info'>" . $value["address"] . "</p>
                    <p class='product-info'>" . $value["number_of_phone"] . "</p>
                    <p class='product-info'>" . $value["status"] . "</p>
                    <button class='delete-order delete-btn' id='$key'>Отменить</button>
                  </div>
              </div>";
        }
        echo "</div>";
        echo "<script>
                $('.delete-order').on('click', function(event) {
                    event.preventDefault();
                    let data = $(this).attr('id');
                    if (confirm('Точно хотите удалить заказ?')){
                        deleteOrder(data);
                    }
                });  
              </script>";
    }
}

//При нажатии на кнопку меню "Аккаунт"
if ($_GET['type'] == "account") {
    echo "<h2 style='margin: 10px'>Личный кабинет</h2>";

    $result = getUserByEmail($_SESSION["userEmail"]);
    if ($result) {
        $rows = mysqli_num_rows($result);

        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);

            echo "  <form id='update-account'  style='display: flex; flex-direction: column; width: 500px; padding: 30px'>
                        <div class='rows'>
                            <div class='column'>
                                <label for='email'>Email</label>
                                <p class='product-info'>" . $row[1] . "</p>
                            </div>
                            <div class='column'>
                                <label for='name'>Фамилия</label>
                                <input type='text' name='surname' placeholder='Введите фамилию' value='" . $row[4] . "' required>
                            </div>
                        </div>
                        <div class='rows'>
                            <div class='column'>
                                <label for='email'>Имя</label>
                                <input type='text' name='name' placeholder='Введите имя' value='" . $row[3] . "' required>
                            </div>
                            <div class='column'>
                                <label for='name'>Отчество</label>
                                <input type='text' name='secondname' placeholder='Введите отчество' value='" . $row[5] . "' required>
                            </div>
                        </div>
                        <div class='rows'>
                            <div class='column'>
                                <label for='email'>Адрес</label>
                                <input type='text' name='address' placeholder='Введите адрес' value='" . $row[6] . "' required>
                            </div>
                            <div class='column'>
                                <label for='name'>Телефон</label>
                                <input type='text' name='number_of_phone' placeholder='Введите телефон' value='" . $row[7] . "' required>
                            </div>
                        </div>
                        <div class='rows'>
                            <div class='column'>
                                <label for='exit'>Выйти из аккаунта</label>
                                <button name='account' id='exit'>Выйти</button>
                            </div>
                            <div class='column'>
                                <label for='save'>Сохранить изменения</label>
                                <input type='submit' id='save' value='Сохранить изменения' style='margin-top: 15px'>
                            </div>
                        </div>
                        <input type='hidden' name='id'  value='" . $row[0] . "'>
                    </form>";

            echo "  <script>
                        $('#update-account').submit(function(event) {
                            event.preventDefault();
                            let formData = new FormData(this);
                            updateAccount(formData);
                        });  
                        $('#exit').on('click', function(event) {
                            event.preventDefault();
                            if (confirm('Точно хотите выйти?')){
                                window.location.href = '../';
                            }
                        });  
                    </script>";
        }
    }
}
?>