<?php
    session_start();

    require_once('../model/profil.php');

    $profil = new profil;

    if (isset($_POST['ajax']) && $_POST['ajax']) {
        if ($profil->deco()) {
            echo true;
        }else {
            echo false;
        }
    }else {
        if ($profil->deco()) {
            header('Location: ../index.php');
        }else {
            session_destroy();
            header('Location: ../index.php');
        }
    }
?>