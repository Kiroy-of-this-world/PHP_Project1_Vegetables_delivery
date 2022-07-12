<?php
require_once "../../db/dbfunctions.php";

if (!empty($_GET)) {
    $result = updateStatus($_GET['id'], $_GET["value"]);

    if ($result == true){
        echo "Статус изменён";
    }
    else echo "Error";
}
?>