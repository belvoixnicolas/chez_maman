$(document).ready(function(){
    //console.log(window.location.href);

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