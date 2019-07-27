$(document).ready(function(){
    //console.log(window.location.href);

    $('#message').on('click', 'button', function () {
        $('#message').removeClass('true false').addClass('hidden');
        $('#message .text').html('');

        //window.clearTimeout(delayMessage);
    });


    $('body').on('submit', '#formproduitmod', function () {
        event.preventDefault();

        var form = document.getElementById('formproduitmod');
        
        var formData = new FormData(form);
        formData.append('action', 'modproduit');

        $.ajax({
            url : 'modproduit.php',
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

                    if (data.html && data.id) {
                        $('.listeproduit #' + data.id).html(data.html);
                    }
                    $('#form').remove();
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');

                    $('#formmenumod #img').val(null);
                    
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

    $('#formHorraire').on('submit', function () {
        event.preventDefault();
    });

    $('input[type=time]').on('focusout', function () {
        var balise = this;
        var name = $(balise).attr('name');
        var val = $(balise).val();

        var formData = new FormData();
        formData.append('name', name);
        formData.append('val', val);

        $.ajax({
            url : 'modproduit.php',
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

                    if (data.html && data.id) {
                        $('.listeproduit #' + data.id).html(data.html);
                    }
                    $('#form').remove();
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');

                    $('#formmenumod #img').val(null);
                    
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