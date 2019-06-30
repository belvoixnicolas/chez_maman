<?php
    session_start();

    require_once('../model/entreprise.php');

    if (isset($_POST['tel'])) {
        $entreprise = new entreprise;

        echo json_encode($entreprise->setternumero((int)$_POST['tel']));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Rien n\'a étais envoier au serveur'
        ));
    }
?>