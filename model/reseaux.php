<?php
    require_once('bdd.php');

    class reseaux {
        private $_bdd;
        private $_reseaux;

        public function __construct() {
            $bdd = new bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT titre, image, url FROM reseau WHERE url IS NOT NULL ORDER BY titre');

            if ($resultat = $req->fetchall()) {
                $req->closeCursor();
                $bdd = null;

                $this->_reseaux = $resultat;
            }else {
                $req->closeCursor();
                $bdd = null;
                
                $this->_reseaux = false;
            }
        }

        /// getter ///
        public function reseaux() {
            $reseau = $this->_reseaux;

            if ($reseau) {
                foreach ($reseau as $key => $value) {
                    if (file_exists('src/reseaux/' . $value['image']) == false) {
                        $value['image'] = 'default.svg';

                        $reseau[$key] = $value;
                    }
                }

                return $reseau;
            }else {
                return false;
            }
        }
    }
?>