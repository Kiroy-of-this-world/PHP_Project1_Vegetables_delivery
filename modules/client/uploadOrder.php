<?php
require_once "../../db/dbfunctions.php";
require_once "../../functions/functions.php";

if (!empty($_POST)) {

    //перебор товаров под одним номером заказа
    foreach ($_POST["product-id"] as $key => $item) {
        $kol = priceInputValidate($_POST["order-kol"]["$key"], "Не корректно введено количество товара.");
        if ($kol < 1) {
            echo "Минимальный вес заказа 1 кг.";
            exit;
        }
        if ($kol > $_POST["product-maxkol"]["$key"]) {
            echo "У нас нет такого количества товара.";
            exit;
        }
        $Kol[$key] = $kol;

        $address = textInputValidate($_POST["address"]);
        $number_of_phone = phoneInputValidate($_POST["number_of_phone"]);
    }

    $result = getNumberOfOrder();
    $row = mysqli_fetch_row($result);
    $number_of_order = ++$row[0];

    //перебор массива с товарами одного номера заказа для добовления в базу данных
    foreach ($_POST["product-id"] as $key => $item) {
        $cost = $_POST["product-price"]["$key"] * $Kol[$key];

        insertOrder($number_of_order, $_SESSION["userId"], $item, $Kol[$key], $cost, $_POST["address"], $_POST["number_of_phone"]);
        deleteBasket($_SESSION["userId"], $item);
        updateProductKol($item, -$Kol[$key]);
    }

    echo "Заказ сделан";
}
?>