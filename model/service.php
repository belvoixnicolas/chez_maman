<?php
    require_once('bdd.php');

    class service {
        private $_bdd;
        private $_services;

        public function __construct() {
            $this->_bdd = new bdd;

            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT id, titre, text, image FROM services ORDER BY titre');
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

        public function verifid ($id) {
            if ($id != 0 && is_int($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT id FROM services WHERE id = :id');
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
            }else {
                return false;
            }
        }

        public function service($id) {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('SELECT id, image, text FROM services WHERE id = :id');
            $req->execute(array(
                ':id' => $id
            ));

            if ($resultat = $req->fetch()) {
                return $resultat;
            }else {
                return false;
            }
        }

        /// setter ///
        public function modimg ($file, $id) {
            if (isset($file['name'], $file['type'], $file['tmp_name']) && is_array($file) && strlen($file['name']) <= 50 && $this->verifid($id)) {
                $upload = $this->uploadimg($file);

                if ($upload['result']) {
                    if ($service = $this->service($id)) {
                        if ($service['image'] != $file['name']) {
                            $bdd = $this->_bdd;
                            $bdd = $bdd->co();

                            $req = $bdd->prepare('UPDATE services SET image = :img WHERE id = :id');
                            $array = array(
                                ':img' => $file['name'],
                                ':id' => $id
                            );

                            if ($req->execute($array)) {
                                $req->closecursor();
                                $bdd = null;

                                unlink('src/services/' . $service['image']); 

                                return array(
                                    'result' => true,
                                    'text' => 'L\'image a été changée'
                                );
                            }else {
                                $req->closecursor();
                                $bdd = null;

                                unlink('src/services/' . $file['name']); 

                                return array(
                                    'result' => false,
                                    'text' => 'L\'image n\'a pas été changée dans la base de données'
                                );
                            }
                        }else {
                            return array(
                                'result' => true,
                                'text' => 'L\'image a été changée'
                            );
                        }
                    }else {
                        unlink('src/services/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'L\'id du service ne correspond pas avec la base de données'
                        );
                    }
                }else {
                    return $upload;
                }
            }elseif ($this->verifid($id) == false) {
                return array(
                    'result' => false,
                    'text' => 'L\'id du service ne correspond pas avec la base de données'
                );
            }elseif (strlen($file['name']) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom du fichier ne peut faire plus de 50 caractères. Il est actuellement de ' . strlen($file['name']) . ' caractères.'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        public function modtext($text, $id) {
            if (is_string($text) && $this->verifid($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('UPDATE services SET text = :txt WHERE id = :id');
                $array = array(
                    ':txt' => $text,
                    ':id' => $id
                );

                if ($req->execute($array)) {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => true,
                        'text' => 'Le text a été mis à jour',
                        'html' => nl2br(htmlspecialchars($text))
                    );
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => false,
                        'text' => 'Le text n\'a pas pu être mis à jour'
                    );
                }
            }elseif ($this->verifid($id) == false) {
                return array(
                    'result' => false,
                    'text' => 'L\'id du service ne correspond pas avec la base de données'
                );
            }elseif (is_string($text) == false) {
                return array(
                    'result' => false,
                    'text' => 'Seul du texte est autorisé'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        public function sup($id) {
            if ($this->verifid($id)) {
                $service = $this->service($id);
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('DELETE FROM services WHERE id = :id');
                $array = array(
                    ':id' => $id
                );

                if ($req->execute($array)) {
                    $req->closecursor();
                    $bdd = null;

                    unlink('src/services/' . $service['image']);

                    return array(
                        'result' => true,
                        'text' => 'Le service a été supprimé'
                    );
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => true,
                        'text' => 'Le service n\'a pas été supprimé'
                    );
                }
            }elseif ($this->verifid($id) == false) {
                return array(
                    'result' => false,
                    'text' => 'L\'id du service ne correspond pas avec la base de données'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        public function addservice($titre, $txt, $file) {
            if (isset($file['name'], $file['type'], $file['tmp_name']) && is_array($file) && is_string($titre) && is_string($txt) && strlen($file['name']) <= 50 && strlen($titre) <= 50) {
                $upload = $this->uploadimg($file);

                if ($upload['result']) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('INSERT INTO services (id, titre, text, image) VALUES (NULL, :titre, :txt, :img)');
                    $array = array(
                        ':titre' => $titre,
                        ':txt' => $txt,
                        ':img' => $file['name']
                    );

                    if ($req->execute($array)) {
                        $id = $bdd->lastInsertId();

                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Le service a été ajouté',
                            'html' => $this->htmlservice($id, $titre, $txt, $file['name'])
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        unlink('src/services/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'Le service n\'a pas été ajouté'
                        );
                    }
                }else {
                    return $upload;
                }
            }elseif (strlen($file['name']) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom du fichier ne peut faire plus de 50 caractères. Il est actuellement de ' . strlen($file['name']) . ' caractères.'
                );
            }elseif (strlen($titre) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom du titre ne peut faire plus de 50 caractères. Il est actuellement de ' . strlen($titre) . ' caractères.'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        private function uploadimg ($file) {
            if (isset($file['name'], $file['type'], $file['tmp_name']) && is_array($file)) {
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
                    if (move_uploaded_file($file['tmp_name'], 'src/services/' . $file['name'])) {
                        return array(
                            'result' => true,
                            'text' => 'L\'image a été envoyée'
                        );
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'L\'image n\'a pas pu être uploadée'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le fichier est dans un format inconnue. Les formats gif, jpeg, png et svg sont reconnus.',
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        private function htmlservice($id, $titre, $txt, $img) {
            $html = file_get_contents('../view/servicemodel.html');

            if ($html) {
                $html = str_replace("%id%", htmlspecialchars($id), $html);
                $html = str_replace("%titre%", htmlspecialchars($titre), $html);
                $html = str_replace("%text%", nl2br(htmlspecialchars($txt)), $html);
                $html = str_replace("%img%", htmlspecialchars($img), $html);

                return $html;
            }else {
                return false;
            }
        }
    }
?>