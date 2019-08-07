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

    $('body').on('click', '#form #fermer', function () {
        $('#form').remove();
    });

    $('body').on('click', '#modmenu', function () {
        var id = $(this).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'formmenu');

        $.ajax({
            url : 'modmenu.php',
            type : 'POST',
            data : formData,
            dataType: 'html',
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
        }).done(function (data) {
            if (data != 'false' && data != 'false id') {
                $('body').append(data);
            }else if (data == 'false') {
                $('#message .text').html('L\'id du service n\'a pas étais envoyer');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }else if (data == 'false id') {
                $('#message .text').html('L\'id du service ne corespond pas avec la base de donner');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }else {
                $('#message .text').html('Une erreur c\'est produit');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }
        }).fail(function () {
            $('#message .text').html('Connexion avec le serveur perdue');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });

    $('body').on('click', '#supmenu', function () {
        var id = $(this).val();

        if (confirm('Cette action va suprimer le menu et tout les produit qui le concerne')) {
            var formData = new FormData();
            formData.append('action', 'supmenu');
            formData.append('id', id);

            $.ajax({
                url : 'modmenu.php',
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
    
                        $('.listemenu #' + id).remove();
                        
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
        }
    });

    $('#formmenu #image[data-preview]').on('change', function () {
        var input	= $(this);
		var oFReader	= new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload	= function(oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        }
    });

    $('body').on('change', '#formmenumod #image[data-preview]', function () {
        var input	= $(this);
		var oFReader	= new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload	= function(oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        }
    });

    $('body').on('submit', '#formmenumod', function () {
        event.preventDefault();

        var id = $('#formmenumod').attr('value');
        var form = document.getElementById('formmenumod');
        
        var formData = new FormData(form);
        formData.append('action', 'modmenu');
        formData.append('id', id);

        $.ajax({
            url : 'modmenu.php',
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

                    $('.listemenu #' + data.data.id + ' img').attr('src', 'src/menu/' + data.data.image);
                    $('.listemenu #' + data.data.id + ' h3').text(data.data.titre);
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

    $('#formmenu').on('submit', function () {
        event.preventDefault();

        var form = document.getElementById('formmenu');
        
        var formData = new FormData(form);
        formData.append('action', 'addmenu');

        $.ajax({
            url : 'modmenu.php',
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

                    $('#formmenu img').attr('src', null);
                    $('#formmenu #titre').val(null);
                    $('#formmenu #image').val(null);

                    if (data.html) {
                        $('.listemenu ul').prepend(data.html);
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