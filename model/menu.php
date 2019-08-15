<?php
    require_once('bdd.php');

    class menu {
        private $_bdd;
        private $_menu;
        private $_modelMenuHtmlGestion;
        private $_modelProduitHtmlGestion;

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

            $menuHtml = file_get_contents('../view/menumodelgestion.html');

            if ($menuHtml) {
                $this->_modelMenuHtmlGestion = $menuHtml;
            }else {
                $this->_modelMenuHtmlGestion = false;
            }

            $produitHtml = file_get_contents('../view/produitModelGestion.html');

            if ($produitHtml) {
                $this->_modelProduitHtmlGestion = $produitHtml;
            }else {
                $this->_modelProduitHtmlGestion = false;
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

        public function verifMenu ($id) {
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

        public function produit ($id) {
            if (is_null($id) != true && $id != 0 && is_int($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT * FROM produit WHERE id = :id');
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

        public function produits ($id) {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('SELECT id, titre, text, image, prix FROM produit WHERE id_menu = :id ORDER BY date DESC');
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

        public function produitsGestionHtml($idMenu ,$idProduit=null) {
            if (is_null($idProduit) && $this->_modelProduitHtmlGestion && $this->produits($idMenu)) {
                $model = $this->_modelProduitHtmlGestion;
                $produits = $this->produits($idMenu);

                $html = '';
                foreach ($produits as $value) {
                    if (file_exists('src/produit/' . $value['image']) == false) {
                        $value['image'] = 'default.svg'; 
                    }
                    $construct = $model;

                    $construct = str_replace('%id%', $value['id'], $construct);
                    $construct = str_replace('%titre%', $value['titre'], $construct);
                    $construct = str_replace('%img%', $value['image'], $construct);

                    if (is_null($value['text'])) {
                       $construct = preg_replace('/%if text null%(.*)%end if text%/', '', $construct);
                    }else {
                        $search = array('%if text null%', '%end if text%', '%txt%');
                        $replace = array('', '', $value['text']);

                        $construct = str_replace($search, $replace, $construct);
                    }

                    if (is_null($value['prix'])) {
                        $construct = preg_replace('/%if prix null%(.*)%end if prix%/', '', $construct);
                    }else {
                         $search = array('%if prix null%', '%end if prix%', '%prix%');
                         $replace = array('', '', $value['prix']);
 
                         $construct = str_replace($search, $replace, $construct);
                     }

                    $html .= $construct;
                }

                return $html;
            }elseif (is_null($idProduit) != true && $this->_modelProduitHtmlGestion && $this->produit($idProduit)) {
                $model = $this->_modelProduitHtmlGestion;
                $produit = $this->produit($idProduit);

                if (file_exists('src/produit/' . $produit['image']) == false) {
                    $produit['image'] = 'default.svg'; 
                }

                $model = str_replace('%id%', $produit['id'], $model);
                $model = str_replace('%titre%', $produit['titre'], $model);
                $model = str_replace('%img%', $produit['image'], $model);

                if (is_null($produit['text'])) {
                   $model = preg_replace('/%if text null%(.*)%end if text%/', '', $model);
                }else {
                    $search = array('%if text null%', '%end if text%', '%txt%');
                    $replace = array('', '', $produit['text']);

                    $model = str_replace($search, $replace, $model);
                }

                if (is_null($produit['prix'])) {
                    $model = preg_replace('/%if prix null%(.*)%end if prix%/', '', $model);
                }else {
                     $search = array('%if prix null%', '%end if prix%', '%prix%');
                     $replace = array('', '', $produit['prix']);

                     $model = str_replace($search, $replace, $model);
                 }

                return $model;
            }else {
                return false;
            }
        }

        public function verifProduit($id) {
            if ($id != 0 && is_int($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT id FROM produit WHERE id = :id');
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
                $upload = $this->uploadimg($file, 'menu');

                if ($upload['result']) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();
                    
                    if (is_null($id) == false && $this->verifMenu((int)$id)) {
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
            if (is_int($id) && $this->verifMenu($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                if ($produit = $this->produits($id)) {
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

        public function addProduit($titre, $text, $prix, $file, $idMenu, $idProduit=null) {
            if (is_null($idProduit) && $this->verifMenu((int)$idMenu)) {
                if ($titre != '' && strlen($titre) <= 50 && strlen($file['name']) <= 50) {
                    if ($file['size'] > 0 && $file['name'] != '' && $file['tmp_name'] != '') {
                        $upload = $this->uploadimg($file, 'produit');
    
                        if ($upload['result'] == false) {
                            return $upload;
                        }
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'Le fichier est corempue'
                        );
                    }

                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('INSERT INTO produit (id, titre, text, image, prix, id_menu) VALUES (NULL, :titre, :txt, :img, :prix, :id)');

                    if ($text == '') {
                        $text = null;
                    }
                    if ($prix == '') {
                        $prix = null;
                    }

                    $array = array(
                        ':titre' => $titre,
                        ':txt' => $text,
                        ':img' => $file['name'],
                        ':prix' => $prix,
                        ':id' => $idMenu
                    );

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $idProduit = $bdd->lastInsertId();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Le produit à été ajouter',
                            'html' => $this->produitsGestionHtml((int)$idMenu ,(int)$idProduit)
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        unlink('src/produit/' . $file['name']);

                        return array(
                            'result' => false,
                            'text' => 'Le produit n\'a pas été ajouter'
                        );
                    }
                }elseif ($titre != '' && strlen($titre) > 50) {
                    return array(
                        'result' => false,
                        'text' => 'Le titre ne peux avoir plus de 50 caractére. Il est actuellement de ' . strlen($titre)
                    );
                }elseif (strlen($file['name']) > 50) {
                    return array(
                        'result' => false,
                        'text' => 'Le nom de l\'image ne peux avoir plus de 50 caractére. Il est actuellement de ' . strlen($file['name'])
                    );
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Il manque le titre'
                    );
                }
            }elseif (is_null($idProduit) != true && $this->verifProduit((int)$idProduit) && $this->verifMenu((int)$idMenu)) {
                if ($titre != '' && strlen($titre) <= 50 && strlen($file['name']) <= 50) {
                    if ($file['size'] > 0 && $file['name'] != '' && $file['tmp_name'] != '') {
                        $upload = $this->uploadimg($file, 'produit');
    
                        if ($upload['result'] == false) {
                            return $upload;
                        }
                    }elseif ($file['size'] == 0 && $file['name'] == '' && $file['tmp_name'] == '') {
                        $file = false;
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'Le fichier est corempue'
                        );
                    }

                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();
                    $oldProduit = $this->produit((int)$idProduit);

                    $req = $bdd->prepare('UPDATE produit SET titre = :titre, text = :txt, image = :img, prix = :prix WHERE id = :id');

                    if ($text == '') {
                        $text = null;
                    }
                    if ($file == false) {
                        $img = $oldProduit['image'];
                    }else {
                        $img = $file['name'];
                    }
                    if ($prix == '') {
                        $prix = null;
                    }

                    $array = array(
                        ':titre' => $titre,
                        ':txt' => $text,
                        ':img' => $img,
                        ':prix' => $prix,
                        ':id' => $idProduit
                    );

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        if ($oldProduit['image'] != $file['name'] && $file) {
                            unlink('src/produit/' . $oldProduit['image']);
                        }

                        return array(
                            'result' => true,
                            'text' => 'Le produit à été mis a jour',
                            'html' => $this->produitsGestionHtml((int)$idMenu ,(int)$idProduit),
                            'id' => $oldProduit['id']
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        if ($file) {
                            unlink('src/produit/' . $file['name']);
                        }

                        return array(
                            'result' => false,
                            'text' => 'Le produit n\'a pas été mis a jour'
                        );
                    }
                }elseif ($titre != '' && strlen($titre) > 50) {
                    return array(
                        'result' => false,
                        'text' => 'Le titre ne peux avoir plus de 50 caractére. Il est actuellement de ' . strlen($titre)
                    );
                }elseif (strlen($file['name']) > 50) {
                    return array(
                        'result' => false,
                        'text' => 'Le nom de l\'image ne peux avoir plus de 50 caractére. Il est actuellement de ' . strlen($file['name'])
                    );
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Il manque le titre'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        public function supProduit($id) {
            if (is_int($id) && $this->verifProduit($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();
               
                if ($produit = $this->produit((int)$id)) {
                    if ($produit['image'] != 'default.svg') {
                        unlink('src/produit/' . $produit['image']);
                    }

                    $req = $bdd->prepare('DELETE FROM produit WHERE id = :id');
                    $array = array(
                        ':id' => $id
                    );

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Le produit a étais suprimer'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le produit n\'a pas étais suprimer'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le produit n\'a pas étais trouver'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Erreur'
                );
            }
        }

        private function uploadimg ($file, $var) {
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
                    switch ($var) {
                        case 'menu':
                            $chemin = 'src/menu/';
                            break;
                        
                        case 'produit':
                            $chemin = 'src/produit/';
                            break;
                        
                        default:
                            return array(
                                'result' => false,
                                'text' => 'La deuxiéme variavle de la function uploadimg n\'est pas reconue'
                            );
                            break;
                    }

                    if (move_uploaded_file($file['tmp_name'], $chemin . $file['name'])) {
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