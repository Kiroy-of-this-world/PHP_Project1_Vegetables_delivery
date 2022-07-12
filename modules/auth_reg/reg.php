<?php
require_once "../../db/dbfunctions.php";

//Функция обработки входных значений.
//Принимает массив данных объекта formData.
//Возвращает массив ошибочных данных.
function validate(array $request) {
    $errors = [];

    require_once 'validate.php';

    emailValidation($request, $errors, "email");
    isEmailAlreadyExists($request, $errors, "email");
    nameValidation($request, $errors);
    surnameValidation($request, $errors);
    secondnameValidation($request, $errors);
    passwordValidation($request, $errors, "password");
    repeatpasswordValidation($request, $errors);

    return $errors;
}

if (!empty($_POST)) {
    $errors = validate($_POST);

    if (empty($errors)) {
        if (register($_POST)) {
            echo json_encode(['result' => true]);
            exit();
        }

        echo json_encode(['result' => false]);
        exit();
    }

    echo json_encode([
        'result' => false,
        'errors' => $errors
    ]);
    exit();
}
?>