<?php
require_once "../db/dbfunctions.php";
$result = getUserByEmail($_SESSION["userEmail"]);
$row = mysqli_fetch_row($result);
$name = $row[3];
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

    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <title>Admin - EcoFarm</title>
</head>
<body>
<div class="wrapper">
    <header>
        <h2>EcoFarm</h2>
    </header>
    <main class="main">
        <div class="menu">
            <div class="menu__box">
                <button name="category" id="category">Категории товаров</button>
                <button name="product" id="product">Товары</button>
                <button name="order" id="order">Заказы</button>
                <button name="client" id="client">Клиенты</button>
                <button name='account' id='exit'>Выйти</button>
            </div>
        </div>
        <div class="content"></div>
    </main>
    <footer>
        <p>Юркевич Кирилл</p>
    </footer>
</div>
<script src="../scripts/admin.js"></script>
</body>
</html>
