<?php
    session_start();

    require_once('../model/avie.php');

    if (isset($_SESSION['profil']['admin'], $_POST['id'], $_POST['action'])) {
        switch ($_POST['action']) {
            case 'afficher':
                $avie = new avie;

                echo json_encode($avie->setafficher((int)$_POST['id']));
                break;

            case 'sup':
                $avie = new avie;

                echo json_encode($avie->supafficher((int)$_POST['id']));
                break;
            
            default:
                echo json_encode(array(
                    'result' => false,
                    'text' => 'Cette action n \'est pas reconue'
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