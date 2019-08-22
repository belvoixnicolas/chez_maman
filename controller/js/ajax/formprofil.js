$(document).ready(function(){
    $('#message').on('click', 'button', function () {
        $('#message').addClass('hidden');
        setTimeout(function () {
            $('#message').removeClass('false true');
            $('#message .text').html('');
        }, 1500);

        //window.clearTimeout(delayMessage);
    });

    /// modifier admin ///
    $('#sectionprofil').on('click', '#modifprofil', function () {
        var balise = this;
        var val = $(this).attr("value");
        var data = {id: val, action: 'admin'};

        $.ajax({
            url : 'modprofil.php',
            type : 'POST',
            data : data,
            dataType: 'json'
        }).done(function (data) {
            if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                if (data.result) {
                    $('#message .text').html(data.text);
                    $('#message').addClass('true').removeClass('hidden');
                    if ($(balise).html() == '<i class="far fa-user"></i>'){
                        $(balise).html('<i class="fas fa-user"></i>');
                    }else {
                        $(balise).html('<i class="far fa-user"></i>');
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

    /// suprimer profil ///
    $('#sectionprofil').on('click', '#supprofil', function () {
        var val = $(this).attr('value');
        var tr = $(this).parent().parent();
        var data = {id: val, action: 'sup'};

        $.ajax({
            url : 'modprofil.php',
            type : 'POST',
            data : data,
            dataType: 'json'
        }).done(function (data) {
            if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                if (data.result) {
                    $('#message .text').html(data.text);
                    $('#message').addClass('true').removeClass('hidden');
                    $(tr).remove();
                    
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

    /// ajouter profil ///
    $('#formprofil').on('submit', function () {
        event.preventDefault();

        var mail = $('#formprofil #mailprofil').val();
        var nom = $('#formprofil #nomprofil').val();

        if (mail != '' && nom != '') {
            var formData = new FormData();
            formData.append('mail', $('#formprofil #mailprofil').val());
            formData.append('nom', $('#formprofil #nomprofil').val());
            formData.append('action', 'addprofil');

            $.ajax({
                url : 'modprofil.php',
                type : 'POST',
                data : formData,
                dataType: 'json',
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
            }).done(function (data) {
                if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                    if (data.result && typeof data.html !== 'undefined') {
                        $('#message .text').html(data.text);
                        $('#message').addClass('true').removeClass('hidden');

                        $('#formprofil #mailprofil').val(null);
                        $('#formprofil #nomprofil').val(null);
                        $('#sectionprofil table').append(data.html);
                        
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