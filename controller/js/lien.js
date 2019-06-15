$(document).ready(function(){
    var test = document.querySelectorAll('main article');

    var liste = "";
    for (let index = 0; index < test.length; index++) {
         var id = test[index].getAttribute("id");
         liste += "<li><a href=\"#" + id + "\">" + id + "</a></li>"
    }

    console.log(liste);

    $('nav .menu ul').html(liste);
});