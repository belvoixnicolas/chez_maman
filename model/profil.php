<?php
    require_once('bdd.php');
    require_once('entreprise.php');

    class profil {
        private $_bdd;
        private $_entreprise;

        public function __construct () {
            $bdd = new bdd;
            $this->_bdd = $bdd;

            $entreprise = new entreprise;
            $this->_entreprise = $entreprise;
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

        public function profils ($id, $list = null) {
            if (is_int($id) && is_null($list) == false && $list == true && $id > 0) {
                $bdd = $this->_bdd;
                $bdd = $bdd->co();

                $req = $bdd->query("SELECT id, nom, mail, admin FROM profil WHERE id != 1 AND id != $id");

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

        private function mail ($array) {
            if (isset($array, $array['type']) && is_array($array)) {
                switch ($array['type']) {
                    case 'perdue':
                        if (isset($array['to'], $array['sujet'], $array['data'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_perdu.txt'));
                            $text = str_replace('%mdp%', $array['data'], $text);

                            $bodyMail = implode('', file('../view/mail_body_perdu.html'));
                            $bodyMail = str_replace('%mdp%', $array['data'], $bodyMail);

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/img/logo.png', $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;

                    case 'erreur_mdp':
                        if (isset($array['to'], $array['sujet'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_erreurPerdu.txt'));

                            $bodyMail = implode('', file('../view/mail_body_erreurPerdu.html'));

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/img/logo.png', $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire ou le sujet'
                            );
                        }
                        break;

                    case 'adProfil':
                        if (isset($array['to'], $array['sujet'], $array['data'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_addprofil.txt'));
                            $text = str_replace('%mail%', $array['data']['mail'], $text);
                            $text = str_replace('%mdp%', $array['data']['mdp'], $text);

                            $bodyMail = implode('', file('../view/mail_body_addprofil.html'));
                            $bodyMail = str_replace('%mail%', $array['data']['mail'], $bodyMail);
                            $bodyMail = str_replace('%mdp%', $array['data']['mdp'], $bodyMail);

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/img/logo.png', $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;

                    case "supprofil":
                        if (isset($array['to'], $array['sujet'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_supprofil.txt'));

                            $bodyMail = implode('', file('../view/mail_body_supprofil.html'));

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/img/logo.png', $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;

                    case 'admin':
                        if (isset($array['to'], $array['sujet'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_admin.txt'));

                            $bodyMail = implode('', file('../view/mail_body_admin.html'));

                            $entreprise = $this->_entreprise;
                            if ($result = $entreprise->logo()) {
                                $logo = $result;
                            }else {
                                $logo = 'default.svg';
                            }

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/logo/' . $logo, $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;

                    case 'supadmin':
                        if (isset($array['to'], $array['sujet'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_supadmin.txt'));

                            $bodyMail = implode('', file('../view/mail_body_supadmin.html'));

                            $entreprise = $this->_entreprise;
                            if ($result = $entreprise->logo()) {
                                $logo = $result;
                            }else {
                                $logo = 'default.svg';
                            }

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/logo/' . $logo, $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;

                    case 'modmdp':
                        if (isset($array['to'], $array['sujet'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_modmdp.txt'));

                            $bodyMail = implode('', file('../view/mail_body_modmdp.html'));

                            $entreprise = $this->_entreprise;
                            if ($result = $entreprise->logo()) {
                                $logo = $result;
                            }else {
                                $logo = 'default.svg';
                            }

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/logo/' . $logo, $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;

                    case 'modmail':
                        if (isset($array['to'], $array['sujet'], $array['data'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_modmail.txt'));
                            $text = str_replace('%oldMail%', $array['data']['old'], $text);
                            $text = str_replace('%newMail%', $array['data']['new'], $text);

                            $bodyMail = implode('', file('../view/mail_body_modmail.html'));
                            $bodyMail = str_replace('%oldMail%', $array['data']['old'], $bodyMail);
                            $bodyMail = str_replace('%newMail%', $array['data']['new'], $bodyMail);

                            $entreprise = $this->_entreprise;
                            if ($result = $entreprise->logo()) {
                                $logo = $result;
                            }else {
                                $logo = 'default.svg';
                            }

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/logo/' . $logo, $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;

                    case 'modmailold':
                        if (isset($array['to'], $array['sujet'], $array['data'])) {
                            $to = $array['to'];
                            $sujet = $array['sujet'];

                            $text = implode('', file('../view/mail_modmailold.txt'));
                            $text = str_replace('%newMail%', $array['data'], $text);

                            $bodyMail = implode('', file('../view/mail_body_modmailold.html'));
                            $bodyMail = str_replace('%newMail%', $array['data'], $bodyMail);

                            $entreprise = $this->_entreprise;
                            if ($result = $entreprise->logo()) {
                                $logo = $result;
                            }else {
                                $logo = 'default.svg';
                            }

                            $html = implode('', file('../view/mail_base.html'));
                            $html = str_replace('%url%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/connexion.php', $html);
                            $html = str_replace('%urlimg%', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/controller/src/logo/' . $logo, $html);
                            $html = str_replace('%txt%', $bodyMail, $html);
                        }else {
                            return array(
                                'result' => false,
                                'text' => 'Il manque le destinataire, le sujet ou la data'
                            );
                        }
                        break;
                    
                    default:
                        return array(
                            'result' => false,
                            'text' => 'Le type de mail n\'est pas reconnue'
                        );
                        break;
                }

                $site = $_SERVER['HTTP_HOST'];
                $from = "webmaster@chezmaman.com";
                $nom = "Chez maman";

                $from = $nom." <".$from.">";

                $limite = "_----------=_parties_".md5(uniqid (rand()));

                $header  = "Reply-to: ".$from."\n";
                $header .= "From: ".$from."\n";
                $header .= "X-Sender: <".$site.">\n";
                $header .= "X-Mailer: PHP\n";
                $header .= "X-auth-smtp-user: ".$from." \n";
                $header .= "X-abuse-contact: ".$from." \n";
                $header .= "Date: ".date("D, j M Y G:i:s O")."\n";
                $header .= "MIME-Version: 1.0\n";
                $header .= "Content-Type: multipart/alternative; boundary=\"".$limite."\"";

                $message = "";

                $message .= "--".$limite."\n";
                $message .= "Content-Type: text/plain\n";
                $message .= "charset=\"utf-8\"\n";
                $message .= "Content-Transfer-Encoding: 8bit\n\n";
                $message .= $text;

                $message .= "\n\n--".$limite."\n";
                $message .= "Content-Type: text/html; ";
                $message .= "charset=\"utf-8\"; ";
                $message .= "Content-Transfer-Encoding: 8bit;\n\n";
                $message .= $html;

                $message .= "\n--".$limite."--";

                if (mail($to, $sujet, $message, $header)) {
                    return array(
                        'result' => true,
                        'text' => 'Le mail est envoyer'
                    );
                }else {
                    return array(
                        'result' => false,
                        'text' => 'Le mail n\'a pas été envoyé'
                    );
                }
            }else {
                return array(
                    'result' => false,
                    'text' => 'Il manque des valeurs'
                );
            }
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

                    $evoiMail = $this->mail(array(
                        "type" => 'adProfil',
                        "to" => $mail,
                        "sujet" => "Vous êtes devenue utilisateur",
                        "data" => array(
                            "mail" => $mail,
                            "mdp" => $mdp
                        )
                    ));

                    if ($evoiMail['result']) {
                        if ($req->execute($array)) {
                            $req->closecursor();
                            $id = $bdd->lastInsertId();
                            $bdd = null;

                            return array(
                                'result' => true,
                                'text' => 'Le nouvelle utilisateur a était ajouter',
                                'html' => '<tr><td class="nom">' . $nom . '</td><td class="mail">' . $mail . '</td><td class="admin"><button id="modifprofil" name="id" value="' . $id . '"><i class="far fa-user"></i></button></td><td class="sup"><button id="supprofil" name="id" value="' . $id . '"><i class="fas fa-times"></i></button></td></tr>'
                            
                            );
                        }else {
                            $req->closecursor();
                            $bdd = null;

                            return array(
                                'result' => false,
                                'text' => 'Le nouvelle utilisateur n\'a pas put étre ajouter'
                            );
                        }
                    }else {
                        return $evoiMail;
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

                $oldMail = $this->profils((int)$id);

                if ($req->execute($array)) {
                    $req->closecursor();
                    $bdd = null;

                    $this->mail(array(
                        "type" => "modmailold",
                        "to" => $oldMail['mail'],
                        "sujet" => "Votre mail a été modifié",
                        "data" => $mail
                    ));

                    $this->mail(array(
                        "type" => "modmail",
                        "to" => $mail,
                        "sujet" => "Votre mail a été modifié",
                        "data" => array(
                            "old" => $oldMail['mail'],
                            "new" => $mail
                        )
                    ));

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
                    $profil = $this->profils((int)$id);
                    $mail = $this->mail(array(
                        "type" => "modmdp",
                        "to" => $profil["mail"],
                        "sujet" => "Votre mot de passe a été modifié"
                    ));

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
            }elseif (strtoupper($mail) == 'ADMIN@ADMIN') {
                return array(
                    'result' => false,
                    'text' => 'Ce compte ne peux pas étre modifier'
                );
            }else {
                $newmdp =  $this->mdpAleatoire();
                $newmdphash = password_hash($newmdp, PASSWORD_BCRYPT);

                $resultMail = $this->mail(array(
                    "type" => 'perdue',
                    "to" => $mail,
                    "sujet" => 'Nouveaux mot de passe',
                    "data" => $newmdp
                ));

                if ($resultMail['result']) {
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

                        $this->mail(array(
                            "type" => "erreur_mdp",
                            "to" => $mail,
                            "sujet" => 'Erreur de mot de passe'
                        ));

                        return array(
                            'result' => false,
                            'text' => 'Le mot de passe n\'a pas put étre envoyer a la base de donner'
                        );
                    }
                }else {
                    return $resultMail;
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

                        if ($profil['admin'] == 0) {
                            $this->mail(array(
                                "type" => "admin",
                                "to" => $profil['mail'],
                                "sujet" => "Vous êtes devenue administrateur"
                            ));
                        }else {
                            $this->mail(array(
                                "type" => "supadmin",
                                "to" => $profil['mail'],
                                "sujet" => "Vous n'êtes plus administrateur"
                            ));
                        }

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

                        if ($bollen) {
                            $this->mail(array(
                                "type" => "admin",
                                "to" => $this->profils($id)['mail'],
                                "sujet" => "Vous êtes devenue administrateur"
                            ));
                        }else {
                            $this->mail(array(
                                "type" => "supadmin",
                                "to" => $this->profils($id)['mail'],
                                "sujet" => "Vous n'êtes plus administrateur"
                            ));
                        }

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

                    $mail = $this->profils($id)['mail'];


                    if ($req->execute($array)) {
                        $req->closecursor();
                        $bdd = null;

                        $this->mail(array(
                            "type" => "supprofil",
                            "to" => $mail,
                            "sujet" => "Votre profil a été supprimé"
                        ));

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