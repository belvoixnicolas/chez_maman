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
        public function avies($limite = true) {
            if (is_bool($limite) && $limite == false) {
                $avies = $this->_avies;

                if (count($avies) != 0) {
                    return $avies;
                }else {
                    return false;
                }
            }else {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->query('SELECT id, text, afficher FROM avie ORDER BY afficher DESC, date DESC');

                if ($resultat = $req->fetchall()) {
                    $req->closecursor();
                    $bdd = null;
                    
                    return $resultat;
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return false;
                }
            }
        }

        public function compteurafficher() {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            if($req = $bdd->query('SELECT COUNT(*) AS nb FROM avie WHERE afficher = 1')) {
                if ($resultat = $req->fetch()) {
                    $req->closeCursor();
                    $bdd = null;

                    return $resultat['nb'];
                    //return false;
                }else {
                    $req->closeCursor();
                    $bdd = null;

                    return 0;
                }
            }else {
                return false;
            }
        }

        private function afficher($id) {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('SELECT afficher FROM avie WHERE id = :id');
            $req->execute(array(
                ':id' => $id
            ));

            if ($result = $req->fetch()) {
                $req->closecursor();
                $bdd = null;

                switch ($result['afficher']) {
                    case '0':
                        $result = false;
                        break;
                    
                    case '1':
                        $result = true;
                        break;
                    
                    default:
                        $result = false;
                        break;
                }

                return $result;
            }else {
                $req->closecursor();
                $bdd = null;

                return false;
            }
        }

        /// setter ///
        public function setAvie($text) {
            if (is_string($text) && isset($text) && $text != '') {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare("INSERT INTO `avie` (`id`, `text`) VALUES (NULL, :text)");
                $variables = array(
                    ':text' => $text
                );

                if ($req->execute($variables)) {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => true,
                        'text' => 'Le commentaire a été envoyé'
                    );
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le commentaire n\'a pas été envoyé'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        public function setafficher($id) {
            if (is_int($id) && $id > 0 && is_bool($this->compteurafficher()) == false && $this->compteurafficher() >= 0) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('UPDATE avie SET afficher = :aff WHERE id = :id');

                if ($this->afficher($id)) {
                    $array = array(
                        ':aff' => 0,
                        ':id' => $id
                    );
                }else {
                    if ($this->compteurafficher() >= 5) {
                        $array = false;
                    }else {
                        $array = array(
                            ':aff' => 1,
                            ':id' => $id
                        );
                    }
                }

                if ($array && $req->execute($array)) {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => true,
                        'text' => 'Avis modifier',
                        'afficher' => $this->afficher($id),
                        'compteur' => $this->compteurafficher()
                    );
                }elseif ($array == false) {
                    return array(
                        'result' => false,
                        'text' => 'Il y a déja cinq avis affichés'
                    );
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => false,
                        'text' => 'Erreur favori'
                    );
                }
            }elseif ($this->compteurafficher() && $this->compteurafficher() >= 5) {
                return array(
                    'result' => false,
                    'text' => 'Il y a déja cinq avis affiché'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        public function supafficher($id) {
            if (is_int($id) && $id > 0) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('DELETE FROM avie WHERE id = :id');
                $array = array(
                    ':id' => $id
                );

                if ($req->execute($array)) {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => true,
                        'text' => 'L\'avis a été supprimé',
                        'compteur' => $this->compteurafficher()
                    );
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => false,
                        'text' => 'L\'avis n\'a pas pu être supprimé'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }
    }
?>