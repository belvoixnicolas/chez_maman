<?php
    session_start();

    require_once('../model/entreprise.php');
    require_once('../model/service.php');

    if (isset($_SESSION['profil']['admin'], $_POST['action']) && $_SESSION['profil']['admin'] == 1) {
        switch ($_POST['action']) {
            case 'formimg':
                $service = new service;

                if (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id'])) {
                    $id = (int)$_POST['id'];

                    include('../view/form_service_img.php');
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id']) == false) {
                    echo 'false id';
                }else {
                    echo 'false';
                }
                break;

            case 'formtext':
                $service = new service;

                if (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id'])) {
                    $id = (int)$_POST['id'];
                    $text = $service->service($id);

                    include('../view/form_service_text.php');
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id']) == false) {
                    echo 'false id';
                }else {
                    echo 'false';
                }
                break;

            case 'modimg':
                $service = new service;

                if (isset($_POST['id'], $_FILES['file']) && $_FILES['file']['name'] != '' && $_POST['id'] != '' && $service->verifid((int)$_POST['id'])) {
                    $id = (int)$_POST['id'];

                    echo json_encode($service->modimg($_FILES['file'], $id));
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du service ne corespond pas avec la base de donner'
                    ));
                }elseif (isset($_FILES['file']) && $_FILES['file']['name'] == '' || isset($_FILES['file']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Aucune image n\'a été envoyer'
                    ));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    ));
                }
                break;
            
            case 'modtext':
                $service = new service;

                if (isset($_POST['id'], $_POST['text']) && $_POST['text'] != '' && $_POST['id'] != '' && $service->verifid((int)$_POST['id'])) {
                    $id = (int)$_POST['id'];

                    echo json_encode($service->modtext($_POST['text'], $id));
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du service ne corespond pas avec la base de donner'
                    ));
                }elseif (isset($_POST['text']) && $_POST['text'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le text est vide'
                    ));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    ));
                }
                break;

            case 'addservice':
                $service = new service;

                if (isset($_POST['titre'], $_POST['txt'], $_FILES['image']) && $_POST['titre'] != '' && $_POST['txt'] && $_FILES['image']['name'] != '') {

                    echo json_encode($service->addservice($_POST['titre'], $_POST['txt'], $_FILES['image']));
                }elseif (isset($_POST['titre']) && $_POST['titre'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre n\'a pas été renseigner'
                    ));
                }elseif (isset($_POST['txt']) && $_POST['txt'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le texte n\'a pas été renseigner'
                    ));
                }elseif (isset($_FILES['image']) && $_FILES['image']['name'] == '' || isset($_FILES['image']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Aucune image n\'a été envoyer',
                        'test' => $_FILES
                    ));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    ));
                }
                break;

            case 'sup':
                $service = new service;

                if (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id'])) {
                    $id = (int)$_POST['id'];

                    echo json_encode($service->sup($id));
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifid((int)$_POST['id']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du service ne corespond pas avec la base de donner'
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