<?php
    session_start();

    require_once('../model/profil.php');

    if (isset($_SESSION['profil']['admin'], $_POST['id'], $_POST['action']) && $_SESSION['profil']['admin'] == 1) {
        switch ($_POST['action']) {
            case 'admin':
                $profil = new profil;

                echo json_encode($profil->modadmin((int)$_POST['id']));
                break;
            
            default:
                echo json_encode(array(
                    'result' => false,
                    'text' => 'Erreur'
                ));
                break;
        }
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Vous n\'éte pas autoriser a faire cette action'
        ));
    }
?>