<?php 
    require_once('../model/horraire.php');
    require_once('../model/entreprise.php');
    require_once('../model/reseaux.php');
    require_once('../model/menu.php');
    require_once('../model/Mobile_Detect.php');

    class navbar {
        private $_fichier;
        private $_horraire;
        private $_entreprise;
        private $_reseaux;
        private $_mobile;
        private $_menu;


        public function __construct() {
            $lien = explode("/", $_SERVER['PHP_SELF']);
            $this->_fichier = $lien[count($lien) - 1];

            $horraire = new horraire;
            $horraire = $horraire->horraire();
            $this->_horraire = $horraire;

            $entreprise = new entreprise;
            $this->_entreprise = $entreprise;

            $reseaux = new reseaux;
            $this->_reseaux = $reseaux;

            $menu = new menu;
            $this->_menu = $menu;

            $mobile = new Mobile_Detect;
            $this->_mobile = $mobile;
        }

        /// getter ///
        public function lien () {
            $lien = "";
            $page = $this->_fichier;

            switch ($page) {
                case 'acceuil.php':
                    if ($this->menu()) {
                        $lien = "<li><a href=\"../index.php?page=menu\">menu</a></li>";
                    }else {
                        $lien = "";
                    }
                    break;
        
                case 'menu.php':
                    $lien = "<li><a href=\"../index.php?page=index\">aceuil</a></li>";
                    break;
                
                default:
                    $lien = "";
                    break;
            }
            
            return $lien;
        }

        public function horraire () {
            $jour = date('N') - 1;
            $horraire = $this->_horraire[$jour];
            $heure = date('Hi');
            $resultat = array();

            if ($horraire['ouvertMat'] == null && $horraire['ouvertAp'] == null ) {
                $resultat['image'] = "paneau_fermer.svg";
                $resultat['text'] = "ouvre demain";
            }elseif ( $horraire['ouvertMat'] != null && $horraire['fermeAp'] != null && $horraire['fermeMat'] == null) {
                //$horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeAp']);

                $delai = $this->delai($horraire['ouvertMat'], $horraire['fermeAp']);
                 

                if ($delai) {
                    $format = new horraire;

                    switch ($delai) {
                        case '1':
                            $resultat['image'] = "paneau_ouvert.svg";
                            $resultat['text'] = "ouvert jusqu'à " . $format->format($horraire['fermeAp']);
                            break;

                        case '2':
                            $resultat['image'] = "paneau_fermer.svg";
                            $resultat['text'] = "ouvre à " . $format->format($horraire['ouvertMat']);
                            break;

                        case '3':
                            $resultat['image'] = "paneau_fermer.svg";
                            $resultat['text'] = "ouvre demain";
                            break;
                        
                        default:
                            $resultat['image'] = 'paneau_fermer.svg';
                            $resultat['text'] = false;
                            break;
                    }
                }else {
                    $resultat['image'] = 'paneau_fermer.svg';
                    $resultat['text'] = false;
                }
            }elseif ($horraire['ouvertMat'] == null && $horraire['ouvertAp'] != null && $horraire['fermeAp'] != null) {
                //$horraire['heure'] = $this->format($value['ouvertAp']) . ' à ' . $this->format($value['fermeAp']);

                $delai = $this->delai($horraire['ouvertAp'], $horraire['fermeAp']);
                 

                if ($delai) {
                    $format = new horraire;

                    switch ($delai) {
                        case '1':
                            $resultat['image'] = "paneau_ouvert.svg";
                            $resultat['text'] = "ouvert jusqu'à " . $format->format($horraire['fermeAp']);
                            break;

                        case '2':
                            $resultat['image'] = "paneau_fermer.svg";
                            $resultat['text'] = "ouvre à " . $format->format($horraire['ouvertAp']);
                            break;

                        case '3':
                            $resultat['image'] = "paneau_fermer.svg";
                            $resultat['text'] = "ouvre demain";
                            break;
                        
                        default:
                            $resultat['image'] = 'paneau_fermer.svg';
                            $resultat['text'] = false;
                            break;
                    }
                }else {
                    $resultat['image'] = 'paneau_fermer.svg';
                    $resultat['text'] = false;
                }
            }elseif ($horraire['ouvertMat'] != null && $horraire['fermeMat'] != null && $horraire['ouvertAp'] == null) {
                //$horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeMat']);

                $delai = $this->delai($horraire['ouvertMat'], $horraire['fermeMat']);
                 

                if ($delai) {
                    $format = new horraire;

                    switch ($delai) {
                        case '1':
                            $resultat['image'] = "paneau_ouvert.svg";
                            $resultat['text'] = "ouvert jusqu'à " . $format->format($horraire['fermeMat']);
                            break;

                        case '2':
                            $resultat['image'] = "paneau_fermer.svg";
                            $resultat['text'] = "ouvre à " . $format->format($horraire['ouvertMat']);
                            break;

                        case '3':
                            $resultat['image'] = "paneau_fermer.svg";
                            $resultat['text'] = "ouvre demain";
                            break;
                        
                        default:
                            $resultat['image'] = 'paneau_fermer.svg';
                            $resultat['text'] = false;
                            break;
                    }
                }else {
                    $resultat['image'] = 'paneau_fermer.svg';
                    $resultat['text'] = false;
                }
            }elseif ($horraire['ouvertMat'] != null && $horraire['fermeMat'] != null && $horraire['ouvertAp'] != null && $horraire['fermeAp'] != null) {
                //$horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeMat']) . ' <br/> ' . $this->format($value['ouvertAp']) . ' à ' . $this->format($value['fermeAp']);

                $repére = date('A');

                if ($repére == 'AM') {
                    $delai = $this->delai($horraire['ouvertMat'], $horraire['fermeMat']);
                }elseif ($repére == 'PM') {
                    $delai = $this->delai($horraire['ouvertAp'], $horraire['fermeAp']);
                }else {
                    $delai = false;
                }
                
                 

                if ($delai) {
                    $format = new horraire;

                    switch ($delai) {
                        case '1':
                            $resultat['image'] = "paneau_ouvert.svg";
                            if ($repére == 'AM') {
                                $resultat['text'] = "ouvert jusqu'à " . $format->format($horraire['fermeMat']);
                            }else {
                                $resultat['text'] = "ouvert jusqu'à " . $format->format($horraire['fermeAp']);
                            }
                            break;

                        case '2':
                            $resultat['image'] = "paneau_fermer.svg";
                            if ($repére == 'AM') {
                                $resultat['text'] = "ouvre à " . $format->format($horraire['ouvertMat']);
                            }else {
                                $resultat['text'] = "ouvre à " . $format->format($horraire['ouvertAp']);
                            }
                            break;

                        case '3':
                            $resultat['image'] = "paneau_fermer.svg";
                            if ($repére == 'AM') {
                                $resultat['text'] = "ouvre à " . $format->format($horraire['ouvertAp']);
                            }else {
                                $resultat['text'] = "ouvre demain";
                            }
                            break;
                        
                        default:
                            $resultat['image'] = 'paneau_fermer.svg';
                            $resultat['text'] = false;
                            break;
                    }
                }else {
                    $resultat['image'] = 'paneau_fermer.svg';
                    $resultat['text'] = false;
                }
            }else {
                $resultat = false;
            }

            return $resultat;
        }

        public function address () {
            $adresse = $this->_entreprise;
            $adresse = $adresse->address();

            return $adresse;
        }

        public function reseau () {
            $reseaux = $this->_reseaux;
            $reseaux = $reseaux->reseaux();

            return $reseaux;
        }

        public function numero () {
            $entreprise = $this->_entreprise;

            $numero = $entreprise->numero();

            if ($numero) {
                $mobile = $this->_mobile;
                if ($mobile->isMobile() || $mobile->isTablet()) {
                    return array (
                        'mobile' => true,
                        'numero' => $numero
                    );
                }else {
                    return array (
                        'mobile' => false,
                        'numero' => $numero
                    );
                }
            }else {
                return false;
            }
        }

        private function menu () {
            $menu = $this->_menu;
            $menu = $menu->menus();

            if (is_array($menu) && count($menu) > 0) {
                return true;
            }else {
                return false;
            }
        }

        private function delai ($debut, $fin) {
            if ($debut && $fin) {
                $heure = date('H:i');

                if($debut <= $heure && $fin >= $heure) {
                    return 1;
                }elseif ($debut > $heure) {
                    return 2;
                }elseif ($fin < $heure) {
                    return 3;
                }else {
                    return false;
                }
            }else {
                return false;
            }
        }
    }
?>