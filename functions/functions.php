<?php

//Редактирование входных данных
function textValidate($value) {
    $value = trim($value);
    $value = strip_tags($value);
    $value = stripslashes($value);

    return $value;
}

//Редактирование отображения цен
function priceOutputValidate($value) {
    if (preg_match('/^\d+\.\d$/', $value) == 1) {
        $value = $value . "0";
    }
    if (preg_match('/^\d+\.$/', $value) == 1) {
        $value = $value . "00";
    }
    if (preg_match('/^\d+$/', $value) == 1) {
        $value = $value . ".00";
    }

    return $value;
}

//Редактирование входных данных цен и количества
function priceInputValidate($value, $error) {
    $value = textValidate($value);
    $value = str_replace(",", ".", $value);
    $result = preg_match('/^\d+\.?\d*$/', $value);
    if (!$result) {
        echo $error;
        exit;
    }
    $value = bcdiv($value, 1, 2);

    return $value;
}

//Редактирование входных данных
function textInputValidate($value) {
    $value = textValidate($value);
    $value = mb_strtoupper(mb_substr($value, 0, 1)) . mb_substr($value, 1);

    return $value;
}

//Редактирование входных данных телефонного номера
function phoneInputValidate($value) {
    $value = textValidate($value);

    $result = preg_match('/^(\+)?((\d{2,3}) ?\d|\d) ?(\(\d\d\))? ?(([ -]?\d)|( ?(\d{2,3}) ?)){5,12}\d$/', $value);
    if (!$result) {
        echo "Не корректно введен номер телефона";
        exit;
    }

    $re = "/(\\d{3})(\\d{2})(\\d{3})(\\d{2})(\\d{2})/";
    $value = preg_replace("/[^\d]/", '', $value);;
    $subst = '+$1 ($2) $3-$4-$5';
    $value = preg_replace($re, $subst, $value);

    return $value;
}
?>