$(document).ready(function(){
    var test = document.querySelectorAll('main article');

    var liste = "";
    for (let index = 0; index < test.length; index++) {
         var id = test[index].getAttribute("id");
         var text = id.replace(/_/gi, ' ');

         liste += "<li><a href=\"#" + id + "\">" + text.charAt(0).toUpperCase() + text.substring(1).toLowerCase() + "</a></li>"
    }

    console.log(liste);

    $('nav .menu ul').html(liste);
});