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

        else if($('.error_field').hasClass('delete-failed'))
            activeAlert('مشکلی در حذف دسته به وجود آمده است .');

        else if($('.error_field').hasClass('create-failed'))
            activeAlert('مشکلی در اینجاد دسته بندی به وجود آمده است .');

        else if ($('.error_field').hasClass('category-create')) {

            $('.error_field').removeClass('warning_error');
            $('.error_field').addClass('success_error');
            activeAlert('دسته مورد نظر با موفقیت اضافه شد .');

        }else if ($('.error_field').hasClass('delete-confirm')) {

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

    // delete confirm
    $('.delete_confirm').click(function(){

        $('.delete_modal').fadeIn();
        let delete_text = $(this).parent().parent().children('td:nth-child(3)').text();
        let delete_row_id = $(this).parent().parent().children('td:nth-child(2)').attr('data-id');
        let sub_menu_count = $(this).parent().parent().children('td:nth-child(6)').text();
        $('.delete_modal .content p').text(`آیا برای حذف دسته ${delete_text} اطمینان دارید ؟`);
        $('.delete_modal .content a').attr('href' , `?delete-row=${delete_row_id}`);

        if($(this).parent().parent().children('td:nth-child(4)').text() === 'دسته اصلی')
            $('.delete_modal .content span').html(`توجه : به دلیل اینکه ${delete_text} دسته اصلی است ، تمام زیر دسته ها نیز حذف می شوند . <span>تعداد زیر دسته ها : ${sub_menu_count}<span>`).show();

        else
            $('.delete_modal .content span').hide();

        $('#CDCM').click(function(){

            $('.delete_modal').fadeOut();

        })

    });

    // get row id when check the checkbox
    let check_list = [];
    let check_all = [];
    $('.Q_checkbox').click(function(){

        let del_value = $(this).val();
        if($(this).is(':checked')){

            check_list.push(del_value);

        }else{

            let delVal_index = check_list.indexOf(del_value);
            check_list.splice(delVal_index , 1);

        }

        window.final_result = check_list.join(',');
        check_all = [];

        for(let j = 0 ; j < $('.Q_checkbox:checked').length ; j++)
            check_all.push('1');
        
        if(check_all.length == $('.Q_checkbox').length - 1)
            $('.check_all').attr('checked' , true);

    });

    //check all
    $('.check_all').change(function(){

        if($('.check_all').is(':checked')){

            $('.Q_checkbox').prop('checked' , true);

            check_list = [];
            for(let i = 0 ; i < $('.Q_checkbox').length ; i++){

                check_list.push($('.Q_checkbox').eq(i).val());

            }
            check_list.splice(0 , 1);
            window.final_result = check_list.join(',')

        }else{

            $('.Q_checkbox').prop('checked' , false);
            check_list = [];
            window.final_result = check_list.join(',')

        }

    });

    // delete all category
    $('.delete_all').click(function(){
        

        if(window.final_result != undefined && window.final_result != ''){

            $('.delete_modal').fadeIn();
            $('.delete_modal .content p').text(`آیا از حذف تمام دسته های انتخاب شده اطمینان دارید ؟`);
            $('.delete_modal .content a').attr('href' , `?delete-all=${window.final_result}`);
            $('.delete_modal .content span').hide();

        }else{

            $('.error_field').removeClass('success_error');
            $('.error_field').addClass('warning_error');
            activeAlert('هنوز دسته ای انتخاب نشده است .');

        }

        $('#CDCM').click(function(){

            $('.delete_modal').fadeOut();

        });

    });

});