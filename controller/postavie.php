<?php
    require_once('../model/avie.php');

    if (isset($_POST['com']) && $_POST['com'] != '') {
        $avie = new avie;

        echo json_encode($avie->setAvie($_POST['com']));
    }elseif (isset($_POST['com']) && $_POST['com'] == '') {
        echo json_encode(array(
            'result' => false,
            'text' => 'Vous n\'avais rien écrit'
        ));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Aucun commentaire n\'a étais transmis'
        ));
    }
?>