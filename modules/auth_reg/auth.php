<?php
require_once "../../db/dbfunctions.php";

//Функция обработки входных значений.
//Принимает массив данных объекта formData.
//Возвращает массив ошибочных данных.
function validate(array $request) {
    $errors = [];

    require_once 'validate.php';

    emailValidation($request, $errors, "email-auth");
    passwordValidation($request, $errors, "password-auth");
    authorization($request, $errors);

    return $errors;
}

if (!empty($_POST)) {
    $errors = validate($_POST);

    if (empty($errors)) {
        if ($_SESSION["userType"] == "admin") $userType = "admin";
        else $userType = "client";

        echo json_encode([
            'result' => true,
            'userType' => $userType
        ]);
        exit();
    }

    echo json_encode([
        'result' => false,
        'errors' => $errors
    ]);
    exit();
}
?>