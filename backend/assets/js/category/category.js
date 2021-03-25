$(document).ready(function () {
    $('.parent_select').select2();


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

        else if ($('.error_field').hasClass('category-exist'))
            activeAlert('این دسته بندی قبلا ثبت شده است .');

        else if ($('.error_field').hasClass('category-create')) {

            $('.error_field').removeClass('warning_error');
            $('.error_field').addClass('success_error');
            activeAlert('دسته بندی با موفقیت اضافه شد .');

        } else if ($('.error_field').hasClass('delete-row')) {

            $('.error_field').removeClass('warning_error');
            $('.error_field').addClass('success_error');
            activeAlert('دسته مورد نظر با موفقیت حذف شد .');

        }

    }, 100);

    // edit modal
    $('.edit_modal_btn').click(function () {

        $('.edit_modal').fadeIn();

        $('.close_edit_modal').click(function () {

            $('.edit_modal').fadeOut();

        })

    });
});