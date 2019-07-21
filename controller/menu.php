<?php
    session_start();

    require_once('../model/navbar.php');
    require_once('../model/menu.php');

    $nav = new navbar;
    $lien = $nav->lien();
    $etat = $nav->horraire();
    $lienAddress = $nav->address();
    $reseaux = $nav->reseau();
    $numero = $nav->numero();

    $menu = new menu;
    $menus = $menu->menus();

    include_once('../view/menu_html.php');
?>