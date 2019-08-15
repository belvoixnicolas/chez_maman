<?php
    session_start();

    require_once('../model/navbar.php');
    require_once('../model/menu.php');
    require_once('../model/Mobile_Detect.php');

    $nav = new navbar;
    $lien = $nav->lien();
    $etat = $nav->horraire();
    $lienAddress = $nav->address();
    $reseaux = $nav->reseau();
    $numero = $nav->numero();

    $menu = new menu;
    $menus = $menu->menus();

    $mobile = new Mobile_Detect;
    if ($mobile->isMobile() || $mobile->isTablet()) {
        $mobile = true;
    }else {
        $mobile = false;
    }

    include_once('../view/menu_html.php');
?>