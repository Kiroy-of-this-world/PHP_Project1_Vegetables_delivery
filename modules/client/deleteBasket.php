<?php
require_once "../../db/dbfunctions.php";

if (!empty($_GET)) {
    $result = deleteBasket($_SESSION["userId"], $_GET['id']);

    if ($result == true) {
        echo "Удалено";
    }
    else echo "Error";
}
?>