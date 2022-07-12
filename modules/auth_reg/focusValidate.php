<?php
require_once "../../db/dbfunctions.php";

//Функция обработки входных значений.
//Принимает массив данных объекта formData.
//Возвращает массив ошибочных данных.
function validate(array $request) {
    $errors = [];

    require_once 'validate.php';

    if (array_keys($request)[0] == "email") emailValidation($request, $errors, "email");
    if (array_keys($request)[0] == "email") isEmailAlreadyExists($request, $errors, "email");
    if (array_keys($request)[0] == "email-auth") emailValidation($request, $errors, "email-auth");
    if (array_keys($request)[0] == "name") nameValidation($request, $errors);
    if (array_keys($request)[0] == "surname") surnameValidation($request, $errors);
    if (array_keys($request)[0] == "secondname") secondnameValidation($request, $errors);
    if (array_keys($request)[0] == "password") passwordValidation($request, $errors, "password");
    if (array_keys($request)[0] == "password-auth") passwordValidation($request, $errors, "password-auth");
    if (array_keys($request)[0] == "repeatpassword") repeatpasswordValidation($request, $errors);

    return $errors;
}

if (!empty($_POST)) {
    $errors = validate($_POST);

    if (empty($errors)) {
        echo json_encode(['result' => true]);
        exit();
    }

    echo json_encode([
        'result' => false,
        'errors' => $errors
    ]);
    exit();
}

?>