<?php
    session_start();

    require_once('../model/entreprise.php');
    require_once('../model/menu.php');

    if (isset($_SESSION['profil']['admin'], $_POST['action']) && $_SESSION['profil']['admin'] == 1 || $_SESSION['profil']['admin'] == 0) {
        switch ($_POST['action']) {
            case 'formmenu':
                $menu = new menu;

                if (isset($_POST['id']) && $_POST['id'] != '' && $menu->verifiemenu((int)$_POST['id'])) {
                    $id = (int)$_POST['id'];
                    $dataMenu = $menu->menus($id);

                    include('../view/form_menu.php');
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $menu->verifiemenu((int)$_POST['id']) == false) {
                    echo 'false id';
                }else {
                    echo 'false';
                }
                break;
            
            case 'modmenu':
                $menu = new menu;

                if (isset($_POST['id'], $_POST['titre'], $_FILES['image']) && $_POST['id'] != '' && $_POST['titre'] != '' && $_FILES['image']['name'] != '' && $menu->verifiemenu((int)$_POST['id'])) {

                    echo json_encode($menu->addMenu($_POST['titre'], $_FILES['image'], $_POST['id']));
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifiemenu((int)$_POST['id']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du menu ne corespond pas avec la base de donner'
                    ));
                }elseif (isset($_POST['titre']) && $_POST['titre'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre n\'a pas été renseigner'
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

            case 'supmenu':
                $menu = new menu;

                if (isset($_POST['id']) && $_POST['id'] != '' && $menu->verifiemenu((int)$_POST['id'])) {

                    echo json_encode($menu->supMenu((int)$_POST['id']));
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifiemenu((int)$_POST['id']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du menu ne corespond pas avec la base de donner'
                    ));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    ));
                }
                break;

            case 'addmenu':
                if (isset($_POST['titre'], $_FILES['image']) && $_POST['titre'] != '' && $_FILES['image']['name'] != '') {
                    $menu = new menu;

                    echo json_encode($menu->addMenu($_POST['titre'], $_FILES['image']));
                }elseif (isset($_POST['titre']) && $_POST['titre'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre n\'a pas été renseigner'
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