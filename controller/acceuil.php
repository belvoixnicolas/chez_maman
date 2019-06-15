<?php
    session_start();

    require_once('../model/navbar.php');
    require_once('../model/entreprise.php');
    require_once('../model/avie.php');
    require_once('../model/service.php');

    $lien = new navbar;
    $lien = $lien->lien();

    $entreprise = new entreprise;
    $titre = $entreprise->titre();
    $logo = $entreprise->logo();
    $phrase = $entreprise->phrase();
    $video = $entreprise->video();
    $description = $entreprise->description();
    $address = $entreprise->address();

    $avie = new avie;
    $avies = $avie->avies();

    $service = new service;
    $services = $service->services();

    include_once ('../view/acceuil_html.php');
?>