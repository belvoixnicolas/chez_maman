<?php
    session_start();

    require_once('../model/profil.php');

    if (isset($_SESSION['profil']['admin'], $_POST['id'], $_POST['action']) && $_SESSION['profil']['admin'] == 1) {
        switch ($_POST['action']) {
            case 'admin':
                $profil = new profil;

                echo json_encode($profil->modadmin((int)$_POST['id']));
                break;

            case 'sup':
                $profil = new profil;

                echo json_encode($profil->supprofil((int)$_POST['id']));
                break;
            
            default:
                echo json_encode(array(
                    'result' => false,
                    'text' => 'Erreur'
                ));
                break;
        }
    }elseif (isset($_SESSION['profil']['admin'], $_POST['mail'], $_POST['nom'], $_POST['action']) && $_POST['action'] == 'addprofil' && $_SESSION['profil']['admin'] == 1) {
        $profil = new profil;

        echo json_encode($profil->addProfil($_POST['mail'], $_POST['nom']));
    }else {
        echo json_encode(array(
            'result' => false,
            'text' => 'Vous n\'éte pas autoriser a faire cette action'
        ));
    }
?>