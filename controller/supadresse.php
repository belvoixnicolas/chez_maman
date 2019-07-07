<?php
    session_start();

    require_once('../model/entreprise.php');

    if ($_SESSION['profil']['admin'] == 1) {
        $profil = new entreprise;

        echo json_encode($profil->supadresse());
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Vous n\'éte pas autoriser a faire cette action'
        ));
    }
?>