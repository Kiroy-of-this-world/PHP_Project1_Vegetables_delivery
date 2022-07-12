<?php
require_once "../../db/dbfunctions.php";
require_once "../../functions/functions.php";
require_once "../../modules/client/menuClient.php";

if (!empty($_POST)) {
    $search = textInputValidate($_POST["search"]);

    $result = searchProduct($search);
    if ($result == true){
        echo "Данные изменены";
    }
    else echo "Error";

    showProduct($result);
}
?>