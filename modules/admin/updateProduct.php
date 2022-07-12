<?php
require_once "../../db/dbfunctions.php";
require_once "../../functions/functions.php";

//при изменении цены товара
if ($_GET["type"] == "price") {
    $price = priceInputValidate($_GET["price"], "Не корректно введена цена товара");

    $result = updateProductPrice($_GET["id"], $price);
    if ($result == true) {
        echo "Обновлено";
    }
    else echo "Error";
}

//при изменении количества товара
if ($_GET["type"] == "kol") {
    $kol = priceInputValidate($_GET["kol"], "Не корректно введено количество товара");

    $result = updateProductKol($_GET["id"], $kol);
    if ($result == true) {
        echo "Обновлено";
    }
    else echo "Error";
}
?>
