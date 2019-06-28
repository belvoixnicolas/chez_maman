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