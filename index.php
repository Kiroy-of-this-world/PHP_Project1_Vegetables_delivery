<?php
session_start();
session_destroy();
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#319197">

    <script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="css/auth_reg.css">
    <title>registration</title>
</head>
<body>
<div class="wrapper">
    <header>
        <h2>EcoFarm</h2>
    </header>
    <main class="main">
        <div class="div__form" id="auth">
            <h2>Авторизация</h2>
            <form class="form" id="authorization">
                <label for="email-auth">Email</label>
                <input type="email" name="email-auth" id="email-auth" placeholder="Введите email">
                <div class="form-control-feedback"></div>
                <label for="password-auth" style="margin-top: 20px">Пароль</label>
                <input type="password" name="password-auth" id="password-auth" placeholder="Введите пароль">
                <div class="form-control-feedback"></div>
                <div class="rows" id="result">
                    <div class="column">
                        <input type="button" class="btn-reg" value="Нет аккаунта: регистрация">
                    </div>
                    <div class="column">
                        <input type="submit" value="Войти">
                    </div>
                </div>
                <div class="form-control-feedback" style="display: flex; justify-content: center;"></div>
            </form>
        </div>

        <div class="div__form hidden" id="reg">
            <h2>Регистрация</h2>
            <form class="form" id="registration">
                <div class="rows">
                    <div class="column">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Введите email">
                        <div class="form-control-feedback"></div>
                    </div>
                    <div class="column">
                        <label for="name">Имя</label>
                        <input type="text" name="name" id="name" placeholder="Введите имя">
                        <div class="form-control-feedback"></div>
                    </div>
                </div>
                <div class="rows">
                    <div class="column">
                        <label for="surname">Фамилия</label>
                        <input type="text" name="surname" id="surname" placeholder="Введите фамилию">
                        <div class="form-control-feedback"></div>
                    </div>
                    <div class="column">
                        <label for="secondname">Отчество</label>
                        <input type="text" name="secondname" id="secondname" placeholder="Введите отчество">
                        <div class="form-control-feedback"></div>
                    </div>
                </div>
                <div class="rows">
                    <div class="column">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" id="password" placeholder="Введите пароль">
                        <div class="form-control-feedback"></div>
                    </div>
                    <div class="column">
                        <label for="repeatpassword">Пароль</label>
                        <input type="password" name="repeatpassword" id="repeatpassword" placeholder="Повторите пароль">
                        <div class="form-control-feedback"></div>
                    </div>
                </div>
                <div class="rows">
                    <div class="column">
                        <input type="button" class="btn-auth" value="Есть аккаунт: войти">
                    </div>
                    <div class="column">
                        <input type="submit" value="Зарегистрироваться">
                    </div>
                </div>
            </form>
        </div>
    </main>
    <footer>
        <p>Юркевич Кирилл</p>
    </footer>
</div>
<script src="scripts/auth_reg.js"></script>
</body>
</html>