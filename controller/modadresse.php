<?php
    session_start();

    require_once('../model/entreprise.php');

    if (isset($_POST['nrue'], $_POST['rue'], $_POST['ville'], $_POST['cp'])) {
        $entreprise = new entreprise;

        echo json_encode($entreprise->setteraddress((int)$_POST['nrue'], $_POST['rue'], $_POST['ville'], (int)$_POST['cp']));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Une erreur c\'est produit'
        ));
    }
?>