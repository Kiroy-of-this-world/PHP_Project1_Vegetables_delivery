<?php
require_once "../../db/dbfunctions.php";

if (!empty($_GET)) {
    $result = deleteProduct($_GET['id']);

    if ($result === true){
        echo "Удалено";
    }
    elseif ($result == "cannot"){
        echo "Не возможно удалить, товар находится в заказах";
    }
    else echo "Error";
}
?>