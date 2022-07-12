<?php
require_once "../../db/dbfunctions.php";

if (!empty($_GET)) {
    $result = insertBasket($_GET['id'], $_SESSION['userId']);

    if ($result == true){
        echo "Добавлено в корзину";
    }
    else echo "Error";
}
?>