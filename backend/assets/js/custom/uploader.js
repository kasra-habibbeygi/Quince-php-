$(document).ready(function () {

    $('.input-file-custom').each(function () {
        var $input = $(this),
            $label = $input.next('.js-labelFile'),
            labelVal = $label.html();
    });

    // show img when browse
    $(".input-file-custom").change(function () {

        let input = this;

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {

                let fieldHTML = '<div class="remove_parent"><img class="uploading_img_from_brows" src="' + e.target.result + '"><div class="remove_img_icon remove"></div><button type="submit" name="chose_avatar" class="add_img_icon add"></button></div>';
                $(input).prev().append(fieldHTML);

            }

            reader.readAsDataURL(input.files[0]);
        }

    });

    $(document).on('click', '.remove', function (e) {

        $(this).parents('.img-show').next().val('');
        $(this).parent('.remove_parent').remove();

    });

});