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

    if (isset($_POST['mail']) && isset($_POST['mdp'])) {
        if (isset($_POST['souv'])) {
            $souv = true;
        }else {
            $souv = false;
        }

        if ($connexion = $profil->connexion($_POST['mail'], $_POST['mdp'], $souv)) {
            $_SESSION['profil'] = $connexion;
            header('Location: ../index.php?page=admin');
            exit();
        }else {
            $connexion = false;
        }
    }

    include_once ('../view/connexion_html.php');
?>