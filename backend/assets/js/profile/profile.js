let tabs = $('.right_field .tabs_field button');
let proField = $('.profile_form');

for (let i = 0; i < tabs.length; i++) {

    tabs.eq(i).click(function () {

        tabs.removeClass('active');
        $(this).addClass('active');

        proField.removeClass('show');
        proField.eq(i).addClass('show');

        localStorage.tabs = i;

    });

    if (localStorage.tabs) {

        tabs.removeClass('active');
        tabs.eq(localStorage.tabs).addClass('active');

        proField.removeClass('show');
        proField.eq(localStorage.tabs).addClass('show');

    }

}

// errors
$('.close_error').click(() => {

    $('.error_field').removeClass('active');

});

function activeAlert(text) {

    $('.error_field').addClass('active');
    $('.error_field p').text(text);

}

setTimeout(() => {

    if ($('.error_field').hasClass('empty-input'))
        activeAlert('لطفا تمام ورودی ها پر کنید .');

    else if ($('.error_field').hasClass('invalid-input'))
        activeAlert('در وارد کردن اطلاعات دقت کنید .');

    else if ($('.error_field').hasClass('invalid-email'))
        activeAlert('ایمیل وارد شده نامعتبر است .');

    else if ($('.error_field').hasClass('invalid-phone'))
        activeAlert('شماره موبایل وارد شده اشتباه است .');

    else if ($('.error_field').hasClass('duplicate-email'))
        activeAlert('این ایمیل قبلا ثبت شده است .');

    else if ($('.error_field').hasClass('duplicate-username'))
        activeAlert('این نام کاربری قبلا ثبت شده است .');

    else if ($('.error_field').hasClass('short-pass'))
        activeAlert('رمز عبور باید بیشتر از 8 رقم باشد .');

    else if ($('.error_field').hasClass('dont-match'))
        activeAlert('رمز عبور جدید با تکرار رمز عبور جدید یکی نیست .');

    else if ($('.error_field').hasClass('incorect-pass'))
        activeAlert('رمز عبوری فعلی شما اشتباه است .');

    else if ($('.error_field').hasClass('upload-error'))
        activeAlert('در بارگذاری عکس مشکلی به وجود آمده است .');

    else if ($('.error_field').hasClass('type-denied'))
        activeAlert('پسوند عکس مجاز نمی باشد .');

    else if ($('.error_field').hasClass('update-error-2'))
        activeAlert('ارور به دلایل نامعلوم .');

    else if ($('.error_field').hasClass('DB-error'))
        activeAlert('مشکل در ارتباط با سرور .');
        
    else if ($('.error_field').hasClass('avatar-deleted')){

        $('.error_field').removeClass('warning_error');
        $('.error_field').addClass('success_error');
        activeAlert('عکس پروفایل با موفقیت حذف شد .');
        
    }

    else if ($('.error_field').hasClass('profile-update')) {

        $('.error_field').removeClass('warning_error');
        $('.error_field').addClass('success_error');
        activeAlert('اطلاعات پروفایل با موفقیت ویرایش شد .');

    }

}, 100);