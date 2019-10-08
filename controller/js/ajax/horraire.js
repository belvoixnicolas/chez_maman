$(document).ready(function(){
    //console.log(window.location.href);

    $('#message').on('click', 'button', function () {
        $('#message').addClass('hidden');
        setTimeout(function () {
            $('#message').removeClass('false true');
            $('#message .text').html('');
        }, 1500);

        //window.clearTimeout(delayMessage);
    });

    $('#formHorraire').on('submit', function () {
        event.preventDefault();
    });

    $('input[type=time]').on('blur', function () {
        var balise = this;
        var name = $(balise).attr('name');
        var val = $(balise).val();

        var repereTemp = name.split('_')[1];
        var autorisation = false;

        if (repereTemp == 'ouvertMat' || repereTemp == 'fermeMat') {
            if (val.replace(':', '') <= 1200 && val.replace(':', '') != '') {
                autorisation = true;
            }else {
                $('#message .text').html('Les horaires matinal sont comprises entre 0h et 12h');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }
        }else if (repereTemp == 'ouvertAp' || repereTemp == 'fermeAp') {
            if (val.replace(':', '') <= 2359 && val.replace(':', '') >= 1200 && val.replace(':', '') != '' || val.replace(':', '') == 0000 && val.replace(':', '') != '') {
                autorisation = true;
            }else {
                $('#message .text').html('Les horaires de l\'après-midi sont comprises entre 12h et 23h59');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }
        }else {
            $('#message .text').html('Une erreur c\'est produit. Veillez recharger la page');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        }

        if (autorisation) {
            var formData = new FormData();
            formData.append('name', name);
            formData.append('val', val);

            $.ajax({
                url : 'modhorraire.php',
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

                        if (data.time) {
                            $(balise).val(data.time);
                        }
                        
                        var delayMessage = window.setTimeout(function () {
                            $('#message button').trigger('click');
                        }, 5000);
                    }else {
                        $('#message .text').html(data.text);
                        $('#message').addClass('false').removeClass('hidden');

                        if (data.time) {
                            $(balise).val(data.time);
                        }
                        
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