<?php
    session_start();

    require_once('../model/profil.php');
    require_once('../model/avie.php');

    $profil = new profil;
    
    if (isset($_SESSION['profil']) && is_array($_SESSION['profil'])) {
        $verifProfil = $profil->verifProfil($_SESSION['profil']);

        if ($verifProfil == false) {
            unset($_SESSION['profil']);

            header('Location: ../index.php');
            exit();
        }else {
            $avie = new avie;

            $avies = $avie->avies();
            $compteur = $avie->compteurafficher();

            include_once('../view/avie_html.php');
        }
    }else {
        unset($_SESSION['profil']);
            
        header('Location: ../index.php');
        exit();
    }
?>