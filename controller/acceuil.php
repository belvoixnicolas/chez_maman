<?php
    session_start();

    require_once('../model/navbar.php');
    require_once('../model/entreprise.php');
    require_once('../model/avie.php');
    require_once('../model/service.php');
    require_once('../model/horraire.php');

    $nav = new navbar;
    $lien = $nav->lien();
    $etat = $nav->horraire();
    $lienAddress = $nav->address();
    $reseaux = $nav->reseau();
    $numero = $nav->numero();

    $entreprise = new entreprise;
    $titre = $entreprise->titre();
    $logo = $entreprise->logo();
    $phrase = $entreprise->phrase();
    $video = $entreprise->video();
    $description = $entreprise->description();
    $address = $entreprise->address();

    $avie = new avie;
    $avies = $avie->avies(false);

    $service = new service;
    $services = $service->services();

    $horraire = new horraire;
    $horraireTab = $horraire->horraireTab();

    include_once('../view/acceuil_html.php');
?>