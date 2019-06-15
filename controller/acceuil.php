<?php
    session_start();

    require_once('../model/navbar.php');

    $lien = new navbar;
    $lien = $lien->lien();

    include_once ('../view/acceuil_html.php');
?>