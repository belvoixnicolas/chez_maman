<?php
    session_start();

    require_once('../model/entreprise.php');

    if (isset($_POST['phrase'])) {
        $entreprise = new entreprise;

        echo json_encode($entreprise->setterphrase($_POST['phrase']));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Rien n\'a étais envoier au serveur'
        ));
    }
?>