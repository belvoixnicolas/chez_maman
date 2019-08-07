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

    $('.services').on('click', '#modimg', function () {
        var id = $(this).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'formimg');

        $.ajax({
            url : 'modservice.php',
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

    $('.services').on('click', '#modtext', function () {
        var id = $(this).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'formtext');

        $.ajax({
            url : 'modservice.php',
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

    $('.services').on('click', '#supservice', function () {
        var id = $(this).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'sup');

        $.ajax({
            url : 'modservice.php',
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
                    
                    $('.services #' + id).remove();
                    $('#form').remove();
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');

                    $('#formserviceimg #img').val(null);
                    
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
            $('#message .text').html('Connexion avec le serveur perdue');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });

    $('body').on('click', '#form #fermer', function () {
        $('#form').remove();
    });

    $('body').on('submit', '#formserviceimg', function () {
        event.preventDefault();

        var id = $('#formserviceimg').attr('value');
        
        var formData = new FormData();
        formData.append('file', $('#formserviceimg #img')[0].files[0]);
        formData.append('action', 'modimg');
        formData.append('id', id);

        $.ajax({
            url : 'modservice.php',
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

                    var img = $('#formserviceimg #img')[0].files[0]['name'];
                    
                    $('.services #' + id + ' img').attr('src', 'src/services/' + img);
                    $('#form').remove();
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');

                    $('#formserviceimg #img').val(null);
                    
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

    $('body').on('submit', '#formservicetext', function () {
        event.preventDefault();

        var id = $('#formservicetext').attr('value');
        form = document.getElementById('formservicetext');
        
        var formData = new FormData(form);
        formData.append('action', 'modtext');
        formData.append('id', id);

        $.ajax({
            url : 'modservice.php',
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

                    var text = $('#formservicetext #text').val();
                    
                    $('.services #' + id + ' p').html(text);
                    $('#form').remove();
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');

                    $('#formserviceimg #img').val(null);
                    
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

    $('#formservice #image[data-preview]').on('change', function () {
        var input	= $(this);
		var oFReader	= new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload	= function(oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        }
    });

    $('#formservice').on('submit', function () {
        event.preventDefault();

        form = document.getElementById('formservice');
        
        var formData = new FormData(form);
        formData.append('action', 'addservice');

        $.ajax({
            url : 'modservice.php',
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

                    $('.services ul').prepend(data.html);
                    $('#formservice #titre').val(null);
                    $('#formservice #image').val(null);
                    $('#formservice #txt').val(null);
                    $('#formservice img').attr('src', null);
                    $('#form').remove();
                    
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
                $('#message .text').html(data.text);
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }
        }).fail(function () {
            $('#message .text').html('Une erreur c\'est produi');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });
});