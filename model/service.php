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
                                    'text' => 'L\'image a été changer'
                                );
                            }else {
                                $req->closecursor();
                                $bdd = null;

                                unlink('src/services/' . $file['name']); 

                                return array(
                                    'result' => false,
                                    'text' => 'L\'image n\'a pas été changer dans la base de donner'
                                );
                            }
                        }else {
                            return array(
                                'result' => true,
                                'text' => 'L\'image a été changer'
                            );
                        }
                    }else {
                        unlink('src/services/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'L\'id du service ne corespond pas avec la base de donner'
                        );
                    }
                }else {
                    return $upload;
                }
            }elseif ($this->verifid($id) == false) {
                return array(
                    'result' => false,
                    'text' => 'L\'id du service ne corespond pas avec la base de donner'
                );
            }elseif (strlen($file['name']) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom du fichier ne peux faire plus de 50 caractéres. Il est actuellement de ' . strlen($file['name'])
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
                        'text' => 'Le text a été mis a jour'
                    );
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => false,
                        'text' => 'Le text n\'a pas put étre mis a jour'
                    );
                }
            }elseif ($this->verifid($id) == false) {
                return array(
                    'result' => false,
                    'text' => 'L\'id du service ne corespond pas avec la base de donner'
                );
            }elseif (is_string($text) == false) {
                return array(
                    'result' => false,
                    'text' => 'Seul du text est autoriser'
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
                        'text' => 'Le service a été suprimer'
                    );
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return array(
                        'result' => true,
                        'text' => 'Le service n\'a pas été suprimer'
                    );
                }
            }elseif ($this->verifid($id) == false) {
                return array(
                    'result' => false,
                    'text' => 'L\'id du service ne corespond pas avec la base de donner'
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
                            'text' => 'Le service a été ajouter',
                            'html' => $this->htmlservice($id, $titre, $txt, $file['name'])
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        unlink('src/services/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'Le service n\'a pas été ajouter'
                        );
                    }
                }else {
                    return $upload;
                }
            }elseif (strlen($file['name']) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom du fichier ne peux faire plus de 50 caractéres. Il est actuellement de ' . strlen($file['name'])
                );
            }elseif (strlen($titre) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom du titre ne peux faire plus de 50 caractéres. Il est actuellement de ' . strlen($titre)
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
                $html = str_replace("%id%", $id, $html);
                $html = str_replace("%titre%", $titre, $html);
                $html = str_replace("%text%", $txt, $html);
                $html = str_replace("%img%", $img, $html);

                return $html;
            }else {
                return false;
            }
        }
    }
?>