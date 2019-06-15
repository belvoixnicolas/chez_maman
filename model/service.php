<?php
    require_once('bdd.php');

    class service {
        private $_bdd;
        private $_services;

        public function __construct() {
            $this->_bdd = new bdd;

            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT titre, text, image FROM services ORDER BY ordre');
            $resultat = $req->fetchall();

            $req->closeCursor();
            $bdd = null;

            $this->_services = $resultat;
        }

        /// getter ///
        public function services() {
            $services = $this->_services;

            if (count($services) != 0) {
                foreach ($services as $key => $value) {
                    if (file_exists('../controller/src/services/' . $value['image']) != true) {
                        $value['image'] = 'default.svg';
                        $services[$key] = $value;
                    }
                }

                return $services;
            }else {
                return false;
            }
        }
    }
?>