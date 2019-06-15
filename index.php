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