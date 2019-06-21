<?php 
    require_once('horraire.php');

    class navbar {
        private $_fichier;
        private $_horraire;

        public function __construct() {
            $lien = explode("/", $_SERVER['PHP_SELF']);
            $this->_fichier = $lien[count($lien) - 1];

            $horraire = new horraire;
            $horraire = $horraire->horraire();
            $this->_horraire = $horraire;
        }

        /// getter ///
        public function lien () {
            $lien = "";
            $page = $this->_fichier;

            switch ($page) {
                case 'acceuil.php':
                    $lien = "<a href=\"../index.php?page=menu\">menu</a>";
                    break;
        
                case 'menu.php':
                    $lien = "<a href=\"../index.php?page=index\">aceuil</a>";
                    break;
                
                default:
                    # code...
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
                $horraire['heure'] = 'fermer';
            }elseif ( $horraire['ouvertMat'] != null && $horraire['fermeAp'] != null && $horraire['fermeMat'] == null) {
                //$horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeAp']);

                $delai = $this->delai($horraire['ouvertMat'], $horraire['fermeAp']);
                echo $delai;

                if ($delai) {
                    $format = new horraire;

                    switch ($delai) {
                        case '1':
                            $resultat['image'] = "paneau_ouvert.svg";
                            $resultat['text'] = "ouvert jusqu'a " . $format->format($horraire['fermeAp']);
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
                $horraire['heure'] = $this->format($value['ouvertAp']) . ' à ' . $this->format($value['fermeAp']);
            }elseif ($horraire['ouvertMat'] != null && $horraire['fermeMat'] != null && $horraire['ouvertAp'] == null) {
                $horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeMat']);
            }elseif ($horraire['ouvertMat'] != null && $horraire['fermeMat'] != null && $horraire['ouvertAp'] != null && $value['fermeAp'] != null) {
                $horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeMat']) . ' <br/> ' . $this->format($value['ouvertAp']) . ' à ' . $this->format($value['fermeAp']);
            }else {
                $horraire['heure'] = 'erreur';
            }

            var_dump($resultat);
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