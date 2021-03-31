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

        else if($('.error_field').hasClass('edit-failed'))
            activeAlert('مشکلی در ویرایش دسته به وجود آمده است .');

        else if ($('.error_field').hasClass('category-create')) {

            $('.error_field').removeClass('warning_error');
            $('.error_field').addClass('success_error');
            activeAlert('دسته مورد نظر با موفقیت اضافه شد .');

        }else if ($('.error_field').hasClass('delete-confirm')) {

            $('.error_field').removeClass('warning_error');
            $('.error_field').addClass('success_error');
            activeAlert('دسته مورد نظر با موفقیت حذف شد .');

        }else if ($('.error_field').hasClass('edit-confirm')) {

            $('.error_field').removeClass('warning_error');
            $('.error_field').addClass('success_error');
            activeAlert('دسته مورد نظر با موفققیت ویرایش شد .');

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
    $('.check_row').click(function(){

        let del_value = $(this).val();
        if($(this).is(':checked')){

            check_list.push(del_value);

        }else{

            let delVal_index = check_list.indexOf(del_value);
            check_list.splice(delVal_index , 1);

        }

        window.final_result = check_list.join(',');
        check_all = [];

        for(let j = 0 ; j < $('.check_row:checked').length ; j++)
            check_all.push('1');
        
        if(check_all.length == $('.check_row').length)
            $('.check_all').attr('checked' , true);
        
        else
            $('.check_all').attr('checked' , false);

    });

    //check all
    $('.check_all').click(function(){

        if($('.check_all').is(':checked')){

            $('.check_row').prop('checked' , true);
            $('.check_all').attr('checked' , true);

            check_list = [];
            for(let i = 0 ; i < $('.check_row').length ; i++){

                check_list.push($('.check_row').eq(i).val());

            }
            window.final_result = check_list.join(',');

        }else{

            $('.check_row').prop('checked' , false);
            $('.check_all').attr('checked' , false);
            check_list = [];
            window.final_result = check_list.join(','); 

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

    // open edit modal
    $('.edit_modal_btn').click(function(){

        // fill category name and category select parent
        let row_id = $(this).attr('data-id');
        let parent_name = $(this).parent().parent().children('td:nth-child(4)').text();
        $('#modal_row_id').attr('value' , row_id);
        $('#ECN').val($(this).parent().parent().children('td:nth-child(3)').text());

        for(let x = 0 ; x < $('.ECP option').length ; x++){

            let option_text = $('.ECP option').eq(x).text();
            console.log(option_text)
            if(option_text == parent_name){

                $('.ECP option').eq(x).attr('selected' , true);
                $('.ECP').next().children().children().children('.select2-selection__rendered').text(option_text);

            }

        }

        // if select was main category , disabled select
        if($('.ECP').next().children().children().children('.select2-selection__rendered').text() == 'دسته اصلی')
            $('.ECP').attr('disabled' , true).next().addClass('select_disabled');

        else
            $('.ECP').attr('disabled' , false).next().removeClass('select_disabled');

        // fadein and fadeout
        $('.edit_modal').fadeIn();
        $('.close_edit_modal').click(function(){

            $('.edit_modal').fadeOut();
            $('.ECP option').attr('selected' , false);

        })

    });

    //row_count
    $('#row_count').change(function(){
    
        let row_count = $(this).val();
        redirect(`?page-count=${row_count}`);
    
    });

});
