<?php
    session_start();

    require_once('../model/profil.php');

    if (isset($_SESSION['profil'])) {
        unset($_SESSION['profil']);
    }

    if (isset($_COOKIE['souv'])) {
        $mail = $_COOKIE['souv'];
    }

    $profil = new profil;

    if (isset($_POST['mail']) && isset($_POST['mdp']) && isset($_POST['souv'])) {
        if ($_POST['souv'] == 'on') {
            $_POST['souv'] = true;
        }else {
            $_POST['souv'] = false;
        }

        var_dump($profil->connexion($_POST['mail'], $_POST['mdp'], $_POST['souv']));
    }elseif (isset($_POST['mail']) && isset($_POST['mdp'])) {
        var_dump($profil->connexion($_POST['mail'], $_POST['mdp']));
    }

    include_once ('../view/connexion_html.php');
?>