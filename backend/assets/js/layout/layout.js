// error modal
$('#exit').click(function(){

    $('.exit_modal').fadeIn();

    $('#CEM').click(function(){

        $('.exit_modal').fadeOut();

    })

});

function redirect($url){

    location.href = $url;

}