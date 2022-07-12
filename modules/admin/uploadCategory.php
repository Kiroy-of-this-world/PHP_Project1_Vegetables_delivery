<?php
require_once "../../db/dbfunctions.php";
require_once "../../functions/functions.php";

if (!empty($_POST) && !empty($_FILES)) {
    if ($_FILES["filename"]["size"] > 1024 * 10 * 1024) {
        echo "Превышен размер в 10мб";
        exit;
    }

    if (strlen($_POST["category-name"]) == 0) {
        echo "Введите название категории";
        exit;
    }

    //Проверка загружен ли файл
    //Если файл загружен успешно, перемещаем егоиз временной директории в конечную
    if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
        $category = textInputValidate($_POST["category-name"]);
        $path = "images/" . $_FILES["filename"]["name"];

        insertCategory($category, $path);
        if (file_exists("../../images/" . $_FILES["filename"]["name"])){
            unlink("../../images/" . $_FILES["filename"]["name"]);
        }

        move_uploaded_file($_FILES["filename"]["tmp_name"], "../../images/" . $_FILES["filename"]["name"]);
        echo "Выполнено успешно";
    }
    else echo "Файл не загружен";
}
?>