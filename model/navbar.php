<?php 
    class navbar {
        private $_fichier;

        public function __construct() {
            $lien = explode("/", $_SERVER['PHP_SELF']);
            $this->_fichier = $lien[count($lien) - 1];
        }

        public function lien () {
            $lien = "";
            $page = $this->_fichier;

            switch ($page) {
                case 'acceuil.php':
                    $lien = "<a href=\"../index.php?page=menu\">menu</a>";
                    break;
        
                case 'menu.php':
                    $lien = "<a href=\"../index.php?page=index\">aceuil</a>";
                    break;
                
                default:
                    # code...
                    break;
            }
            
            return $lien;
        }
    }
?>