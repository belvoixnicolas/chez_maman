$(document).ready(function(){
    $("nav .menuBurger").on('click', function () {
        var atribut = $('.menuBurger i').attr('class');

        if (atribut == 'fas fa-bars') {
            $('.menuBurger i').removeClass().addClass('fas fa-times');
            $('nav .menu').removeClass('close');
        }else {
            $('.menuBurger i').removeClass().addClass('fas fa-bars');
            $('nav .menu').addClass('close');
        }
    });

    $(".menu a").on('click', function () {
        $('.menuBurger i').removeClass().addClass('fas fa-bars');
        $('nav .menu').addClass('close');
    });
});