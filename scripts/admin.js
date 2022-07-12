//Функция выхода из аккаунта.
$('#exit').on('click', function(event) {
    event.preventDefault();
    if (confirm('Точно хотите выйти?')){
        window.location.href = '../';
    }
});

$("#client").on("click", function(event) {
    event.preventDefault();
    menu("clients");
});
$("#product").on("click", function(event) {
    event.preventDefault();
    menu("products");
});
$("#order").on("click", function(event) {
    event.preventDefault();
    menu("orders");
});
$("#category").on("click", function(event) {
    event.preventDefault();
    menu("categories");
});

//Функция отображения товаров, принимает объект formData.
//Отправляет ajax запрос, и выводит товары на страницу.
function menu(data) {
    $.ajax({
        url: "../modules/admin/menuAdmin.php",
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

//Функция добавления категории товаров, принимает объект formData.
//Отправляет ajax запрос, и выводит сообщения из php.
function insertCategory(formData) {
    $.ajax({
        url: '../modules/admin/uploadCategory.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            menu('categories');
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция добавления товара, принимает объект formData.
//Отправляет ajax запрос, и выводит сообщения из php.
function insertProduct(formData) {
    $.ajax({
        url: '../modules/admin/uploadProduct.php',
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        success: function (data) {
            menu('products');
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция удаления категории товаров, принимает id категории.
//Отправляет ajax запрос, и выводит сообщения из php.
function deleteCategory(data) {
    $.ajax({
        url: '../modules/admin/deleteCategory.php',
        data: 'id=' + data,
        processData: false,
        contentType: false,
        type: 'GET',
        success: function (data) {
            menu('categories');
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция удаления товара, принимает номер заказа.
//Отправляет ajax запрос, и выводит сообщения из php.
function deleteProduct(data) {
    $.ajax({
        url: '../modules/admin/deleteProduct.php',
        data: 'id=' + data,
        processData: false,
        contentType: false,
        type: 'GET',
        success: function (data) {
            menu('products');
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//TODO: проверить исть ли ссылка на эту функцию, если нет - то удалить.
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

//Функция обновления данных товара, принимает тип изменения и id товара.
//Отправляет ajax запрос, и выводит сообщения из php.
function updateProduct(data) {
    $.ajax({
        url: '../modules/admin/updateProduct.php',
        data: 'type=' + data,
        processData: false,
        contentType: false,
        type: 'GET',
        success: function (data) {
            menu('products');
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}

//Функция обновления статуса заказа, принимает номер заказа.
//Отправляет ajax запрос, и выводит сообщения из php.
function updateStatus(data){
    $.ajax({
        url: '../modules/admin/updateStatus.php',
        data: 'id=' + data,
        processData: false,
        contentType: false,
        type: 'GET',
        success: function (data) {
            menu('orders');
            alert(data);
        },
        error: function (data) {
            alert('Error: ' + data);
        }
    });
}