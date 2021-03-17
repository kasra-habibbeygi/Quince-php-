$('.close_error').click(() => {

    $('.error_field').removeClass('active');

});

function activeAlert(text) {

    $('.error_field').addClass('active');
    $('.error_field p').text(text);

}

setTimeout(() => {

    if ($('.error_field').hasClass('access-denied'))
        activeAlert('ابتدا وارد شوید .');

    else if ($('.error_field').hasClass('wrong-input'))
        activeAlert('ایمیل یا نام کاربری اشتباه است .');

    else if ($('.error_field').hasClass('user-notfound'))
        activeAlert('کاربر یافت نشد .');

    else if ($('.error_field').hasClass('empty-input'))
        activeAlert('لطفا ایمیل و رمز عبور خود را وارد کنید .');

}, 100);