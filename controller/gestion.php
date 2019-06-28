<?php
    session_start();

    require_once('../model/profil.php');

    $profil = new profil;
    
    if (isset($_SESSION['profil']) && is_array($_SESSION['profil'])) {
        $verifProfil = $profil->verifProfil($_SESSION['profil']);

        if ($verifProfil == false) {
            unset($_SESSION['profil']);

            header('Location: ../index.php');
            exit();
        }else {
            $session = $_SESSION['profil'];

            if ($session['admin'] == 0) {
                include_once('../view/gestion_perso_html.php');
            }elseif ($session['admin'] == 1) {
                if (isset($_GET['precis']) && $_GET['precis'] == 'perso') {
                    include_once('../view/gestion_perso_html.php');
                }elseif (isset($_GET['precis']) && $_GET['precis'] == 'entreprise') {
                    include_once('../view/gestion_entreprise_html.php');
                }else {
                    include_once('../view/gestion_entreprise_html.php');
                }
            }else {
                unset($_SESSION['profil']);
            
                header('Location: ../index.php');
                exit();
            }
        }
    }else {
        unset($_SESSION['profil']);
            
        header('Location: ../index.php');
        exit();
    }
?>