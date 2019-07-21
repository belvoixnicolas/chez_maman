<?php
    session_start();

    require_once('../model/entreprise.php');
    require_once('../model/menu.php');

    if (isset($_SESSION['profil']['admin'], $_POST['action']) && $_SESSION['profil']['admin'] == 1 || $_SESSION['profil']['admin'] == 0) {
        switch ($_POST['action']) {
            case 'formproduit':
                $menu = new menu;

                if (isset($_POST['id']) && $_POST['id'] != '' && $menu->verifProduit((int)$_POST['id'])) {
                    $produit = $menu->produit((int)$_POST['id']);

                    include('../view/form_produit.php');
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $menu->verifProduit((int)$_POST['id']) == false) {
                    echo 'false id';
                }else {
                    echo 'false';
                }
                break;

            case 'modproduit':
                $menu = new menu;

                if (isset($_POST['idproduit'], $_POST['idmenu'], $_POST['titre'], $_POST['text'], $_POST['prix'], $_FILES['image']) && $_POST['idmenu'] != '' && $_POST['idproduit'] != '' && $_POST['titre'] != '' && $menu->verifProduit((int)$_POST['idproduit']) && $menu->verifMenu((int)$_POST['idmenu'])) {

                    echo json_encode($menu->addProduit($_POST['titre'], $_POST['text'], $_POST['prix'], $_FILES['image'], $_POST['idmenu'], $_POST['idproduit']));
                }elseif (isset($_POST['idproduit']) && $_POST['idproduit'] != '' && $menu->verifProduit((int)$_POST['idproduit']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du produit ne corespond pas avec la base de donner'
                    ));
                }elseif (isset($_POST['idmenu']) && $_POST['idmenu'] != '' && $menu->verifMenu((int)$_POST['idmenu']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du menu ne corespond pas avec la base de donner'
                    ));
                }elseif (isset($_POST['titre']) && $_POST['titre'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre n\'a pas été renseigner'
                    ));
                }else {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    ));
                }
                break;

            case 'addproduit':
                $menu = new menu;

                if (isset($_POST['idmenu'], $_POST['titre'], $_POST['text'], $_POST['prix'], $_FILES['image']) && $_POST['idmenu'] != '' && $_POST['titre'] != '' && $_FILES['image']['size'] > 0 && $menu->verifMenu((int)$_POST['idmenu'])) {

                    echo json_encode($menu->addProduit($_POST['titre'], $_POST['text'], $_POST['prix'], $_FILES['image'], $_POST['idmenu']));
                }elseif (isset($_POST['idmenu']) && $_POST['idmenu'] != '' && $menu->verifMenu((int)$_POST['idmenu']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du menu ne corespond pas avec la base de donner'
                    ));
                }elseif (isset($_POST['titre']) && $_POST['titre'] == '') {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'Le titre n\'a pas été renseigner'
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

            case 'supproduit':
                $menu = new menu;

                if (isset($_POST['id']) && $_POST['id'] != '' && $menu->verifProduit((int)$_POST['id'])) {

                    echo json_encode($menu->supProduit((int)$_POST['id']));
                }elseif (isset($_POST['id']) && $_POST['id'] != '' && $service->verifProduit((int)$_POST['id']) == false) {
                    echo json_encode(array(
                        'result' => false,
                        'text' => 'L\'id du produit ne corespond pas avec la base de donner'
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