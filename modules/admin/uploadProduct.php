<?php
require_once "../../db/dbfunctions.php";
require_once "../../functions/functions.php";

if (!empty($_POST)) {
    if ($_POST["product-category"] == "cannot") {
        echo "Выберите категорию";
        exit;
    }
    if (strlen($_POST["product-sort"]) == 0) {
        echo "Введите название сорта";
        exit;
    }
    elseif (strlen($_POST["product-price"]) == 0) {
        echo "Введите цену";
        exit;
    }
    elseif (strlen($_POST["product-kol"]) == 0) {
        echo "Введите количество товара";
        exit;
    }

    $category = textInputValidate($_POST["product-category"]);
    $sort = textInputValidate($_POST["product-sort"]);
    $price = priceInputValidate($_POST["product-price"], "Не корректно введена цена товара");
    $kol = priceInputValidate($_POST["product-kol"], "Не корректно введено количество товара");

    $result = insertProduct($category, $sort, $price, $kol);
    if ($result) {
        echo "Выполнено успешно";
    }
    else echo "Error";
}

?>