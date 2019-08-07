$(document).ready(function(){
    $('#message').on('click', 'button', function () {
        $('#message').addClass('hidden');
        setTimeout(function () {
            $('#message').removeClass('false true');
            $('#message .text').html('');
        }, 1500);

        //window.clearTimeout(delayMessage);
    });

    $('#gestionavie').on('click', '#buttonfavorie', function () {
        var button = $(this);
        var li = $(button).parent();
        var id = $(button).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'afficher');

        $.ajax({
            url : 'modavie.php',
            type : 'POST',
            data : formData,
            dataType: 'json',
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
        }).done(function (data) {
            if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                if (data.result && typeof data.afficher == 'boolean') {
                    $('#message .text').html(data.text);
                    $('#message').addClass('true').removeClass('hidden');

                    var i = $(button).html();

                    if (i == '<i class="fas fa-star"></i>') {
                        $(button).html('<i class="far fa-star"></i>');
                    }else {
                        $(button).html('<i class="fas fa-star"></i>');
                    }

                    $(li).remove();

                    if (data.afficher) {
                        $('#gestionavie .avies ul').prepend(li);
                    }else {
                        $('#gestionavie .avies ul').append(li);
                    }

                    if (typeof data.compteur !== 'undefined') {
                        $('#gestionavie .nbfav span').text(data.compteur);
                    }
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }
            }else {
                $('#message .text').html('Une erreur c\'est produit');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }
        }).fail(function () {
            $('#message .text').html('Une erreur c\'est produit');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });

    $('#gestionavie').on('click', '#buttonsup', function () {
        var li = $(this).parent();
        var id = $(this).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'sup');

        $.ajax({
            url : 'modavie.php',
            type : 'POST',
            data : formData,
            dataType: 'json',
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
        }).done(function (data) {
            if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                if (data.result) {
                    $('#message .text').html(data.text);
                    $('#message').addClass('true').removeClass('hidden');

                    $(li).remove();

                    if (typeof data.compteur !== 'undefined') {
                        $('#gestionavie .nbfav span').text(data.compteur);
                    }
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }
            }else {
                $('#message .text').html('Une erreur c\'est produit');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }
        }).fail(function () {
            $('#message .text').html('Une erreur c\'est produit');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });
});