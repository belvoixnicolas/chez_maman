$(document).ready(function(){
    //console.log(window.location.href);

    $('#commentaire .formulaire input[type=button]').on('click', function () {
        var textAvie = document.querySelector('#commentaire .formulaire input[name=com]').value;
        
        if (textAvie != '') {
            $.post("avie.php", {text: textAvie}).done(function (data) {
                if (data) {
                    document.querySelector('#commentaire .formulaire input[name=com]').value = '';

                    alert('Le commentaire est envoier');
                }else {
                    alert('Le commentaire n\'est pas envoier');
                }
            }).fail(function () {
                alert('Une erreur c\'est produit');
            });
        }
    });
});