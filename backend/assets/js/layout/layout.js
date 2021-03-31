// error modal
$('#exit').click(function(){

    $('.exit_modal').fadeIn();

    $('#CEM').click(function(){

        $('.exit_modal').fadeOut();

    })

});

// collaps
for(let i = 0 ; i < $('.collaps_item button').length ; i++){

    $('.collaps_item button').eq(i).click(function(){

        if($(this).next().css('display') === 'none'){
            
            $('.collaps_item button').next().slideUp();
            $(this).next().slideDown();
            $('.collaps_item button').removeClass('collaps_on');
            $('.collaps_item button').eq(i).addClass('collaps_on');

        }else{

            $('.collaps_item button').next().slideUp(); 
            $('.collaps_item button').removeClass('collaps_on');

        }

    });

}

function redirect($url){
    window.location.href = $url;
}