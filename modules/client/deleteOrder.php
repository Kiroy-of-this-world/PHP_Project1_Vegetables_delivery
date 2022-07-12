<?php
require_once "../../db/dbfunctions.php";

if (!empty($_GET)) {
    $result = getOrderByNumber($_GET['id']);

    if ($result) {
        $rows = mysqli_num_rows($result);
        for ($i = 0; $i < $rows; ++$i) {
            $row = mysqli_fetch_row($result);
            $product_id = $row[9];
            $kol = $row[3];

            updateProductKol($product_id, $kol);
        }
    }

    $result = deleteOrder($_GET['id']);
    if ($result == true) {
        echo "Удалено";
    }
    else echo "Error";
}
?>