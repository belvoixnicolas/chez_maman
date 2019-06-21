<?php
    session_start();

    require_once('../model/navbar.php');
    require_once('../model/section_menu.php');

    $lien = new navbar;
    $lien = $lien->lien();

    $menu = new sectionMenu;
    $menus = $menu->menus();

    include_once('../view/menu_html.php');
?>