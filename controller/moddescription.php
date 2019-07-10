<?php
    session_start();

    require_once('../model/entreprise.php');

    if (isset($_SESSION['profil']['admin'], $_POST['action']) && $_SESSION['profil']['admin'] == 1) {
        switch ($_POST['action']) {
            case 'modifier':
                if (isset($_POST['description'])) {
                    $entreprise = new entreprise;
                    
                    echo json_encode($entreprise->setterdescription($_POST['description']));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le texte de la description n\'a pas étais renseigner'
                    ));
                }
                break;

            case 'sup':
                $entreprise = new entreprise;

                echo json_encode($entreprise->supdescription());
                break;
            
            default:
                echo json_encode(array(
                    'result' => false,
                    'text' => 'Une erreur c\'est produit'
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