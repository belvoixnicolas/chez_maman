$(document).ready(function(){
    $('#message').on('click', 'button', function () {
        $('#message').addClass('hidden');
        setTimeout(function () {
            $('#message').removeClass('false true');
            $('#message .text').html('');
        }, 1500);

        //window.clearTimeout(delayMessage);
    });

    $('#formphrase').on('submit', function () {
        event.preventDefault();

        if ($('#formphrase #phrase').length == 1) {
            var formData = new FormData();
            formData.append('phrase', $('#formphrase #phrase').val());

            $.ajax({
                url : 'modphrase.php',
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
        }
    });
});