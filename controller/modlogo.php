<?php
    session_start();

    require_once('../model/entreprise.php');

    $entreprise = new entreprise;

    if (isset($_FILES['file']) && is_array($_FILES['file'])) {
        echo json_encode($entreprise->setterlogo($_FILES['file']));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Aucun fichier n\'a étais envoyer'
        ));
    }
?>