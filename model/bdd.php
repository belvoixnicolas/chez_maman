<?php
    class bdd {
        private $_host = 'localhost';
        private $_bdname = "chez_maman";
        private $_user = 'root';
        private $_mdp = '';

        public function __construct() {
            try {
                $host = $this->_host;
                $bdname = $this->_bdname;
                $user = $this->_user;
                $mdp = $this->_mdp;

                $bdd = new PDO('mysql:host=' . $host . ';dbname=' . $bdname, $user, $mdp);

                return $bdd;
            } catch (PDOException $e) {
                error_log("La base de donner de chez maman ne fonctionne pas", 1, "belvoixnicolas1997@gmail.com");
                die();
            }
        }
    }
?>