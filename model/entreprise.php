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

        /// getter ///
        public function titre() {
            $titre = $this->_titre;

            if ($titre == null) {
                $titre = 'Titre';
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