$(document).ready(function(){
    $('#message').on('click', 'button', function () {
        $('#message').addClass('hidden');
        setTimeout(function () {
            $('#message').removeClass('false true');
            $('#message .text').html('');
        }, 1500);

        //window.clearTimeout(delayMessage);
    });

    $('#formlogo').on('submit', function () {
        event.preventDefault();

        var inputLogo = $('#formlogo #logo').val();

        if (inputLogo != '') {
            var formData = new FormData();
            formData.append('file', $('#formlogo #logo')[0].files[0]);

            $.ajax({
                url : 'modlogo.php',
                type : 'POST',
                data : formData,
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
            }).done(function (data) {
                if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                    if (data.result) {
                        $('#sectionformlogo img').attr('src', 'src/logo/' + data.img);
                        $('#formlogo #logo').val(null);
                        $('#message .text').html(data.text);
                        $('#message').addClass('true').removeClass('hidden');
                        
                        var delayMessage = window.setTimeout(function () {
                            $('#message button').trigger('click');
                        }, 5000);
                    }else {
                        $('#formlogo #logo').val(null);
                        $('#message .text').html(data.text);
                        $('#message').addClass('false').removeClass('hidden');
                        
                        var delayMessage = window.setTimeout(function () {
                            $('#message button').trigger('click');
                        }, 5000);
                    }
                }else {
                    $('#formlogo #logo').val(null);
                    $('#message .text').html('Une erreur c\'est produit');
                    $('#message').addClass('false').removeClass('hidden');
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }
            }).fail(function () {
                $('#formlogo #logo').val(null);
                $('#message .text').html('Une erreur c\'est produit');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            });
        }
    });
});