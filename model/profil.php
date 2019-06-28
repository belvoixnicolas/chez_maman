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
                    if (is_bool($souv) && $souv) {
                        setcookie("souv", $result['mail'], strtotime('+1 year'));
                    }elseif (is_bool($souv) && isset($_COOKIE['souv']) && $souv == false) {
                        if ($_COOKIE['souv'] == $mail) {
                            setcookie("souv", "", time() - 3600);
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
        public function addProfil ($mail, $mdp, $admin = null) {
            if (is_string($mail) == false || $mail == '') {
                return array(
                    'result' => false,
                    'text' => 'Il manque l\'adresse mail'
                );
            }elseif (strlen($mail) > 50) {
                return array(
                    'result' => false,
                    'text' => 'L\'addresse mail est trop long '
                );
            }elseif (strpos($mail, '@') === false || strpos($mail, ' ')) {
                return array(
                    'result' => false,
                    'text' => 'Se n\'est pas une addresse mail'
                );
            }elseif ($this->comparMail($mail)) {
                return array(
                    'result' => false,
                    'text' => 'Cette addresse mail est déja utiliser'
                );
            }else {
                if (is_string($mdp) == false || $mdp == '') {
                    return array(
                        'result' => false,
                        'text' => 'Il manque le mot de passe'
                    );
                }else {
                    if (is_null($admin)) {
                        $bdd = $this->_bdd;
                        $bdd = $bdd->co();

                        $req = $bdd->prepare('INSERT INTO `profil` (`id`, `mail`, `motDePasse`) VALUES (NULL, :mail, :mdp)');

                        $hash = password_hash($mdp, PASSWORD_BCRYPT);

                        if ($hash) {
                            $valeurreq = array(
                                ':mail' => $mail,
                                ':mdp' => $hash
                            );

                            if ($req->execute($valeurreq)) {
                                $req->closecursor();
                                $bdd = null;

                                return array(
                                    'result' => true
                                );
                            }else {
                                $req->closecursor();
                                $bdd = null;

                                return array(
                                    'result' => false,
                                    'text' => 'Une erreur c\'est produit lors de l\'envoie a la base de donner'
                                );
                            }
                        }else {
                            $req->closecursor();
                            $bdd = null;

                            return array(
                                'result' => false,
                                'text' => 'Une erreur c\'est produit lors du hashag de votre mot de passe'
                            );
                        }
                    }elseif (is_bool($admin)) {
                        $bdd = $this->_bdd;
                        $bdd = $bdd->co();

                        $req = $bdd->prepare('INSERT INTO `profil` (`id`, `mail`, `motDePasse`, `admin`) VALUES (NULL, :mail, :mdp, :admin)');

                        $hash = password_hash($mdp, PASSWORD_BCRYPT);

                        if ($hash) {
                            if ($admin) {
                                $admin = 1;
                            }else {
                                $admin = 0;
                            }

                            $valeurreq = array(
                                ':mail' => $mail,
                                ':mdp' => $hash,
                                ':admin' => $admin
                            );

                            if ($req->execute($valeurreq)) {
                                $req->closecursor();
                                $bdd = null;

                                return array(
                                    'result' => true
                                );
                            }else {
                                $req->closecursor();
                                $bdd = null;

                                return array(
                                    'result' => false,
                                    'text' => 'Une erreur c\'est produit lors de l\'envoie a la base de donner'
                                );
                            }
                        }else {
                            $req->closecursor();
                            $bdd = null;

                            return array(
                                'result' => false,
                                'text' => 'Une erreur c\'est produit lors du hashag de votre mot de passe'
                            );
                        }
                    }else {
                        return array(
                            'result' => false,
                            'text' => 'Une erreur c\'est produit sur la variable admin'
                        );
                    }
                }
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
    }
?>