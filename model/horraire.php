<?php
    require_once('bdd.php');

    class horraire {
        private $_bdd;
        private $_lundi;
        private $_mardi;
        private $_mercredi;
        private $_jeudi;
        private $_vendredi;
        private $_samedi;
        private $_dimanche;

        public function __construct() {
            $this->_bdd = new bdd;

            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $semaine = array (
                'lundi',
                'mardi',
                'mercredi',
                'jeudi',
                'vendredi',
                'samedi',
                'dimanche'
            );
            
            $req = $bdd->prepare('SELECT jour, ouvertMat, fermeMat, ouvertAp, fermeAp FROM horraire WHERE jour = :jour');
            foreach ($semaine as $value) {
                $req->execute(array (
                    ':jour' => $value
                ));

                $resultat = $req->fetch();

                switch ($value) {
                    case 'lundi':
                        $this->_lundi = $resultat;
                        $resultat = null;
                        break;

                    case 'mardi':
                        $this->_mardi = $resultat;
                        $resultat = null;
                        break;

                    case 'mercredi':
                        $this->_mercredi = $resultat;
                        $resultat = null;
                        break;

                    case 'jeudi':
                        $this->_jeudi = $resultat;
                        $resultat = null;
                        break;

                    case 'vendredi':
                        $this->_vendredi = $resultat;
                        $resultat = null;
                        break;

                    case 'samedi':
                        $this->_samedi = $resultat;
                        $resultat = null;
                        break;

                    case 'dimanche':
                        $this->_dimanche = $resultat;
                        $resultat = null;
                        break;
                    
                    default:
                        break;
                }

                $req->closeCursor();
                $bdd = null;
            }
        }

        /// getter ///
        public function horraire() {
            $horraire = array (
                $this->_lundi,
                $this->_mardi,
                $this->_mercredi,
                $this->_jeudi,
                $this->_vendredi,
                $this->_samedi,
                $this->_dimanche
            );

            return $horraire;
        }

        public function horraireTab () {
            $horraires = $this->horraire();
            $horraireTab = array();

            foreach ($horraires as $value) {
                $horraire = array(
                    'jour' => $value['jour'],
                    'heure' => ''
                );

                if ($value['ouvertMat'] == null && $value['ouvertAp'] == null ) {
                    $horraire['heure'] = 'fermer';
                }elseif ( $value['ouvertMat'] != null && $value['fermeAp'] != null && $value['fermeMat'] == null) {
                    $horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeAp']);
                }elseif ($value['ouvertMat'] == null && $value['ouvertAp'] != null && $value['fermeAp'] != null) {
                    $horraire['heure'] = $this->format($value['ouvertAp']) . ' à ' . $this->format($value['fermeAp']);
                }elseif ($value['ouvertMat'] != null && $value['fermeMat'] != null && $value['ouvertAp'] == null) {
                    $horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeMat']);
                }elseif ($value['ouvertMat'] != null && $value['fermeMat'] != null && $value['ouvertAp'] != null && $value['fermeAp'] != null) {
                    $horraire['heure'] = $this->format($value['ouvertMat']) . ' à ' . $this->format($value['fermeMat']) . ' <br/> ' . $this->format($value['ouvertAp']) . ' à ' . $this->format($value['fermeAp']);
                }else {
                    $horraire['heure'] = 'erreur';
                }

                $horraireTab[] = $horraire;
            }

            return $horraireTab;
        }

        public function format ($heure) {
            if (isset($heure)) {
                $format = explode(':', $heure);

                $h = $format[0];

                if ($h[0] == 0) {
                    $format[0] = $h[1];
                }

                if ($format[1] > 0) {
                    $format = $format[0] . ' h ' . $format[1];
                }else {
                    $format = $format[0] . 'h';
                }

                return $format;
            } else {
                return 'erreur';
            }
            
        }

        /// SETTER ///
        public function setHorraire($jour, $indicateur, $val) {
            if ($jour != '' && $indicateur != '' && $val != '') {
                switch ($jour) {
                    case 'lundi':
                        $horraireJour = $this->_lundi;
                        break;

                    case 'mardi':
                        $horraireJour = $this->_mardi;
                        break;

                    case 'mercredi':
                        $horraireJour = $this->_mercredi;
                        break;

                    case 'jeudi':
                        $horraireJour = $this->_jeudi;
                        break;

                    case 'vendredi':
                        $horraireJour = $this->_vendredi;
                        break;

                    case 'samedi':
                        $horraireJour = $this->_samedi;
                        break;

                    case 'dimanche':
                        $horraireJour = $this->_dimanche;
                        break;
                    
                    default:
                        $horraireJour = false;
                        break;
                }

                if ($horraireJour) {
                    switch ($indicateur) {
                        case 'ouvertMat':
                        case 'fermeMat':
                            if (str_replace(':', '', $val) <= 1200) {
                                $verifHorraire = true;
                            }else {
                                $verifHorraire = false;
                            }
                            break;

                        case 'ouvertAp':
                        case 'fermeAp':
                            if (str_replace(':', '', $val) >= 1200 && str_replace(':', '', $val) <= 2359 || str_replace(':', '', $val) == 0000) {
                                $verifHorraire = true;
                            }else {
                                $verifHorraire = false;
                            }
                            break;
                        
                        default:
                            $verifHorraire = false;
                            break;
                    }

                    if ($verifHorraire) {
                        $bdd = $this->_bdd;
                        $bdd = $bdd->co();

                        $req = $bdd->prepare("UPDATE horraire SET $indicateur = :val WHERE jour = :jour");

                        if (str_replace(':', '', $val) == 0000) {
                            $val = null;
                        }else {
                            $val = explode(':', $val);
                            $val = $val[0] . ':' . $val[1];
                        }

                        $array = array(
                            ':val' => $val,
                            ':jour' => $jour
                        );

                        if ($req->execute($array)) {
                            $req->closecursor();
                            $bdd = null;
                            
                            $horraireJour[$indicateur] = $val;

                            if (is_null($horraireJour['ouvertMat']) && is_null($horraireJour['ouvertAp'])) {
                                $ajout = 'Pensez à ajouter une heure d\'ouverture';
                            }elseif(is_null($horraireJour['fermeMat']) && is_null($horraireJour['fermeAp']) || is_null($horraireJour['ouvertAp']) == false && is_null($horraireJour['fermeAp']) || is_null($horraireJour['ouvertMat']) == false && is_null($horraireJour['fermeMat']) && is_null($horraireJour['fermeAp'])) {
                                $ajout = 'Pensez à ajouter une heure de fermeture';
                            }else {
                                $ajout = '';
                            }

                            return array(
                                'result' => true,
                                'text' => 'L\'horaire a été mis à jour. ' . $ajout,
                                'time' => $val
                            );
                        }else {
                            $req->closecursor();
                            $bdd = null;
                            
                            return array(
                                'result' => false,
                                'text' => 'L\'horaire n\'a pas pu être mis à jour',
                                'time' => $horraireJour[$indicateur]
                            );
                        }
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'L\'horaire ne fait pas partie de l\'intervalle autoriser'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le jour indiqué n\'est pas un jour de la semaine'
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