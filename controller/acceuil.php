<?php
    session_start();

    require_once('../model/navbar.php');
    require_once('../model/entreprise.php');

    $lien = new navbar;
    $lien = $lien->lien();

    $entreprise = new entreprise;
    $titre = $entreprise->titre();
    $logo = $entreprise->logo();
    $phrase = $entreprise->phrase();
    $video = $entreprise->video();
    $description = $entreprise->description();

    include_once ('../view/acceuil_html.php');
?>