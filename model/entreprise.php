<?php
    require_once('bdd.php');

    class entreprise {
        private $_bdd;
        private $_titre;
        private $_logo;
        private $_video;
        private $_phrase;
        private $_description;
        private $_telephone;
        private $_numeroDeRue;
        private $_rue;
        private $_ville;
        private $_cp;

        public function __construct() {
            $this->_bdd = new bdd;

            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT * FROM entreprise WHERE id = 1');
            $resultat = $req->fetch();
            
            $req->closeCursor();
            $bdd = null;

            $this->_titre = $resultat['titre'];
            $this->_logo = $resultat['logo'];
            $this->_video = $resultat['video'];
            $this->_phrase = $resultat['phrase'];
            $this->_description = $resultat['description'];
            $this->_telephone = $resultat['telephone'];
            $this->_numeroDeRue = $resultat['numeroRue'];
            $this->_rue = $resultat['rue'];
            $this->_ville = $resultat['ville'];
            $this->_cp = $resultat['cp'];
        }

        /// setter ///
        public function setterlogo($file) {
            if (is_array($file) && isset($file['name'], $file['type'], $file['tmp_name'])) {
                switch ($file['type']) {
                    case 'image/gif':
                    case 'image/jpeg':
                    case 'image/png':
                    case 'image/svg+xml':

                        $type = true;
                        break;
                    
                    default:
                        $type = false;
                        break;
                }

                if ($type) {
                    if (move_uploaded_file($file['tmp_name'], 'src/logo/' . $file['name'])) {
                        $logo = $this->logo();
                        $bdd = $this->_bdd;
                        $bdd = $bdd->co();

                        $req = $bdd->prepare('UPDATE entreprise SET logo = :logo WHERE id = 1');

                        if ($logo) {
                            $array = array(
                                ':logo' => $file['name']
                            );

                            if ($req->execute($array)) {
                                $req->closecursor();
                                $bdd = null;

                                unlink('src/logo/' . $logo);
                                $this->_logo = $file['name'];

                                return array(
                                    'result' => true,
                                    'text' => 'Le logo a bien étais mis a jour',
                                    'img' => $file['name']
                                );
                            }else {
                                $req->closecursor();
                                $bdd = null;

                                unlink('src/logo/' . $file['name']);

                                return array(
                                    'result' => false,
                                    'text' => 'La base de donner n\'a pas put étre mis a jour'
                                );
                            }
                        }else {
                            $array = array(
                                ':logo' => $file['name']
                            );

                            if ($req->execute($array)) {
                                $req->closecursor();
                                $bdd = null;

                                $this->_logo = $file['name'];

                                return array(
                                    'result' => true,
                                    'text' => 'Le logo a bien étais mis a jour',
                                    'img' => $file['name']
                                );
                            }else {
                                $req->closecursor();
                                $bdd = null;

                                unlink('src/logo/' . $file['name']);

                                return array(
                                    'result' => false,
                                    'text' => 'La base de donner n\'a pas put étre mis a jour'
                                );
                            }
                        }
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'Le fichier n\'a pas étais envoyer au serveur'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Seul les .gif, .jpeg, .png et .svg sont autoriser'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Vous n\'avais pas envoyer de fichier'
                );
            }
        }

        public function settertitre($titre) {
            if (is_string($titre) && $titre != '' && strlen($titre) <= 50) {
                $oldtitre = $this->titre();

                if ($oldtitre != $titre) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('UPDATE entreprise SET titre = :titre WHERE id = 1');
                    $array = array(
                        ':titre' => $titre
                    );

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        $this->_titre = $titre;

                        return array(
                            'result' => true,
                            'text' => 'Le titre a étais mis à jour'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le titre n\'a pas put étre mis à jour'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Ce titre est déja utiliser'
                    );
                }
            }elseif (strlen($titre) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le titre doit faire moin de 50 caractére. Il est actuellement de ' . strlen($titre)
                );
            }elseif ($titre == '') {
                return array(
                    'result' => false,
                    'text' => 'Vous avez envoyer du text vide'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Une erreur c\'est produit'
                );
            }
        }

        public function setterphrase($phrase) {
            if (is_string($phrase)) {
                if (strlen($phrase) <= 50) {
                    $oldphrase = $this->phrase();

                    if ($oldphrase != $phrase) {
                        $bdd = $this->_bdd;
                        $bdd = $bdd->co();

                        $req = $bdd->prepare('UPDATE entreprise SET phrase = :phrase WHERE id = 1');

                        if ($phrase == '') {
                            $array = array(
                                ':phrase' => null
                            );
                        }else {
                            $array = array(
                                ':phrase' => $phrase
                            );
                        }

                        if ($req->execute($array)) {
                            $req->closecursor();
                            $bdd = null;

                            if ($phrase == '') {
                                $this->_phrase = null;
                            }else {
                                $this->_phrase = $phrase;
                            }

                            return array(
                                'result' => true,
                                'text' => 'Le slogan a bien étais modifier'
                            );
                        }else {
                            $req->closecursor();
                            $bdd = null;

                            return array(
                                'result' => false,
                                'text' => 'Ce slogan n\'a pas put étre envoier a la base de donner'
                            );
                        }
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'Ce slogan est déja utiliser'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le titre ne peux faire 50 caractére maximum. Il est actuellement de ' . strlen($phrase)
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Seul le text est autoriser'
                );
            }
        }

        public function setternumero($tel) {
            if (is_int($tel) && $tel != 0 && strlen($tel) == 9 || $tel == '') {
                $tel = 0 . $tel;
                $oldtel = $this->numero();
                
                if ($oldtel == false) {
                    $oldtel = '00';
                }

                if ($tel != $oldtel) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('UPDATE entreprise SET telephone = :tel WHERE id = 1');

                    if ($tel == 00) {
                        $array = array(
                            ':tel' => null
                        );
                    }else {
                        $array = array(
                            ':tel' => substr($tel, 1)
                        );
                    }

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        $this->_telephone = $array[':tel'];

                        return array(
                            'result' => true,
                            'text' => 'Le nouveau numero a bien étais mis a jour'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le nouveau numero n\'a pas put étre envoyer a la base de donner'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le numero est déja utiliser'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Seul les numero de teléphone sont autoriser'
                );
            }
        }

        public function setteraddress($nbrue, $rue, $ville, $cp) {
            if ($nbrue != '' && $rue != '' && $ville != '' && $cp != '') {
                if (is_int($nbrue) && is_int($cp)) {
                    if (strlen($nbrue) <= 11 && strlen($rue) <= 50 && strlen($ville) <= 50 && strlen($cp) <= 5) {
                        if (strlen($cp) == 5) {
                            $cp = $cp;
                        }elseif (strlen($cp) == 4) {
                            $num = substr($cp, 0, 1);

                            if ($num != 0) {
                                $cp = 0 . $cp;
                            }else {
                                $cp = false;
                            }
                        }else {
                            $cp = false;
                        }

                        if ($cp) {
                            $bdd = $this->_bdd;
                            $bdd = $bdd->co();

                            $req = $bdd->prepare('UPDATE entreprise SET numeroRue = :num, rue = :rue, ville = :ville, cp = :cp WHERE id = 1');

                            $array = array(
                                ':num' => $nbrue,
                                ':rue' => $rue,
                                ':ville' => $ville,
                                ':cp' => $cp
                            );

                            if ($req->execute($array)) {
                                $req->closecursor();
                                $bdd = null;

                                return array(
                                    'result' => true,
                                    'text' => 'L\'addresse à étais mis a jour'
                                );
                            }else {
                                $req->closecursor();
                                $bdd = null;

                                return array(
                                    'result' => false,
                                    'text' => 'La nouvelle addresse n\'a pas put étre mis a jour'
                                );
                            }
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Vous n\'avais pas idiquer le code postale'
                            );
                        }
                    }elseif (strlen($nbrue) > 11) {
                        return array(
                            'result' => false,
                            'text' => 'Le numero de rue ne peux jusqu\'a 99999999999'
                        );
                    }elseif (strlen($rue) > 50) {
                        return array(
                            'result' => false,
                            'text' => 'Le nom de rue ne peux contenir plus de 50 caractéres. Elle est actuellement de ' . strlen($rue) . ' caractéres'
                        );
                    }elseif (strlen($ville) > 50) {
                        return array(
                            'result' => false,
                            'text' => 'La ville ne peux contenir plus de 50 caractéres. Elle est actuellement de ' . strlen($ville) . ' caractéres'
                        );
                    }elseif (strlen($cp) > 5) {
                        return array(
                            'result' => false,
                            'text' => 'Vous n\'avez pas indiquer le code postale'
                        );
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'erreur'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le numero de rue et le code postale doit étre un nombre'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Il manque une ou plusieur information'
                );
            }
        }

        public function supadresse() {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('UPDATE entreprise SET numeroRue = :num, rue = :rue, ville = :ville, cp = :cp WHERE id = 1');
            $array = array(
                ':num' => null,
                ':rue' => null,
                ':ville' => null,
                ':cp' => null
            );

            if ($req->execute($array)) {
                $req->closecursor();
                $bdd = null;

                return array(
                    'result' => true,
                    'text' => 'L\'addresse à étais suprimer'
                );
            }else {
                $req->closecursor();
                $bdd = null;

                return array(
                    'result' => false,
                    'text' => 'L\'addresse n\'a pas étais suprimer'
                );
            }
        }

        public function setterdescription($description) {
            if (is_string($description)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('UPDATE entreprise SET description = :descript WHERE id = 1');
                $array = array(
                    ':descript' => $description
                );

                if ($req->execute($array)) {
                    $req->closecursor();
                    $bdd = null;

                    $this->_description = $description;

                    return array(
                        'result' => true,
                        'text' => 'La description a étais mis a jour'
                    );
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => false,
                        'text' => 'La description n\'a pas put étre mis a jour'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Seul du texte peut étre envoyer'
                );
            }
        }

        public function supdescription() {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('UPDATE entreprise SET description = NULL WHERE id = 1');

            if ($req) {
                $req->closecursor();
                $bdd = null;

                $this->_description = null;

                return array(
                    'result' => true,
                    'text' => 'La description a étais suprimer'
                );
            }else {
                $req->closecursor();
                $bdd = null;

                return array(
                    'result' => true,
                    'text' => 'La description n\'a pas étais suprimer'
                );
            }
        }

        /// getter ///
        public function titre() {
            $titre = $this->_titre;

            if ($titre == null) {
                $titre = 'titre';
            }

            return $titre;
        }

        public function logo() {
            $logo = $this->_logo;

            if ($logo == null) {
                return false;
            }elseif (file_exists('src/logo/' . $logo)) {
                return $logo;
            }else {
                return false;
            }
        }

        public function phrase() {
            $phrase = $this->_phrase;

            if ($phrase == null) {
                return false;
            }else {
                return $phrase;
            }
        }

        public function video () {
            $video = $this->_video;

            if ($video == null) {
                $videos = array(
                    'webm' => 'default.webm',
                    'ogg' => 'default.ogg',
                    'mp4' => 'default.mp4'
                );
            }else {
                $extension = array ('webm', 'ogg', 'mp4');
                $videos = array();

                foreach ($extension as $value) {
                    if (file_exists('src/video/' . $video . '.' . $value)) {
                        $videos[$value] = $video . '.' . $value;
                    }else {
                        $videos[$value] = 'default.' . $value;
                    }
                }
            }

            return $videos;
        }

        public function description() {
            $description = $this->_description;

            if ($description == null) {
                return false;
            } else {
                return $description;
            }
        }

        public function address() {
            $numero = $this->_numeroDeRue;
            $rue = $this->_rue;
            $ville = $this->_ville;
            $cp = $this->_cp;

            if ($numero != null && $rue != null && $ville != null && $cp != null) {
                $array = array(
                    'numero' => $numero,
                    'rue' => $rue,
                    'ville' => $ville,
                    'cp' => $cp
                );

                return $array;
            }else {
                return false;
            }
        }

        public function numero() {
            $numero = $this->_telephone;

            if ($numero != null) {
                return '0' . $numero;
            }else {
                return false;
            }
        }
    }
?>