$(document).ready(function(){
    //console.log(window.location.href);

    $('#message').on('click', 'button', function () {
        $('#message').removeClass('true false').addClass('hidden');
        $('#message .text').html('');

        //window.clearTimeout(delayMessage);
    });

    $('#formvideo').on('submit', function () {
        event.preventDefault();

        var form = document.getElementById('formvideo');
        
        var formData = new FormData(form);

        $('#sectionformvideo').append('<div id="progressbar"><div id="progress" pourcentage="0"></div><p>0%</p></div>');

        $.ajax({
            url : 'modvideo.php',
            type : 'POST',
            data : formData,
            xhr: function () {
                var xhr = $.ajaxSettings.xhr();

                xhr.upload.onprogress = function (e) {
                    // For uploads
                    if (e.lengthComputable) {
                        var pourcentage = (e.loaded / e.total) * 100;

                        $('#sectionformvideo #progressbar p').html(Math.round(pourcentage) + '%');
                        $('#sectionformvideo #progressbar #progress').attr('pourcentage', Math.round(pourcentage));
                    }
                };

                return xhr;
            },
            dataType: 'json',
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
        }).done(function (data) {
            console.log(data);
            if (typeof data == 'object' && typeof data.result !== 'undefined' && typeof data.text !== 'undefined') {
                if (data.result) {
                    $('#message .text').html(data.text);
                    $('#message').addClass('true').removeClass('hidden');

                    $('#sectionformvideo #progressbar').remove();

                    $('#formvideo #video').val(null);

                    if (data.video) {
                        $('#video').html('');
                        $('#video').attr('src', 'src/video/' + data.video);
                    }
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }else {
                    $('#message .text').html(data.text);
                    $('#message').addClass('false').removeClass('hidden');

                    $('#sectionformvideo #progressbar').remove();
                    
                    var delayMessage = window.setTimeout(function () {
                        $('#message button').trigger('click');
                    }, 5000);
                }
            }else {
                $('#message .text').html('Une erreur c\'est produit');
                $('#message').addClass('false').removeClass('hidden');

                $('#sectionformvideo #progressbar').remove();
                
                var delayMessage = window.setTimeout(function () {
                    $('#message button').trigger('click');
                }, 5000);
            }
        }).fail(function () {
            $('#message .text').html('Une erreur c\'est produit');
            $('#message').addClass('false').removeClass('hidden');

            $('#sectionformvideo #progressbar').remove();
            
            var delayMessage = window.setTimeout(function () {
                $('#message button').trigger('click');
            }, 5000);
        });
    });
});