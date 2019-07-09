<?php
    require_once('bdd.php');

    class profil {
        private $_bdd;

        public function __construct () {
            $bdd = new bdd;
            $this->_bdd = $bdd;
        }

        /// getter ///
        public function connexion($mail, $mdp, $souv = null) {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('SELECT id, mail, motDePasse, admin FROM profil WHERE mail = :mail');
            $req->execute(array(':mail' => $mail));

            if ($result = $req->fetch()) {
                $req->closecursor();
                $bdd = null;

                if (password_verify($mdp, $result['motDePasse'])) {
                    if (is_bool($souv) && $souv && strtolower($mail) != strtolower('admin@admin')) {
                        setcookie("souv", $result['mail'], strtotime('+1 year'));
                    }elseif (is_bool($souv) && isset($_COOKIE['souv']) && $souv == false) {
                        if ($_COOKIE['souv'] == $mail) {
                            setcookie("souv", "", time() - 3600);
                            unset($_COOKIE['souv']);
                        }
                    }

                    $hash = $result['motDePasse'];

                    foreach ($result as $key => $value) {
                        if ($value == $hash) {
                            unset($result[$key]);
                        }
                    }

                    return $result;
                }else {
                    return false;
                }
            }else {
                $req->closecursor();
                $bdd = null;

                return false;
            }
        }

        public function verifProfil ($profil) {
            if (is_array($profil) && isset($profil['id'], $profil['mail'], $profil['admin'])) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT id, mail, admin FROM profil WHERE id = :id AND mail = :mail AND admin = :admin');
                $req->execute(array(
                    ':id' => $profil['id'],
                    ':mail' => $profil['mail'],
                    ':admin' => $profil['admin']
                ));

                if ($req->fetch()) {
                    $req->closecursor();
                    $bdd = null;

                    return true;
                }else {
                    $req->closecursor ();
                    $bdd = null;

                    return false;
                }
            }else {
                return false;
            }
        }

        public function profils ($id = null) {
            if (is_null($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->query('SELECT id, nom, mail, admin FROM profil WHERE id != 1');

                if ($result = $req->fetchall()) {
                    $req->closecursor();
                    $bdd = null;

                    return $result;
                }else {
                    $req->closecursor();
                    $bdd = null;

                    return false;
                }
            }elseif (is_int($id) && $id != 1) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('SELECT id, nom, mail, admin FROM profil WHERE id = :id');
                $array = array(
                    ':id' => $id
                );

                if ($req->execute($array)) {
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
                    $req->closecursor();
                    $bdd = null;
    
                    return false;
                }
            }else {
                return false;
            }
        }

        private function comparMail ($mail) {
            $bdd = $this->_bdd;
            $bdd = $bdd->co();

            $req = $bdd->prepare('SELECT id FROM profil WHERE mail = :mail');
            $req->execute(array(
                ':mail' => $mail
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

        private function mdpAleatoire() {
         $chaine = '';
         $listeCar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
         $max = mb_strlen($listeCar, '8bit') - 1;

         for ($i = 0; $i < 10; ++$i) {
            $chaine .= $listeCar[random_int(0, $max)];
         }

         return $chaine;
        }

        /// setter ///
        public function addProfil ($mail, $nom) {
            if (strlen($mail) <= 50 && strlen('$nom') <= 50 && $mail != '' && $nom != '') {
                if (filter_var($mail, FILTER_VALIDATE_EMAIL) && $this->comparMail($mail) == false) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();
                    $mdp = $this->mdpAleatoire();
                    $mdphash = password_hash($mdp, PASSWORD_BCRYPT);
                    
                    $req = $bdd->prepare('INSERT INTO profil (id, mail, motDePasse, nom) VALUES (NULL, :mail, :mdp, :nom)');
                    $array = array(
                        ':mail' => $mail,
                        ':mdp' => $mdphash,
                        ':nom' => $nom
                    );

                    $to = $mail;
                    $subject = "Chez maman";
                    $txt = '<p>' . $mail . '</p><p>' . $mdp . '</p>';
                    $headers = array(
                        'From' => "webmaster@chezmaman.com",
                        'MIME-Version' => '1.0',
                        'Content-type' => 'text/html; charset=iso-8859-1'
                    );

                    if (mail($to,$subject,$txt,$headers)) {
                        if ($req->execute($array)) {
                            $req->closecursor();
                            $id = $bdd->lastInsertId();
                            $bdd = null;

                            return array(
                                'result' => true,
                                'text' => 'Le nouvelle utilisateur a était ajouter',
                                'html' => '<tr><td class="nom">' . $nom . '</td><td class="mail">' . $mail . '</td><td class="admin"><button id="modifprofil" name="id" value="' . $id . '"><i class="far fa-star"></i></button></td><td class="sup"><button id="supprofil" name="id" value="' . $id . '"><i class="fas fa-times"></i></button></td></tr>'
                            
                            );
                        }else {
                            $req->closecursor();
                            $bdd = null;

                            $txt = '<p>Une erreur c\'est produit</p>';

                            if (mail($to,$subject,$txt,$headers)) {
                                return array(
                                    'result' => false,
                                    'text' => 'Le nouvelle utilisateur n\'a pas put étre ajouter'
                                );
                            }else {
                                return array(
                                    'result' => false,
                                    'text' => 'Le nouvelle utilisateur n\'a pas put étre ajouter et il n\'a pas put étre prévenu de l\'erreur'
                                );
                            }
                        }
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'Aucun mail n\'a put étre envoyer'
                        );
                    }
                }elseif (filter_var($mail, FILTER_VALIDATE_EMAIL) && $this->comparMail($mail) == true) {
                    return array(
                        'result' => false,
                        'text' => 'Le mail renseigner existe déja'
                    );
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le mail renseigner n\'est pas une addresse mail'
                    );
                }
            }elseif (strlen($mail) > 50) {
                return array(
                    'result' => false,
                    'text' => 'L\'addresse mail ne peut faire plus de 50 caractére'
                );
            }elseif ($mail == '') {
                return array(
                    'result' => false,
                    'text' => 'Il manque l\'addresse mail'
                );
            }elseif (strlen($nom) > 50) {
                return array(
                    'result' => false,
                    'text' => 'Le nom ne peut faire plus de 50 caractére'
                );
            }elseif ($nom == '') {
                return array(
                    'result' => false,
                    'text' => 'Il manque le nom'
                );
            }else {
                return array(
                    'result' => false,
                    'text' => 'Une erreur c\'est produit'
                );
            }
        }

        public function modident ($mail, $pwd, $id) {
            $mail = $this->modifmail($mail, $id);
            $pwd = $this->modifpwd($pwd, $id);

            if ($mail == false) {
                $mail = 0;
            }

            if ($pwd == false) {
                $pwd = 0;
            }

            return $mail . '|' . $pwd;
        }

        public function modifmail ($mail, $id) {
            if (filter_var($mail, FILTER_VALIDATE_EMAIL) && strlen($mail) <= 50 && $mail != "admin@admin" && $this->comparMail($mail) == false) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('UPDATE profil SET mail = :mail WHERE id = :id');
                
                $array = array(
                    ':mail' => $mail,
                    ':id' => $id
                );

                if ($req->execute($array)) {
                    $req->closecursor();
                    $bdd = null;

                    $www = $_SERVER['HTTP_HOST'];

                    $to = $mail;
                    $subject = "Adresse mail modifier";
                    $txt = '<p>Votre adresse mail à bien étais modifier</p><br/><a href="' . $www . '/index.php?page=connexion" target="_blank">Ce conecter</a>';
                    $headers = array(
                        'From' => "webmaster@chezmaman.com",
                        'MIME-Version' => '1.0',
                        'Content-type' => 'text/html; charset=iso-8859-1'
                    );

                    mail($to,$subject,$txt,$headers);

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

        public function modifpwd ($pwd, $id) {
            if (is_string($pwd) || is_float($pwd) && is_int($id)) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->prepare('UPDATE profil SET motDePasse = :pwd WHERE id = :id');

                $hash = password_hash($pwd, PASSWORD_BCRYPT);

                $array = array(
                    ':pwd' => $hash,
                    ':id' => $id
                );

                if ($req->execute($array)) {
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

        public function mdpPerdu($mail) {
            if (is_string($mail) == false || $mail == '') {
                return array(
                    'result' => false,
                    'text' => 'Il manque l\'adresse mail'
                );
            }elseif (strpos($mail, '@') === false || strpos($mail, ' ')) {
                return array(
                    'result' => false,
                    'text' => 'Se n\'est pas une addresse mail'
                );
            }elseif ($this->comparMail($mail) == false) {
                return array(
                    'result' => false,
                    'text' => 'Cette addresse mail n\'existe pas'
                );
            }elseif ($mail == 'admin@admin') {
                return array(
                    'result' => false,
                    'text' => 'Ce compte ne peux pas étre modifier'
                );
            }else {
                $newmdp =  $this->mdpAleatoire();
                $newmdphash = password_hash($newmdp, PASSWORD_BCRYPT);

                $to = $mail;
                $subject = "Mot de passe oublier";
                $txt = '<p>' . $newmdp . '</p>';
                $headers = array(
                    'From' => "webmaster@chezmaman.com",
                    'MIME-Version' => '1.0',
                    'Content-type' => 'text/html; charset=iso-8859-1'
                );

                if (mail($to,$subject,$txt,$headers)) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('UPDATE profil SET motDePasse = :mdp WHERE mail = :mail');
                    $value = array(
                        ':mdp' => $newmdphash,
                        ':mail' => $mail
                    );

                    if ($req->execute($value)) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        $subject = 'Erreur mot de passe';
                        $txt = '<p>Le mot de passe n\'a pas put étre envoyer a la base de donner</p>';
                        mail($to,$subject,$txt,$headers);

                        return array(
                            'result' => false,
                            'text' => 'Le mot de passe n\'a pas put étre envoyer a la base de donner'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le mail n\'à pas put étre envoyer'
                    );
                }
            }
        }

        public function deco() {
            if (isset($_SESSION['profil'])) {
                unset($_SESSION['profil']);

                if (isset($_SESSION['profil'])) {
                    return false;
                }else {
                    return true;
                }
            }else {
                return true;
            }
        }

        public function modadmin($id, $bollen = null) {
            if (is_null($bollen) && is_int($id) && $id != 1 && $id != 0) {
                if ($profil = $this->profils($id)) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('UPDATE profil SET admin = :admin WHERE id = :id');

                    if ($profil['admin'] == 0) {
                        $array = array(
                            ':admin' => 1,
                            ':id' => $id
                        );
                    }else {
                        $array = array(
                            ':admin' => 0,
                            ':id' => $id
                        );
                    }

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Les droit on étais changer'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Les droit n\'ont pas put étre changer'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Ce profil n\'existe pas'
                    );
                }
            }elseif (is_bool($bollen) && is_int($id) && $id != 1 && $id != 0) {
                if ($profil = $this->profils($id)) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('UPDATE profil SET admin = :admin WHERE id = :id');

                    if ($bollen == true) {
                        $array = array(
                            ':admin' => 1,
                            ':id' => $id
                        );
                    }else {
                        $array = array(
                            ':admin' => 0,
                            ':id' => $id
                        );
                    }

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Les droit on étais changer'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Les droit n\'ont pas put étre changer'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Ce profil n\'existe pas'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Une erreur c\'est produit'
                );
            }
        }

        public function supprofil($id) {
            if (is_int($id) && $id != 1 && $id != 0) {
                if ($this->profils($id)) {
                    $bdd = $this->_bdd;
                    $bdd = $bdd->co();

                    $req = $bdd->prepare('DELETE FROM profil WHERE id = :id');
                    $array = array(
                        ':id' => $id
                    );

                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => true,
                            'text' => 'Le profil a étais suprimer'
                        );
                    }else {
                        $req->closecursor();
                        $bdd = null;

                        return array(
                            'result' => false,
                            'text' => 'Le profil n\'a pas étais suprimer'
                        );
                    }
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Ce profil n\'existe pas'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Une erreur c\'est produit'
                );
            }
        }
    }
?>