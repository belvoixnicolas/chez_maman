<?php
    class bdd {
        private $_host;
        private $_dbname;
        private $_user;
        private $_mdp;

        public function __construct() {
            $this->_host = 'localhost';
            $this->_dbname = 'chez_mama';
            $this->_user = 'root';
            $this->_mdp = "";
        }

        public function co() {
            $host = $this->_host;
            $dbname = $this->_dbname;
            $user = $this->_user;
            $mdp = $this->_mdp;

            try{
                $bdd = new PDO("mysql:host=$host;dbname=$dbname",$user,$mdp,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                return $bdd;
            }catch (Exception $e) {
                error_log("La base de donner de chez maman ne fonctionne pas", 1, "belvoixnicolas1997@gmail.com");
                return false;
            }
        }
    }
?>