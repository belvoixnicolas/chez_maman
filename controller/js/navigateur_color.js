$(document).ready(function(){
    var couleurBar = $(".bar").css('backgroundColor');
    var couleurNavI = $(".menuBurger i").css('Color');
    var couleurI = $("nav a i").css('Color')

    if (typeof couleurBar !== 'undefined') {
        couleurBar = colorConvertor.toHexa(couleurBar ,false);
    }
    if (typeof couleurNavI !== 'undefined') {
        couleurNavI = colorConvertor.toHexa(couleurNavI ,false);
    }
    if (typeof couleurI !== 'undefined') {
        couleurI = colorConvertor.toHexa(couleurI ,false);
    }

    
    if (typeof couleurBar !== 'undefined') {
        var couleur = couleurBar;
    }else if (typeof couleurNavI !== 'undefined') {
        var couleur = couleurNavI;
    }else if (typeof couleurI !== 'undefined') {
        var couleur = couleurI;
    }else {
        var couleur = '#ffcccc';
    }

    $("meta[name=theme-color]").attr('content', couleur);
});