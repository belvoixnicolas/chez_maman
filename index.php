<?php
    session_start();
    
    if (isset($_GET['page'])) {
        $page = $_GET['page'];

        switch ($page) {
            case 'index':
                header('Location: controller/acceuil.php');
                exit();
                break;

            case 'menu':
                header('Location: controller/menu.php');
                exit();
                break;

            case 'connexion':
                header('Location: controller/connexion.php');
                exit();
                break;

            case 'modmdp':
                header('Location: controller/modmdp.php');
                break;

            case 'admin':
                header('location: controller/admin.php');
                exit();
                break;

            case 'gestion':
                if (isset($_GET['precis']) && $_GET['precis'] == 'entreprise') {
                    header('Location: controller/gestion.php?precis=entreprise');
                    exit();
                }elseif (isset($_GET['precis']) && $_GET['precis'] == 'perso') {
                    header('Location: controller/gestion.php?precis=perso');
                    exit();
                }else {
                    header('Location: controller/gestion.php');
                    exit();
                }
                break;

            case 'description':
                header('location: controller/description.php');
                exit();
                break;

            case 'avie':
                header('location: controller/avie.php');
                exit();
                break;

            case 'service':
                header('location: controller/service.php');
                exit();
                break;

            case 'menugestion':
                if (isset($_GET['menu'])) {
                    header('location: controller/menugestion.php?menu=' . $_GET['menu']);
                    exit();
                }else {
                    header('location: controller/menugestion.php');
                    exit();
                }
                break;

            case 'horraire':
                header('location: controller/horraire.php');
                exit;
                break;
            
            default:
                header('Location: controller/acceuil.php');
                exit();
                break;
        }
    } else {
        header('Location: controller/acceuil.php');
        exit();
    }
    
?>