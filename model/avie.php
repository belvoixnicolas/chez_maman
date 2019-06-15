<?php
    require_once('bdd.php');

    class avie {
        private $_bdd;
        private $_avies;

        public function __construct() {
            $this->_bdd = new bdd;

            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT text FROM avie ORDER BY afficher DESC, date DESC LIMIT 5');
            $resultat = $req->fetchall();

            $req->closeCursor();
            $bdd = null;

            $this->_avies = $resultat;
        }

        /// getter ///
        public function avies() {
            $avies = $this->_avies;

            if (count($avies) != 0) {
                return $avies;
            }else {
                return false;
            }
        }
    }
?>