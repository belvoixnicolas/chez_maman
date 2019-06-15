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
    }
?>