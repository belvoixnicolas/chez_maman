$(document).ready(function(){
    //console.log(window.location.href);

    $('#navbaradmin .bar .menuBurger').on('click', function () {
        var atribut = $('.menuBurger i').attr('class');

        if (atribut == 'fas fa-bars') {
            $('.menuBurger i').removeClass().addClass('fas fa-times');
        }else {
            $('.menuBurger i').removeClass().addClass('fas fa-bars');
        }

        if ($('.menuBurger i').hasClass('fas fa-times')) {
            $('nav .menu').removeClass('close');
        }else {
            $('nav .menu').addClass('close');
        }
    });

    $('#navbaradmin .menu #deconnexion').on('click', function () {
        event.preventDefault();
        
        $.post("deconnexion.php", {ajax: 'true'}).done(function (data) {
            if (data == true) {
                window.location.replace("../index.php");
            }else {
                window.location.replace("deconnexion.php");
            }
        }).fail(function () {
            window.location.replace("deconnexion.php");
        });
    });
});