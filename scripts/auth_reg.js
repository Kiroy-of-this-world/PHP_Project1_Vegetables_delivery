//Функция, вызывается при снятии фокуса с input.
//Отправляет ajax запрос, выводит предупреждение в случае
//не прохождения валидации.
$("input").bind('blur', function(){
    let value = $(this).val();
    let key = $(this).attr("id");
    let data = {[key]:value};
    if(key == "repeatpassword"){
        data["password"] = $("#password").val();
    }

    $.ajax({
        type: 'POST',
        url: 'modules/auth_reg/focusValidate.php',
        data: data,
        dataType: 'json',
        success: function(data){
            if(data['result']){
            }
            else {
                let arr = data['errors'];
                arr.forEach(function (data){
                    let field = Object.getOwnPropertyNames(data);
                    let value = data[field];
                    let div = $(`#${field[0]}`);
                    div.addClass('has-danger');
                    div.next().html(value).css("color", "red").css("margin-left", "7px");
                });
            }
        }
    });
});

//Функция, авторизирует (регистрирует и авторизует) пользователя.
//Принимает объект formData, путь к скрипту обработчику, текст уведомления.
//Отправляет ajax запрос, выводит предупреждение в случае
//не прохождения валидации.
function submit(formData, path, text) {
    $.ajax({
        url: path,
        data: formData,
        processData: false,
        contentType: false,
        type: 'POST',
        dataType: 'json',
        success: function (data) {
            if (data['result']) {
                swal.fire({
                    title: "Отлично!",
                    text: text,
                    icon: "success",
                }).then(() => {
                    if (data['userType'] == "admin") window.location.href = 'pages/mainAdmin.php';
                    else window.location.href = 'pages/mainClient.php';
                });
            } else {
                let arr = data['errors'];
                arr.forEach(function (data) {
                    let field = Object.getOwnPropertyNames(data);
                    let value = data[field];
                    let div = $(`#${field[0]}`);
                    div.addClass('has-danger');
                    div.next().html(value).css("color", "red").css("margin", "0px 7px");
                });
            }
        }
    });
}

$("#registration").submit(function(event){
    event.preventDefault();
    let formData = new FormData(this);

    submit(formData, 'modules/auth_reg/reg.php', "Пользователь успешно зарегистрирован!");
});
$("#authorization").submit(function(event) {
    event.preventDefault();
    let formData = new FormData(this);

    submit(formData, 'modules/auth_reg/auth.php', "Пользователь успешно авторизован!");
});

$(".btn-reg").click(function (){
    $("#auth").addClass("hidden");
    $("#reg").removeClass("hidden");
});
$(".btn-auth").click(function (){
    $("#reg").addClass("hidden");
    $("#auth").removeClass("hidden");
});

$("input[type='text'], input[type='email'], input[type='password']").bind('focus', function(){
    $(this).removeClass('has-danger');
    $(this).next().empty();
    $("#result").next().empty();
});