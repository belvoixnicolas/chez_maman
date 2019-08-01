<?php
    session_start();

    require_once('../model/reseaux.php');

    if (isset($_SESSION['profil']['admin'], $_POST['action']) && $_SESSION['profil']['admin'] == 1) {
        switch ($_POST['action']) {
            case 'addreseau':
                $reseaux = new reseaux;

                if (isset($_POST['titre'], $_POST['url'], $_FILES['image']) && $_POST['titre'] != '' && $_POST['url'] != '' && $_FILES['image']['size'] > 0) {
                    echo json_encode($reseaux->addReseau($_FILES['image'], $_POST['titre'], $_POST['url']));
                }elseif (isset($_POST['titre']) && $_POST['titre'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre n\'a pas été renseigner'
                    ));
                }elseif (isset($_POST['url']) && $_POST['url'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'url n\'a pas été renseigner'
                    ));
                }elseif (isset($_FILES['image']) && $_FILES['image']['size'] == 0) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Aucun fichier a été envoier'
                    ));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    ));
                }
                break;

            case 'modreseau':
                if (isset($_POST['id']) && $_POST['id'] != '' && $_POST['id'] > 0) {
                    $reseaux = new reseaux;

                    $reseau = $reseaux->formHtml($_POST['id']);

                    if (is_array($reseau) && $reseau) {
                        include('../view/form_reseau.php');
                    }else {
                        echo 'false';
                    }
                }else {
                    echo 'false';
                }
                break;

            case 'modformreseau':
                if (isset($_POST['id'], $_POST['titre'], $_POST['url'], $_FILES['image']) && $_POST['id'] != '' && $_POST['id'] > 0 && $_POST['titre'] != '' && strlen($_POST['titre']) <= 50 && $_POST['url'] != '' && strlen($_FILES['image']['name']) <= 50) {
                    $reseaux = new reseaux;

                    echo json_encode($reseaux->modReseau($_POST['id'], $_POST['titre'], $_POST['url'], $_FILES['image']));
                }elseif (isset($_POST['id']) && $_POST['id'] <= 0) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id transmis est erroner'
                    ));
                }elseif (isset($_POST['titre']) && $_POST['titre'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre est vide'
                    ));
                }elseif (isset($_POST['titre']) && strlen($_POST['titre']) > 50) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre ne peux faire plus de 50 caractéres'
                    ));
                }elseif (isset($_POST['url']) && $_POST['url'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'url est vide'
                    ));
                }elseif (isset($_FILES['image']) && strlen($_FILES['image']['name']) > 50) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le nom du fichier ne peux faire plus de 50 caractéres'
                    ));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    ));
                }
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