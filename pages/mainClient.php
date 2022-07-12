<?php
require_once "../db/dbfunctions.php";

//запрос к базе данных об авторизованном пользователе
$result = getUserByEmail($_SESSION["userEmail"]);
$row = mysqli_fetch_row($result);
$name = $row[3];
//запись в сессию информации о email авторизованного пользователя
$_SESSION['userId'] = $row[0];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#319197">

    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="../css/client.css">
    <title><?php echo $name?> - EcoFarm</title>
</head>
<body>
<div class="wrapper">
    <header>
        <h2>EcoFarm</h2>
    </header>
    <main class="main">
        <div class="menu">
            <div class="menu__box">
                 <form id="search" class="search-form">
                     <input type="text" name="search" style="margin: 0" placeholder="Поиск продуктов" required>
                     <input type="submit" style="margin-top: 15px" value="Поиск">
                 </form>
                <button name="product" id="product">Товары</button>
                <?php
                $result = getCategories();
                if ($result) {
                    $rows = mysqli_num_rows($result);
                    for ($i = 0; $i < $rows; ++$i) {
                        $row = mysqli_fetch_row($result);
                        if (isset($row[1])) {
                            echo "<button class='category' name='category' id='$row[0]'>$row[1]</button>";
                        }
                    }
                }
                ?>
                <button name="basket" id="basket" style="margin-top: 30px">Корзина</button>
                <button name="order" id="order">Заказы</button>
                <button name="account" id="account">Аккаунт</button>
            </div>
        </div>
        <div class="content">
        </div>
    </main>
    <footer>
        <p>Юркевич Кирилл</p>
    </footer>
</div>
<script src="../scripts/client.js"></script>
</body>
</html>
