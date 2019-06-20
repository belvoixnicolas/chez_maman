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

        private function format ($heure) {
            if (isset($heure)) {
                $format = explode(':', $heure);

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
    }
?>