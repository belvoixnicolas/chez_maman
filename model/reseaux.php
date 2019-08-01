<?php
    require_once('bdd.php');

    class reseaux {
        private $_bdd;
        private $_reseaux;
        private $_model;

        public function __construct() {
            $bdd = new bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT titre, image, url FROM reseau WHERE url IS NOT NULL ORDER BY titre LIMIT 2');

            if ($resultat = $req->fetchall()) {
                $req->closeCursor();
                $bdd = null;

                $this->_reseaux = $resultat;
            }else {
                $req->closeCursor();
                $bdd = null;
                
                $this->_reseaux = false;
            }

            $this->_bdd = new bdd;
            $this->_model = implode(file('../view/reseaumodel.html'));
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

        public function reseauxGestion () {
            $bdd = new bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT id, titre, image, url FROM reseau');

            if ($resultat = $req->fetchall()) {
                $req->closeCursor();
                $bdd = null;

                foreach ($resultat as $key => $value) {
                    if (file_exists('src/reseaux/' . $value['image']) == false) {
                        $resultat[$key]['image'] = 'default.svg';
                    }
                }

                return $resultat;
            }else {
                $req->closeCursor();
                $bdd = null;
                
                return false;
            }
        }

        public function formHtml ($id) {
            if ($this->verifId($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT * FROM reseau WHERE id = :id');
                $req->execute(array(
                    ':id' => $id
                ));

                if ($resultat = $req->fetch()) {
                    $req->closecursor();
                    $bdd = null;

                    return $resultat;
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return false;
                }
            }else {
                return false;
            }
        }

        private function reseauHtml ($id, $titre, $url, $img) {
            if ($this->_model) {
                $model = $this->_model;

                $model = str_replace('%id%', $id, $model);
                $model = str_replace('%titre%', $titre, $model);
                $model = str_replace('%url%', $url, $model);
                $model = str_replace('%class%', '', $model);
                $model = str_replace('%txt%', '', $model);

                if (file_exists('src/reseaux/' . $img)) {
                    $model = str_replace('%img%', $img, $model);
                }else {
                    $model = str_replace('%img%', 'default.svg', $model);
                }

                return $model;
            }else {
                return false;
            }
        }

        private function verifId ($id) {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('SELECT * FROM reseau WHERE id = :id');
            $req->execute(array(
                ':id' => $id
            ));

            if ($req->fetch()) {
                $req->closecursor();
                $bdd = null;

                return true;
            }else {
                $req->closecursor();
                $bdd = null;

                return false;
            }
        }

        /// SETTER ///
        public function addReseau ($file, $titre, $url) {
            error_reporting(0);
            if (is_array($file) && strlen($file['name']) <= 50 && $titre != '' && strlen($titre) <= 50 && fopen($url, 'r')) {
                $upload = $this->uploadimg($file);
                $upload = true;

                if ($upload) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('INSERT INTO reseau (id, titre, image, url) VALUES (NULL, :titre, :img, :url)');
                    $array = array(
                        ':titre' => $titre,
                        ':img' => $file['name'],
                        ':url' => $url
                    );

                    if ($req->execute($array)) {
                        $lastId = $bdd->lastInsertId();

                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Lien ajouter',
                            'html' => $this->reseauHtml($lastId, $titre, $url, $file['name'])
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        unlink('src/reseaux/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'Le lien n\'a pas été ajouter'
                        );
                    }
                }else {
                    return $upload;
                }
            }elseif (is_array($file) == false) {
                return array(
                    'result' => false,
                    'text' => 'Il manque l\'image'
                );
            }elseif (strlen($file['name']) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom du fichier ne peux faire plus de 50 caractéres.'
                );
            }elseif (strlen($titre) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le titre ne peux faire plus de 50 caractéres.'
                );
            }elseif ($titre == '') {
                return array(
                    'result' => false,
                    'text' => 'Le titre est vide'
                );
            }elseif (fopen($url, 'r') == false) {
                return array(
                    'result' => false,
                    'text' => 'Le lien est mort'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        private function uploadimg ($file) {
            if (isset($file['name'], $file['type'], $file['tmp_name']) && is_array($file) && $file['name'] != '' && $file['type'] != '' && $file['tmp_name'] != '' && $file['size'] > 0) {
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
                    if (move_uploaded_file($file['tmp_name'], 'src/reseaux/' . $file['name'])) {
                        return array(
                            'result' => true,
                            'text' => 'L\'image a était envoyer'
                        );
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'L\'image n\'a pas put étre uploader'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le fichier est dans un format inconue. Le format gif, jpeg, png et svg sont reconnue.',
                    );
                }
            }elseif ($file['name'] == '') {
                return array(
                    'result' => false,
                    'text' => 'Le nom du fichier n\'est pas renseigner'
                );
            }elseif ($file['type']) {
                return array(
                    'result' => false,
                    'text' => 'Le type du fichier n\'est pas renseigner'
                );
            }elseif ($file['tmp_name']) {
                return array(
                    'result' => false,
                    'text' => 'Le chemin du fichier n\'est pas renseigner'
                );
            }elseif ($file['size'] == '' || $file['size'] == 0) {
                return array(
                    'result' => false,
                    'text' => 'La taille du fichier n\'est pas renseigner'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }
    }
?>