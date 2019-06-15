<?php
    session_start();

    require_once('../model/navbar.php');

    $lien = new navbar;
    $lien = $lien->lien();

    include_once('../view/menu_html.php');
?>