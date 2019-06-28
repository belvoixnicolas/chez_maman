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

        if ($connexion = $profil->connexion($_POST['mail'], $_POST['mdp'], $_POST['souv'])) {
            $_SESSION['profil'] = $connexion;
            header('Location: ../index.php?page=admin');
            exit();
        }else {
            $connexion = false;
        }
    }elseif (isset($_POST['mail']) && isset($_POST['mdp'])) {
        if ($connexion = $profil->connexion($_POST['mail'], $_POST['mdp'])) {
            $_SESSION['profil'] = $connexion;
            header('Location: ../index.php?page=admin');
            exit();
        }else {
            $connexion = false;
        }
    }

    include_once ('../view/connexion_html.php');
?>