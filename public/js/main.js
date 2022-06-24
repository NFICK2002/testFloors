// Модальное окно

$('.btn_change').click(function () {
    $(this).next('.modal').fadeIn()
});

$('#my_btn_reg').click(function () {
    $('.my_modal_reg').fadeIn()
});

// закрыть на крестик
$('.close').click(function () {
    $(this).closest('.modal').fadeOut()
});

$('.close_reg').click(function () {
    $(this).closest('.my_modal_reg').fadeOut()
});


// закрыть по клику вне окна
$(document).mouseup(function (e) {
    var popup = $('.modal_content');
    if (e.target !== popup && popup.has(e.target).length === 0) {
        $('.modal').fadeOut();
    }
});

$(document).mouseup(function (e) {
    var popup = $('.modal_content_reg');
    if (e.target !== popup && popup.has(e.target).length === 0) {
        $('.my_modal_reg').fadeOut();
    }
});


