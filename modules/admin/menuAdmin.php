<?php
require_once '../../db/dbfunctions.php';
require_once '../../functions/functions.php';

//При нажатии на кнопку меню "категории"
if ($_GET['type'] == "categories") {

    //Вывод формы добавления категорий
    echo "<h2 style='margin: 10px'>Добавить категорию</h2>";
    echo "<form  enctype='multipart/form-data' id='uploadCategory'>
            <input type='text' name='category-name' id='category-name' placeholder='Введите название категории'>
            <input type='file' name='filename' id='filename'>
            <input type='submit' value='Добавить'>
          </form>
          <div class='errors'></div>";
    echo "<script>
            $('#uploadCategory').submit(function(event) {
                event.preventDefault();
                let formData = new FormData(this);
                insertCategory(formData);
            });
            $('.delete-category').on('click', function(event) {
                event.preventDefault();
                let data = $(this).attr('id');
                if (confirm('Точно хотите удалить?')){
                    deleteCategory(data);
                }
            });                    
          </script>";
    echo "<h2 style='margin: 10px'>Категории товаров</h2>";

    //Вывод категорий
    $result = getCategories();
    if ($result) {
        echo "<div style='display: flex; flex-wrap: wrap; width: 930px; align-content: flex-start;'>";

        $rows = mysqli_num_rows($result);
        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);

            if (isset($row[1])) {
                echo "<div style='border: solid 2px black; display: flex; flex-direction: column; align-items: center; width: 280px; padding: 15px 0px; margin: 15px'>
                        <h4 style='margin: 10px 0px'>Категория: " . $row[1] . "</h4>
                        <img src='../$row[2]' style='width: 220px; margin: 15px 0px'>
                        <button class='delete-category' id='$row[0]'>Удалить</button>
                      </div>";
            }
        }
        echo "</div>";
    }
    else echo "<h4 style='margin: 10px'>Нет Категорий</h4>";
}

//При нажатии на кнопку меню "товары"
if ($_GET['type'] == "products") {

    //Вывод формы добавления товаров
    $categories = getCategories();
    if ($categories) {
        echo "<h2 style='margin: 10px'>Добавить товар</h2>";
        echo "<form id='uploadProduct'>
                <div class='row'>
                    <select name='product-category' id='product-category' required>
                        <option value='cannot'>Выберите категорию</option>";

        $rows = mysqli_num_rows($categories);
        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($categories);
            echo "<option value='$row[0]'>$row[1]</option>";
        }

        echo "      </select>
                    <input type='text' name='product-sort' id='product-sort' placeholder='Введите сорт товара' required>
                </div>
                <div class='row'>
                    <input type='text' name='product-price' id='product-price' placeholder='Введите цену товара, р/кг' required>
                    <input type='text' name='product-kol' id='product-kol' placeholder='Введите количество товара, кг' required>
                    <input type='submit' value='Добавить'>
                </div>
              </form>
              <div class='errors'></div>";
        echo "<script>
                $('#uploadProduct').submit(function(event) {
                    event.preventDefault();
                    let formData = new FormData(this);
                    insertProduct(formData);
                });
                $('.delete-product').on('click', function(event) {
                    event.preventDefault();
                    let data = $(this).attr('id');
                    if (confirm('Точно хотите удалить?')){
                        deleteProduct(data);
                    }
                }); 
                $('.update-price').on('click', function(event) {
                    event.preventDefault();
                    let price = prompt('Введите новую цену товра, р/кг', 2);
                    if (price) {
                        let data = 'price&id=' + $(this).attr('id') + '&price=' + price;
                        updateProduct(data);
                    }
                }); 
                $('.update-kol').on('click', function(event) {
                    event.preventDefault();
                    let kol = prompt('Введите количесвто товаров, которое хотите добавить, кг', 50);
                    if (kol) {
                        let data = 'kol&id=' + $(this).attr('id') + '&kol=' + kol;
                        updateProduct(data);
                    }
                }); 
              </script>";
    }
    else echo "<h2 style='margin: 10px'>Нет категорий товаров</h2>";
    echo "<h2 style='margin: 10px'>Товары</h2>";
    echo "<div style='display: flex; flex-wrap: wrap; width: 930px; align-content: flex-start;'>";

    //Вывод товаров
    $result = getProducts();
    if ($result) {

        $rows = mysqli_num_rows($result);
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
                        <button class='update-price' style='margin: 15px 0 0 0' id='$row[0]'>Изменить цену</button>
                        <button class='update-kol' style='margin: 15px 0 0 0' id='$row[0]'>Изменить количество</button>
                        <button class='delete-product' id='$row[0]'>Удалить</button>
                      </div>";
            }
        }
        echo "</div>";
    }
}

//При нажатии на кнопку меню "заказы"
if ($_GET['type'] == "orders") {
    echo "<h2 style='margin: 10px'>Заказы</h2>";

    $result = getAllOrders();
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
            $cost = priceOutputValidate($row[4]);

            $orders[$row[8]][] = [ 'id' => $row[0], 'category' => $row[1], 'sort' => $row[2], 'kol' => $row[3], 'cost' => $cost,
                'address' => $row[5], 'number_of_phone' => $row[6], 'status' => $row[7], 'email' => $row[9] ];
        }

        //Вывод заказов на основе массива
        echo "<div style='display: flex; flex-direction: column; width: 1080px'>";
        foreach ($orders as $key => $values) {

            //При статусе заказа "доставлен" заказ не отображается
            if ($values[0]["status"] == "доставлен"){
                continue;
            }

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
                    <p class='product-info'>" . $value["email"] . "</p>
                    <p class='product-info'>" . $value["address"] . "</p>
                    <p class='product-info'>" . $value["number_of_phone"] . "</p>
                    <select name='order-status' class='order-status' id='$key' style='margin-top: 0'>";

            $statuses = ["в обработке", "принят", "передан курьеру", "доставлен"];
            for ($i = 0; $i < count($statuses); $i++) {
                if ($statuses[$i] == $value["status"]) {
                    echo "<option value='$statuses[$i]' selected>$statuses[$i]</option>";
                } else echo "<option value='$statuses[$i]'>$statuses[$i]</option>";
            }

            echo "  </select>";
            echo "</div>
            </div>";
        }

        echo "</div>";
        echo "<script>
                $('.delete-basket').on('click', function(event) {
                    event.preventDefault();
                    let data = $(this).attr('id');
                    if (confirm('Точно хотите удалить?')){
                        deleteBasket(data);
                    }
                });  
                $('.order-status').bind('change', function(){
                    let data = $(this).attr('id') + '&value=' + $(this) . val();                    
                    updateStatus(data);
                });
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

//При нажатии на кнопку меню "клиенты"
if ($_GET['type'] == "clients") {
    echo "<h2 style='margin: 10px'>Клиенты</h2>";

    $result = getClients();
    if ($result) {
        echo "<div style='display: flex; flex-wrap: wrap; max-width: 930px; align-content: start; '>";

        $rows = mysqli_num_rows($result);
        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);

            if (isset($row[1])) {
                echo "<div style='border: solid 2px black; display: block; width: 300px; padding: 0px 10px; margin: 5px'>
                        <h4>Email: " . $row[1] . "</h4>
                        <p>Имя: " . $row[3] . "</p>
                        <p>Фамилия: " . $row[4] . "</p>
                        <p>Отчество: " . $row[5] . "</p>
                        <p>Адрес: " . $row[6] . "</p>
                        <p>Телефон: " . $row[7] . "</p>
                      </div>";
            }
        }
        echo "</div>";
    }
    else echo "<h4 style='margin: 10px'>Нет клиентов</h4>";
}
?>