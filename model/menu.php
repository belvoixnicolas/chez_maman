<?php
    require_once('bdd.php');
    //require_once('Mobile_Detect.php');

    class menu {
        private $_bdd;
        //private $_mobile;
        private $_menu;
        private $_modelMenuHtmlGestion;
        private $_modelProduitHtmlGestion;

        public function __construct () {
            $this->_bdd = new bdd;
            //$this->_mobile = new Mobile_Detect;

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
                        $construct = str_replace('%id%', htmlspecialchars($value['id']), $construct);
                        $construct = str_replace('%img%', htmlspecialchars($value['image']), $construct);
                        $construct = str_replace('%titre%', htmlspecialchars($value['titre']), $construct);

                        $html .= $construct;
                    }

                    return $html;
                }else {
                    return false;
                }
            }elseif (is_null($id) != true && $menu = $this->menus((int)$id)) {
                $html = $this->_modelMenuHtmlGestion;

                if ($html) {
                    $html = str_replace('%id%', htmlspecialchars($menu['id']), $html);
                    $html = str_replace('%img%', htmlspecialchars($menu['image']), $html);
                    $html = str_replace('%titre%', htmlspecialchars($menu['titre']), $html);

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

                    $prix = $result['prix'];

                    if (substr_count($prix, '.') != 0) {

                        $decimal = explode('.', $prix)[1];

                        if (strlen($decimal) >= 3) {
                            $result['prix'] = substr($prix, 0, -1); 
                        }
                    }

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
                        $value['image'] = 'default.svg';
                        $resu[$key] = $value;
                    }

                    $prix = $value['prix'];

                    if (substr_count($prix, '.') != 0) {
                        $decimal = explode('.', $prix)[1];

                        if (strlen($decimal) >= 3) {
                            $value['prix'] = substr($prix, 0, -1); 
                            $resu[$key] = $value;
                        }
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
                //$mobile = $this->_mobile;
                $produits = $this->produits($idMenu);

                $html = '';
                foreach ($produits as $value) {
                    if (file_exists('src/produit/' . $value['image']) == false) {
                        $value['image'] = 'default.svg'; 
                    }
                    $construct = $model;

                    $construct = str_replace('%id%', htmlspecialchars($value['id']), $construct);
                    $construct = str_replace('%titre%', htmlspecialchars($value['titre']), $construct);
                    $construct = str_replace('%img%', htmlspecialchars($value['image']), $construct);

                    /*if ($mobile->isMobile() || $mobile->isTablet()) {
                        $construct = str_replace('%i%', '<i class="fas fa-hand-point-up"></i>', $construct);
                    }else {
                        $construct = str_replace('%i%', '', $construct);
                    }*/

                    if (is_null($value['text'])) {
                       $construct = preg_replace('/%if text null%(.*)%end if text%/', '', $construct);
                    }else {
                        $search = array('%if text null%', '%end if text%', '%txt%');
                        $replace = array('', '', nl2br(htmlspecialchars($value['text'])));

                        $construct = str_replace($search, $replace, $construct);
                    }

                    if (is_null($value['prix'])) {
                        $construct = preg_replace('/%if prix null%(.*)%end if prix%/', '', $construct);
                    }else {
                         $search = array('%if prix null%', '%end if prix%', '%prix%');
                         $replace = array('', '', htmlspecialchars($value['prix']));
 
                         $construct = str_replace($search, $replace, $construct);
                     }

                    $html .= $construct;
                }

                return $html;
            }elseif (is_null($idProduit) != true && $this->_modelProduitHtmlGestion && $this->produit($idProduit)) {
                $model = $this->_modelProduitHtmlGestion;
                //$mobile = $this->_mobile;
                $produit = $this->produit($idProduit);

                if (file_exists('src/produit/' . $produit['image']) == false) {
                    $produit['image'] = 'default.svg'; 
                }

                $model = str_replace('%id%', htmlspecialchars($produit['id']), $model);
                $model = str_replace('%titre%', htmlspecialchars($produit['titre']), $model);
                $model = str_replace('%img%', htmlspecialchars($produit['image']), $model);

                /*if ($mobile->isMobile() || $mobile->isTablet()) {
                    $construct = str_replace('%i%', '<i class="fas fa-hand-point-up"></i>', $construct);
                }else {
                    $construct = str_replace('%i%', '', $construct);
                }*/

                if (is_null($produit['text'])) {
                   $model = preg_replace('/%if text null%(.*)%end if text%/', '', $model);
                }else {
                    $search = array('%if text null%', '%end if text%', '%txt%');
                    $replace = array('', '', nl2br(htmlspecialchars($produit['text'])));

                    $model = str_replace($search, $replace, $model);
                }

                if (is_null($produit['prix'])) {
                    $model = preg_replace('/%if prix null%(.*)%end if prix%/', '', $model);
                }else {
                     $search = array('%if prix null%', '%end if prix%', '%prix%');
                     $replace = array('', '', htmlspecialchars($produit['prix']));

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
                                'text' => 'Le menu a été mis à jour',
                                'data' => $this->menus((int)$oldMenu['id'])
                            );
                        }else {
                            return array(
                                'result' => true,
                                'text' => 'Le menu a été ajouté',
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

        public function supMenu($id) {
            if (is_int($id) && $this->verifMenu($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                if ($produit = $this->produits($id)) {
                    foreach ($produit as $value) {
                        if ($value['image'] != 'default.svg') {
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
                            'text' => 'Les produits n\'ont pas été supprimer'
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
                            'text' => 'Le menu a été supprimer'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le menu n\'a pas été supprimé'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le menu n\'a pas été trouvé'
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
                            'text' => 'Le fichier est corrompue'
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
                    }elseif (preg_match('/\.|,/', $prix)) {
                        $decimal = preg_split('/\.|,/', $prix);

                        if (substr($prix, -1) == 0) {
                            $prix = $decimal[0] . '.' . $decimal[1] . 1;
                        }
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
                            'text' => 'Le produit a été ajouté',
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
                        'text' => 'Le titre ne peut avoir plus de 50 caractères. Il est actuellement de ' . strlen($titre) . ' caractères.'
                    );
                }elseif (strlen($file['name']) > 50) {
                    return array(
                        'result' => false,
                        'text' => 'Le nom de l\'image ne peut avoir plus de 50 caractères. Il est actuellement de ' . strlen($file['name']) . ' caractères.'
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
                            'text' => 'Le fichier est corrompue'
                        );
                    }

                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();
                    $oldProduit = $this->produit((int)$idProduit);

                    $req = $bdd->prepare('UPDATE produit SET titre = :titre, text = :txt, image = :img, prix = :prix, date = NOW() WHERE id = :id');

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
                    }elseif (preg_match('/\.|,/', $prix)) {
                        $decimal = preg_split('/\.|,/', $prix);

                        if (substr($prix, -1) == 0) {
                            $prix = $decimal[0] . '.' . $decimal[1] . 1;
                        }
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
                            'text' => 'Le produit a été mis à jour',
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
                            'text' => 'Le produit n\'a pas été mis à jour'
                        );
                    }
                }elseif ($titre != '' && strlen($titre) > 50) {
                    return array(
                        'result' => false,
                        'text' => 'Le titre ne peut avoir plus de 50 caractères. Il est actuellement de ' . strlen($titre) . ' caractères.'
                    );
                }elseif (strlen($file['name']) > 50) {
                    return array(
                        'result' => false,
                        'text' => 'Le nom de l\'image ne peut avoir plus de 50 caractères. Il est actuellement de ' . strlen($file['name']) . ' caractères.'
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
                            'text' => 'Le produit a été supprimé'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le produit n\'a pas été supprimé'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le produit n\'a pas été trouvé'
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
                                'text' => 'La deuxième variable de la fonction uploadimg n\'est pas reconnue'
                            );
                            break;
                    }

                    if (move_uploaded_file($file['tmp_name'], $chemin . $file['name'])) {
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
                        'text' => 'Le fichier est dans un format inconnue. Le format gif, jpeg, png et svg sont reconnues.',
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