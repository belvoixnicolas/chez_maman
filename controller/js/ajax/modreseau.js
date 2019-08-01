$(document).ready(function(){
    //console.log(window.location.href);

    $('#message').on('click', 'button', function () {
        $('#message').removeClass('true false').addClass('hidden');
        $('#message .text').html('');

        //window.clearTimeout(delayMessage);
    });

    $('body').on('click', '#form #fermer', function () {
        $('#form').remove();
    });

    $('body').on('click', '#modreseau', function () {
        var id = $(this).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'modreseau');

        $.ajax({
            url : 'modreseau.php',
            type : 'POST',
            data : formData,
            dataType: 'html',
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
        }).done(function (data) {
            if (data != 'false' && data != 'false id') {
                $('body').append(data);
            }else if (data == 'false') {
                $('#message .text').html('L\'id du reseau n\'a pas étais envoyer');
                $('#message').addClass('false').removeClass('hidden');
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }else if (data == 'false id') {
                $('#message .text').html('L\'id du reseau ne corespond pas avec la base de donner');
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

    $('#formreseau #image[data-preview]').on('change', function () {
        var input	= $(this);
		var oFReader	= new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload	= function(oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        }
    });

    $('body').on('change', '#formmodreseau #image[data-preview]', function () {
        var input	= $(this);
		var oFReader	= new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload	= function(oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        }
    });

    $('#formreseau').on('submit', function () {
        event.preventDefault();

        var form = document.getElementById('formreseau');
        
        var formData = new FormData(form);
        formData.append('action', 'addreseau');

        $.ajax({
            url : 'modreseau.php',
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

                    $('#formreseau img').attr('src', null);
                    $('#formreseau #image').val(null);
                    $('#formreseau #titre').val(null);
                    $('#formreseau #url').val(null);

                    if (data.html) {
                        $('#sectionreseau ul').prepend(data.html);
                    }

                    if (data.html) {
                        $('.listeproduit ul').prepend(data.html);
                    }
                    
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

    $('body').on('submit', '#formmodreseau', function () {
        event.preventDefault();

        var form = document.getElementById('formmodreseau');
        
        var formData = new FormData(form);
        formData.append('action', 'modformreseau');

        $.ajax({
            url : 'modreseau.php',
            type : 'POST',
            data : formData,
            dataType: 'json',
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
        }).done(function (data) {
            console.log(data);
            /*if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                if (data.result) {
                    $('#message .text').html(data.text);
                    $('#message').addClass('true').removeClass('hidden');

                    $('#formreseau img').attr('src', null);
                    $('#formreseau #image').val(null);
                    $('#formreseau #titre').val(null);
                    $('#formreseau #url').val(null);

                    if (data.html) {
                        $('#sectionreseau ul').prepend(data.html);
                    }

                    if (data.html) {
                        $('.listeproduit ul').prepend(data.html);
                    }
                    
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
            }*/
        }).fail(function () {
            console.log('fail');
            $('#message .text').html('Une erreur c\'est produit');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });
});