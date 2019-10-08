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

    $('body').on('click', '#modproduit', function () {
        var id = $(this).val();

        var formData = new FormData();
        formData.append('id', id);
        formData.append('action', 'formproduit');

        $.ajax({
            url : 'modproduit.php',
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
            $('#message .text').html('Connexion avec le serveur perdu');
            $('#message').addClass('false').removeClass('hidden');
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });

    $('body').on('click', '#supproduit', function () {
        var id = $(this).val();

        if (confirm('Cette action va supprimer le produit')) {
            var formData = new FormData();
            formData.append('action', 'supproduit');
            formData.append('id', id);

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
    
                        $('.listeproduit #' + id).remove();
                        
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

    $('#formproduit #image[data-preview]').on('change', function () {
        var input	= $(this);
		var oFReader	= new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload	= function(oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        }
    });

    $('body').on('change', '#formproduitmod #image[data-preview]', function () {
        var input	= $(this);
		var oFReader	= new FileReader();
		oFReader.readAsDataURL(this.files[0]);
		oFReader.onload	= function(oFREvent) {
            $(input.data('preview')).attr('src', oFREvent.target.result);
        }
    });

    $('body').on('keydown', '#prix', function (event) {
        var touche = event.keyCode;
        
        if (touche == 110 || touche == 190 || touche == 59) {
            alert('Les points ne sont pas reconnus par le navigateur, utiliser les virgules à la place');
        }
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

    $('#formproduit').on('submit', function () {
        event.preventDefault();

        var form = document.getElementById('formproduit');
        
        var formData = new FormData(form);
        formData.append('action', 'addproduit');

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

                    $('#formproduit img').attr('src', null);
                    $('#formproduit #image').val(null);
                    $('#formproduit #titre').val(null);
                    $('#formproduit #text').val(null);
                    $('#formproduit #prix').val(null);

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
});