<?php
    session_start();

    require_once('../model/profil.php');

    $profil = new profil;

    if (isset($_POST['mail'], $_POST['pwd'], $_SESSION['profil']['id'], $_SESSION['profil']['mail'])) {
        $modident = $profil->modident($_POST['mail'], $_POST['pwd'], $_SESSION['profil']['id']);

        $mailresu = explode('|', $modident)[0];

        if ($mailresu) {
            $_SESSION['profil']['mail'] = $_POST['mail'];
        }

        echo $modident;
    }elseif (isset($_POST['mail'], $_SESSION['profil']['id'], $_SESSION['profil']['mail'])) {
        $modmail = $profil->modifmail($_POST['mail'], $_SESSION['profil']['id']);

        if (is_bool($modmail)) {
            if ($modmail) {
                $_SESSION['profil']['mail'] = $_POST['mail'];
            }

            echo $modmail;
        }else {
            echo false;
        }
    }else if (isset($_POST['pwd'], $_SESSION['profil']['id'])) {
        $modpwd = $profil->modifpwd($_POST['pwd'], $_SESSION['profil']['id']);

        if (is_bool($modpwd)) {
            echo $modpwd;
        }else {
            echo false;
        }
    }else {
        echo false;
    }
?>