<?php
    require_once('bdd.php');

    class sectionMenu {
        private $_bdd;
        private $_menu;

        public function __construct () {
            $this->_bdd = new bdd;

            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT titre, image, id FROM menu ORDER BY ordre');

            if ($result = $req->fetchall()) {
                $this->_menu = $result;
            }else {
                $this->_menu = false;
            }

            $req->closeCursor();
            $bdd = null;
        }

        /// geter ///
        public function menus () {
            if ($this->_menu) {
                foreach ($this->_menu as $key => $value) {
                    $img = $value['image'];

                    if (file_exists('src/menu/' . $img) == false) {
                        $value['image'] = 'default.svg';

                        $this->_menu[$key] = $value;
                    }else {
                        $this->_menu[$key] = $value;
                    }
                }

                return $this->_menu;
            }else {
                return false;
            }
        }

        public function produit ($id) {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('SELECT titre, text, image, prix FROM produit WHERE id_menu = :id ORDER BY titre');
            $req->execute(array(
                ':id' => $id
            ));

            if ($resu = $req->fetchall()) {
                $req->closeCursor();
                $bdd = null;

                foreach ($resu as $key => $value) {
                    if (file_exists('src/produit/' . $value['image']) == false) {
                        $value['image'] = 'defaul.svg';
                        $resu[$key] = $value;
                    }
                }

                return $resu;
            }else {
                $req->closeCursor();
                $bdd = null;
                return false;
            }
        }
    }
?>