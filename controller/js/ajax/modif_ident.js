$(document).ready(function(){
    //console.log(window.location.href);

    $('#message').on('click', 'button', function () {
        $('#message').addClass('hidden');
        setTimeout(function () {
            $('#message').removeClass('false true');
            $('#message .text').html('');
        }, 1500);

        window.clearTimeout(delayMessage);
    });

    $('#formident input').on('keyup', function () {
        var name = $(this).attr('name');

        if ($(this).val() != '') {
            $('#formident input[name=verif' + name + ']').attr('disabled', false)
        }else {
            $('#formident input[name=verif' + name + ']').val('').attr('disabled', true);
        }
    });

    $('#formident').on('submit', function () {
        event.preventDefault();

        var mail = $('input[name=mail]').val();
        var verifMail = $('input[name=verifmail]').val();
        var pwd = $('input[name=pwd]').val();
        var verifPwd = $('input[name=verifpwd]').val();

        var post = false;

        if (mail != '' && verifMail != '' && pwd != '' && verifPwd != '') {
            if (mail == verifMail && pwd == verifPwd) {
                post = {mail: mail, pwd: pwd};
            }else {
                $('#formident input[name=verifmail]').val('').attr('disabled', true);
                $('#formident input[name=verifpwd]').val('').attr('disabled', true);
            }
        }else if (mail != '' && verifMail != '') {
            if (mail == verifMail) {
                post = {mail: mail};
            }else {
                $('#formident input[name=verifmail]').val('').attr('disabled', true);
            }
        }else if (pwd != '' && verifPwd != '') {
            if (pwd == verifPwd) {
                post = {pwd: pwd};
            }else {
                $('#formident input[name=verifpwd]').val('').attr('disabled', true);
            }
        }

        if (post) {
            $.post("mofifident.php", post).done(function (data) {
                if (data) {
                    if (data.indexOf('|') != -1) {
                        data = data.split('|');

                        if (data[0] == '0' && data[1] == '0') {
                            $('#message .text').html('L\'adresse mail et le mot de passe n\'on pas put étre modifier');
                            $('#message').addClass('false').removeClass('hidden');
                            
                            var delayMessage = window.setTimeout(function () {
                                $('#message button').trigger('click');
                            }, 5000);
                        }else if (data[0] == 0) {
                            $('#message .text').html('L\'adresse mail n\'a pas put étre modifier');
                            $('#message').addClass('false').removeClass('hidden');
                            $('#formident fieldset input[name=pwd]').val('').trigger('keyup');
                            
                            var delayMessage = window.setTimeout(function () {
                                $('#message button').trigger('click');
                            }, 5000);
                        }else if (data[1] == 0) {
                            $('#message .text').html('Le mot de passe n\'a pas put étre modifier');
                            $('#message').addClass('false').removeClass('hidden');
                            $('#formident fieldset input[name=mail]').val('').trigger('keyup');
                            
                            var delayMessage = window.setTimeout(function () {
                                $('#message button').trigger('click');
                            }, 5000);
                        }else {
                            $('#message .text').html('Les modiffications on bien étais mis a jour');
                            $('#message').addClass('true').removeClass('hidden');
                            $('#formident fieldset input').val('').trigger('keyup');
                            
                            var delayMessage = window.setTimeout(function () {
                                $('#message button').trigger('click');
                            }, 5000);
                        }
                    }else {
                        $('#message .text').html('La modiffication à bien étais mis a jour');
                        $('#message').addClass('true').removeClass('hidden');
                        $('#formident fieldset input').val('').trigger('keyup');
                        
                        var delayMessage = window.setTimeout(function () {
                            $('#message button').trigger('click');
                        }, 5000);
                    }
                }else {
                    $('#message .text').html('Une erreur c\'est produit');
                    $('#message').addClass('false').removeClass('hidden');
                    $('#formident fieldset input').val('').trigger('keyup');
                    
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