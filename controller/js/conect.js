function verifMail() {
    var val = $('#mail').val();

    if (val.toUpperCase() == "ADMIN@ADMIN") {
        $("#souv").attr('disabled', '');
    }else {
        $("#souv").removeAttr('disabled');
    }
}

$(document).ready(function(){
    var falseClass = $('#message').hasClass('false');
    var trueClass = $('#message').hasClass('true');

    if (falseClass || trueClass) {
        var delayMessage = window.setTimeout(function () {
            $('#message button').trigger('click');
        }, 5000);
    }

    $('#message').on('click', 'button', function () {
        $('#message').addClass('hidden');
        setTimeout(function () {
            $('#message').removeClass('false true');
            $('#message .text').html('');
        }, 1500);

        //window.clearTimeout(delayMessage);
    });

    verifMail();

    $('#mail').on('keyup change', verifMail);
});