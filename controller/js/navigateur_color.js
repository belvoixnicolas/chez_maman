$(document).ready(function(){
    var couleur = $(".bar").css('backgroundColor');
    
    $("meta[name=theme-color]").attr('content', couleur);
});