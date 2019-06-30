<?php
    session_start();

    require_once('../model/entreprise.php');

    if (isset($_POST['titre']) && $_POST['titre'] != "") {
        $entreprise = new entreprise;

        echo json_encode($entreprise->settertitre($_POST['titre']));
    }else {
        echo json_encode('Aucun titre n\'a étais envoyer');
    }
?>