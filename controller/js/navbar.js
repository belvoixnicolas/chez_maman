$(document).ready(function(){
    function viewport () {
        var viewport = $(window).width();
        console.log(viewport);

        /*if (viewport <= 490) {
            $('.bar .lien li:first-child').html('<a href="tel:+33324530905">Appeler</a>');
        }else {
            $('.bar .lien li:first-child').html('<button>Appeler</button>');
        }*/

        if (viewport <= 500) {
            $('#tel').removeClass();
            $('#pc').removeClass().addClass('none');
        } else {
            $('#pc').removeClass();
            $('#tel').removeClass().addClass('none');
        }
    }

    var couleur = $(".bar").css('backgroundColor');

    $("meta[name=theme-color]").attr('content', couleur);

    viewport ();
    var text = $('.bar .lien button').text();

    $("nav .menuBurger").on('click', function () {
        var atribut = $('.menuBurger i').attr('class');

        if (atribut == 'fas fa-bars') {
            $('.menuBurger i').removeClass().addClass('fas fa-times');
        }else {
            $('.menuBurger i').removeClass().addClass('fas fa-bars');
        }

        var menu = $('nav .menu').css('minWidth').slice(0, -2);

        if (menu == 0) {
            $('nav .menu').removeClass('close');
        }else {
            $('nav .menu').addClass('close');
        }
    });

    $(".menu a").on('click', function () {
        $('.menuBurger i').removeClass().addClass('fas fa-bars');
        $('nav .menu').addClass('close');
    });

    /*$('.bar .lien').on('click', 'button', function () {
        if ($(this).attr('class') != 'tel') {
            $(this).addClass('tel').text('03.24.53.09.05');
        }else {
            $(this).removeClass().text(text);
        }
    });*/

    /*$('.formulaire input[type=button]').on('click', function () {
        var li = '<li>' + $('.commentaires ul li:first-child').html() + '</li>';

        var ul = $('.commentaires ul').html() + li;
        $('.commentaires ul').html(ul);
    });*/

    $(window).resize(function () {
        viewport();
    });
});