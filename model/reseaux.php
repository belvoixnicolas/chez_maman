<?php
    require_once('bdd.php');

    class reseaux {
        private $_bdd;
        private $_reseaux;
        private $_model;

        public function __construct() {
            $bdd = new bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT titre, image, url FROM reseau WHERE url IS NOT NULL');

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
        public function reseaux($id=null) {
            if (is_null($id)) {
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
            }else {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT * FROM reseau WHERE id = :id');
                $req->execute(array(
                    ':id' => $id
                ));  

                if ($result = $req->fetch()) {
                    $req->closecursor();
                    $bdd = null;

                    return $result;
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return false;
                }
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

        private function reseauHtml ($id) {
            if ($this->verifId($id) && $reseau = $this->reseaux($id)) {
                error_reporting(0);
                if ($this->_model) {
                    $model = $this->_model;
    
                    $model = str_replace('%id%', htmlspecialchars($reseau['id']), $model);
                    $model = str_replace('%titre%', htmlspecialchars($reseau['titre']), $model);
                    $model = str_replace('%url%', htmlspecialchars($reseau['url']), $model);

                    if (is_null($reseau['url']) || fopen($reseau['url'], 'r') == false) {
                        $model = str_replace('%class%', 'class="erreur"', $model);
                    }else {
                        $model = str_replace('%class%', '', $model);
                    }
                    
                    if (is_null($reseau['url'])) {
                        $model = str_replace('%txt%', '(Aucun lien)', $model);
                    }elseif (fopen($reseau['url'], 'r') == false) {
                        $model = str_replace('%txt%', '(Lien mort)', $model);
                    }else {
                        $model = str_replace('%txt%', '', $model);
                    }
    
                    if (file_exists('src/reseaux/' . $reseau['image'])) {
                        $model = str_replace('%img%', htmlspecialchars($reseau['image']), $model);
                    }else {
                        $model = str_replace('%img%', 'default.svg', $model);
                    }
    
                    return $model;
                }else {
                    return false;
                }
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
                            'html' => $this->reseauHtml($lastId)
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

        public function modReseau ($id, $titre, $url, $file) {
            error_reporting(0);
            if ($this->verifId($id) && $titre != '' && strlen($titre) <= 50 && $url != '' && fopen($url, 'r') && is_array($file)) {
                if ($file['size'] > 0) {
                    $ifImg = true;

                    $upload = $this->uploadimg($file);
                    if ($upload['result'] == false) {
                        return $upload;
                    }
                }else {
                    $ifImg = false;
                }

                $bdd = $this->_bdd;
                $bdd = $bdd->co();
                if ($ifImg) {
                    $req = $bdd->prepare('UPDATE reseau SET titre = :titre, image = :img, url = :url WHERE id = :id');
                    $array = array(
                        ':titre' => $titre,
                        ':img' => $file['name'],
                        ':url' => $url,
                        ':id' => $id
                    );

                    $oldImg = $this->reseaux($id)['image'];
                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        if ($oldImg && $oldImg != $file['name'] && $oldImg != 'default.svg') {
                            unlink('src/reseaux/' . $oldImg);
                        }

                        return array(
                            'result' => true,
                            'text' => 'Le reseau a été mis a jour',
                            'html' => $this->reseauHtml($id),
                            'id' => $id
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        if ($file['name'] != 'default.svg') {
                            unlink('src/reseaux/' . $file['name']);
                        }

                        return array(
                            'result' => false,
                            'text' => 'Une erreur c\'est produit lors de la mise a jour du reseaux'
                        );
                    }
                }else {
                    $req = $bdd->prepare('UPDATE reseau SET titre = :titre, url = :url WHERE id = :id');
                    $array = array(
                        ':titre' => $titre,
                        ':url' => $url,
                        ':id' => $id
                    );

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Le reseau a été mis a jour',
                            'html' => $this->reseauHtml($id),
                            'id' => $id
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Une erreur c\'est produit lors de la mise a jour du reseaux'
                        );
                    }
                }
            }elseif ($this->verifId($id) != true) {
                return array(
                    'result' => false,
                    'text' => 'Le reseau n\'a pas été trouver dans la base de donner'
                );
            }elseif ($titre == '' || strlen($titre) > 50) {
                if ($titre == '') {
                    return array(
                        'result' => false,
                        'text' => 'Le titre est vide'
                    );
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le titre ne peux faire plus de 50 caractéres'
                    );
                }
            }elseif ($url == '') {
                return array(
                    'result' => false,
                    'text' => 'L\'url est vide'
                );
            }elseif (fopen($url, 'r') == false) {
                return array(
                    'result' => false,
                    'text' => 'L\'url est un lien mort'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        public function supReseau ($id) {
            if ($this->verifId($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('DELETE FROM reseau WHERE id = :id');
                $array = array(
                    ':id' => $id
                );

                $img = $this->reseaux($id);
                if ($img) {
                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        if ($img['image'] != 'default.svg' && file_exists('src/reseaux/' . $img['image'])) {
                            unlink('src/reseaux/' . $img['image']);
                        }

                        return array(
                            'result' => true,
                            'text' => 'Le reseau a été suprimer'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le reseau n\'a pas put étre suprimer'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Une erreur c\'est produit'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Le reseaux n\'a pas été trouver dans la base de donner'
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