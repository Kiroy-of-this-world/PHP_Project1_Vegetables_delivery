$("#product").on("click", function(event) {
    event.preventDefault();
    menu("products");
});
$("#basket").on("click", function(event) {
    event.preventDefault();
    menu("basket");
});
$("#order").on("click", function(event) {
    event.preventDefault();
    menu("order");
});
$("#account").on("click", function(event) {
    event.preventDefault();
    menu("account");
});

$(".category").on("click", function(event) {
    event.preventDefault();
    let data = "category&id=" + $(this).attr('id');
    menu(data);
});

$('#search').submit(function(event) {
    event.preventDefault();
    let formData = new FormData(this);
    searchProduct(formData);
});

//Функция отображения страниц, принимает тип страницы.
//Отправляет ajax запрос, и выводит товары на страницу.
function menu(data) {
    $.ajax({
        url: "../modules/client/menuClient.php",
        data: 'type='+data,
        processData: false,
        contentType: false,
        type: 'GET',
        dataType: 'html',
        success: function (data) {
            $(".content").html(data);
        }
    });
}

//Функция отображения товаров по поисковому запросу, принимает объект formData.
//Отправляет ajax запрос, и выводит товары на страницу.
function searchProduct(formData) {
    $.ajax({
        url: '../modules/client/searchProduct.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            $(".content").html(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция добавления товара в корзину, принимает id товара.
//Отправляет ajax запрос, и выводит сообщения из php.
function toBasket(data) {
    $.ajax({
        url: '../modules/client/toBasket.php',
        data: 'id=' + data,
        processData: false,
        contentType: false,
        type: 'GET',
        success: function (data) {
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция добавления товаров корзины в заказ, принимает объект formData.
//Отправляет ajax запрос, и выводит сообщения из php.
function insertOrder(formData) {
    $.ajax({
        url: '../modules/client/uploadOrder.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            menu('order');
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция удаления товара в корзине, принимает id товара.
//Отправляет ajax запрос, и выводит сообщения из php.
function deleteBasket(data) {
    $.ajax({
        url: '../modules/client/deleteBasket.php',
        data: 'id=' + data,
        processData: false,
        contentType: false,
        type: 'GET',
        success: function (data) {
            menu("basket");
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция удаления заказа, принимает номер заказа.
//Отправляет ajax запрос, и выводит сообщения из php.
function deleteOrder(data) {
    $.ajax({
        url: '../modules/client/deleteOrder.php',
        data: 'id=' + data,
        processData: false,
        contentType: false,
        type: 'GET',
        success: function (data) {
            menu("order");
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция обновления даных аккаунта, принимает объект formData.
//Отправляет ajax запрос, и выводит сообщения из php.
function updateAccount(formData) {
    $.ajax({
        url: '../modules/client/updateAccount.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            menu('account');
            alert(data);
        },
        error: function (data) {
            menu('account');
            alert('Error: ' + data);
        }
    });
}