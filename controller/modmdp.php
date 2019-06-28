<?php
    session_start();

    require_once('../model/profil.php');

    $profil = new profil;

    if (isset($_POST['mail'])) {
        $modmdp = $profil->mdpPerdu($_POST['mail']);
    }

    include_once('../view/modmdp.php');
?>