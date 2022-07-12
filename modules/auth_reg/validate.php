<?php

//Функция валидации Email.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных,
//ключ проверяемого значения из массива данных объекта formData.
function emailValidation($request, &$errors, $key) {
    if (!isset($request[$key]) || strlen($request[$key]) == 0) {
        $errors[][$key] = 'Email не указан';
    } elseif (!filter_var($request[$key], FILTER_VALIDATE_EMAIL)) {
        $errors[][$key] = 'Неправильный формат email';
    } elseif (strlen($request[$key]) < 5) {
        $errors[][$key] = 'Email должен быть больше 4-х символов';
    }
}

//Функция проверки уникальности Email при регистрации.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных,
//ключ проверяемого значения из массива данных объекта formData.
function isEmailAlreadyExists($request, &$errors, $key) {
    $rows = mysqli_num_rows(getUserByEmail($request[$key]));
    if ($rows != 0) {
        $errors[][$key] = 'Email уже используется';
    }
}

//Функция проверки правильности введённых данных при авторизации.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных.
function authorization($request, &$errors) {
    $result = selectByEmailAndPassword($request["email-auth"], $request["password-auth"]);
    $rows = mysqli_num_rows($result);
    if ($rows == 0) {
        $errors[]["result"] = 'Не верный email или пароль';
    }
    else {
        $row = mysqli_fetch_row($result);
        $_SESSION["userEmail"] = $row[1];
        $_SESSION["userType"] = $row[8];
    }
}

//Функция валидации имени.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных.
function nameValidation(array $request, &$errors) {
    if (!isset($request['name']) || empty($request['name'])) {
        $errors[]['name'] = 'Имя не указано';
    }
}

//Функция валидации фамилии.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных.
function surnameValidation(array $request, &$errors) {
    if (!isset($request['surname']) || empty($request['surname'])) {
        $errors[]['surname'] = 'Фамилия не указана';
    }
}

//Функция валидации отчества.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных.
function secondnameValidation(array $request, &$errors) {
    if (!isset($request['secondname']) || empty($request['secondname'])) {
        $errors[]['secondname'] = 'Отчество не указано';
    }
}

//Функция валидации пароля.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных,
//ключ проверяемого значения из массива данных объекта formData.
function passwordValidation($request, &$errors, $key) {
    if (!isset($request[$key]) || empty($request[$key])) {
        $errors[][$key] = 'Пароль не указан';
    }
}

//Функция валидации повторенного пароля.
//Принимает массив данных объекта formData, ссылку на массив ошибочных данных,
//ключ проверяемого значения из массива данных объекта formData.
function repeatpasswordValidation(array $request, &$errors) {
    if (!isset($request['repeatpassword']) || empty($request['repeatpassword'])) {
        $errors[]['repeatpassword'] = 'Пароль не указан';
    } elseif ($request['repeatpassword'] !== $request['password']) {
        $errors[]['repeatpassword'] = 'Пароли не совпадают';
    }
}
?>