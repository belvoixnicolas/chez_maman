<?php
    session_start();

    require_once('../model/profil.php');
    require_once('../model/horraire.php');

    $profil = new profil;

    if (isset($_SESSION['profil']['admin'], $_POST['name'], $_POST['val']) && $_POST['name'] != '' && $_POST['val'] != '' && $profil->verifProfil($_SESSION['profil']) && $_SESSION['profil']['admin'] == 1) {
        $repere = explode('_', $_POST['name']);

        if (is_array($repere)) {
            $horraire = new horraire;

            $jour = $repere[0];
            $indicateur = $repere[1];
            $val = $_POST['val'];

            echo json_encode($horraire->setHorraire($jour, $indicateur, $val));
        }else {
            echo json_encode(array(
                'result' => false,
                'text' => 'Une erreur c\'est produit'
            ));
        }
    }elseif (isset($_POST['name'], $_POST['val']) == false || $_POST['name'] == '' || $_POST['val'] == '') {
        echo json_encode(array(
            'result' => false,
            'text' => 'Il manque une valeur'
        ));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Vous n\'éte pas autoriser a faire cette action'
        ));
    }
?>