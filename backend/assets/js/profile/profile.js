let tabs = $('.right_field button');
let proField = $('.profile_form');

for(let i = 0 ; i < tabs.length; i++){

    tabs.eq(i).click(function(){

        tabs.removeClass('active');
        $(this).addClass('active');

        proField.removeClass('show');
        proField.eq(i).addClass('show');

        localStorage.tabs = i;

    });

    if(localStorage.tabs){

        tabs.removeClass('active');
        tabs.eq(localStorage.tabs).addClass('active');

        proField.removeClass('show');
        proField.eq(localStorage.tabs).addClass('show');

    }

}