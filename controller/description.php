<?php
    session_start();

    require_once('../model/profil.php');
    require_once('../model/entreprise.php');

    $profil = new profil;
    
    if (isset($_SESSION['profil']) && is_array($_SESSION['profil']) && $_SESSION['profil']['admin'] == 1) {
        $verifProfil = $profil->verifProfil($_SESSION['profil']);

        if ($verifProfil == false) {
            unset($_SESSION['profil']);

            header('Location: ../index.php');
            exit();
        }else {
            $entreprise = new entreprise;

            $descript = $entreprise->description();

            include_once('../view/description_html.php');
        }
    }else {
        unset($_SESSION['profil']);
            
        header('Location: ../index.php');
        exit();
    }
?>