<?php
    session_start();

    require_once('../model/entreprise.php');

    if (isset($_SESSION['profil']['admin']) && $_SESSION['profil']['admin'] == 1) {
        $entreprise = new entreprise;

        echo json_encode($entreprise->setVideo($_FILES['video']));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Vous n\'éte pas autoriser a faire cette action'
        ));
    }
?>