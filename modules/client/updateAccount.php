<?php
require_once "../../db/dbfunctions.php";
require_once "../../functions/functions.php";

if (!empty($_POST)) {
    $surname = textInputValidate($_POST["surname"]);
    $name = textInputValidate($_POST["name"]);
    $secondname = textInputValidate($_POST["secondname"]);
    $address = textInputValidate($_POST["address"]);

    $number_of_phone = phoneInputValidate($_POST["number_of_phone"]);

    $result = updateAccount($_POST['id'], $surname, $name, $secondname, $address, $number_of_phone);
    if ($result == true){
        echo "Данные изменены";
    }
    else echo "Error";
}
else echo "Error";
?>