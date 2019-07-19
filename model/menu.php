<?php
    require_once('bdd.php');

    class menu {
        private $_bdd;
        private $_menu;
        private $_modelMenuHtmlGestion;

        public function __construct () {
            $this->_bdd = new bdd;

            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->query('SELECT titre, image, id FROM menu ORDER BY titre');

            if ($result = $req->fetchall()) {
                $this->_menu = $result;
            }else {
                $this->_menu = false;
            }

            $html = file_get_contents('../view/menumodelgestion.html');

            if ($html) {
                $this->_modelMenuHtmlGestion = $html;
            }else {
                $this->_modelMenuHtmlGestion = false;
            }

            $req->closeCursor();
            $bdd = null;
        }

        /// geter ///
        public function menus ($id=null) {
            if ($this->_menu && is_null($id)) {
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
            }elseif (is_null($id) != true && $id != 0 && is_int($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT id, titre, image FROM menu WHERE id = :id');
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
            }else {
                return false;
            }
        }

        public function menugestionhtml($id=null) {
            if (is_null($id)) {
                $menusArray = $this->menus();
                $modelHtml = $this->_modelMenuHtmlGestion;

                if ($menusArray && $modelHtml) {
                    $html = '';

                    foreach ($menusArray as $value) {
                        $construct = $modelHtml;
                        $construct = str_replace('%id%', $value['id'], $construct);
                        $construct = str_replace('%img%', $value['image'], $construct);
                        $construct = str_replace('%titre%', $value['titre'], $construct);

                        $html .= $construct;
                    }

                    return $html;
                }else {
                    return false;
                }
            }elseif (is_null($id) != true && $menu = $this->menus((int)$id)) {
                $html = $this->_modelMenuHtmlGestion;

                if ($html) {
                    $html = str_replace('%id%', $menu['id'], $html);
                    $html = str_replace('%img%', $menu['image'], $html);
                    $html = str_replace('%titre%', $menu['titre'], $html);

                    return $html;
                }else {
                    return false;
                }
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

        public function verifiemenu ($id) {
            if ($id != 0 && is_int($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT id FROM menu WHERE id = :id');
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

        /// SETTER ///
        public function addMenu($titre, $file, $id=null) {
            if (isset($file['name'], $file['type'], $file['tmp_name']) && is_array($file) && is_string($titre) && strlen($file['name']) <= 50 && strlen($titre) <= 50) {
                $upload = $this->uploadimg($file);

                if ($upload['result']) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();
                    
                    if (is_null($id) == false && $this->verifiemenu((int)$id)) {
                        $req = $bdd->prepare('UPDATE menu SET titre = :titre, image = :img WHERE id = :id');
                        $array = array(
                            ':titre' => $titre,
                            ':img' => $file['name'],
                            ':id' => $id
                        );
                        $oldMenu = $this->menus((int)$id);
                    }elseif (is_null($id)) {
                        $req = $bdd->prepare('INSERT INTO menu (id, titre, image) VALUES (NULL, :titre, :img)');
                        $array = array(
                            ':titre' => $titre,
                            ':img' => $file['name']
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        unlink('src/menu/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'Une erreur est survenue'
                        );
                    }

                    if ($req->execute($array)) {
                        $lastId = $bdd->lastInsertId();

                        $req->closecursor();
                        $bdd = null;

                        if (isset($oldMenu)) {
                            if ($oldMenu['image'] != $file['name']) {
                                unlink('src/menu/' . $oldMenu['image']);
                            }

                            return array(
                                'result' => true,
                                'text' => 'Le menu a été mis a jour',
                                'data' => $this->menus((int)$oldMenu['id'])
                            );
                        }else {
                            return array(
                                'result' => true,
                                'text' => 'Le menu a été ajouter',
                                'html' => $this->menugestionhtml($lastId)
                            );
                        }
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        unlink('src/menu/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'Le menu n\'a pas été ajouter'
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

        public function supMenu($id) {
            if (is_int($id) && $this->verifiemenu($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                if ($produit = $this->produit($id)) {
                    foreach ($produit as $value) {
                        if ($value['image'] != 'defaul.svg') {
                            unlink('src/produit/' . $value['image']);
                        }
                    }

                    $req = $bdd->prepare('DELETE FROM produit WHERE id_menu = :id');
                    $array = array(
                        ':id' => $id
                    );

                    if ($req->execute($array) == false) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Les produit n\'ont pas étais suprimer'
                        );
                    }
                }
               
                if ($menu = $this->menus($id)) {
                    if ($menu['image'] != 'default.svg') {
                        unlink('src/menu/' . $menu['image']);
                    }

                    $req = $bdd->prepare('DELETE FROM menu WHERE id = :id');
                    $array = array(
                        ':id' => $id
                    );

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Le menu a étais suprimer'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le menu n\'a pas étais suprimer'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le menu n\'a pas étais trouver'
                    );
                }
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
                    if (move_uploaded_file($file['tmp_name'], 'src/menu/' . $file['name'])) {
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
    }
?>