$(document).ready(function(){
    function viewport () {
        var viewport = $(window).width();
        console.log(viewport);

        if (viewport <= 430) {
            $('.bar .lien li:first-child').html('<a href="tel:+33324530905">Appeler</a>');
        }else {
            $('.bar .lien li:first-child').html('<button>Appeler</button>');
        }
    }

    viewport ();
    $("nav .menu").hide();
    var text = $('.bar .lien button').text();

    $("nav .menuBurger").on('click', function () {
        var atribut = $('.menuBurger i').attr('class');

        if (atribut == 'fas fa-bars') {
            $('.menuBurger i').removeClass().addClass('fas fa-times');
        }else {
            $('.menuBurger i').removeClass().addClass('fas fa-bars');
        }

        $('nav .menu').animate({width: 'toggle'}, 500);
    });

    $(".menu a").on('click', function () {
        $('.menuBurger i').removeClass().addClass('fas fa-bars');
        $('nav .menu').animate({width: 'toggle'}, 500);
    });

    $('.bar .lien').on('click', 'button', function () {
        if ($(this).attr('class') != 'tel') {
            $(this).addClass('tel').text('03.24.53.09.05');
        }else {
            $(this).removeClass().text(text);
        }
    });

    $('.formulaire input[type=button]').on('click', function () {
        var li = '<li>' + $('.commentaires ul li:first-child').html() + '</li>';

        var ul = $('.commentaires ul').html() + li;
        $('.commentaires ul').html(ul);
    });

    $(window).resize(function () {
        viewport();
    });
});