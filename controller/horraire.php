<?php
    session_start();

    require_once('../model/profil.php');
    require_once('../model/horraire.php');

    $profil = new profil;
    
    if (isset($_SESSION['profil']) && is_array($_SESSION['profil']) && $_SESSION['profil']['admin'] == 1) {
        $verifProfil = $profil->verifProfil($_SESSION['profil']);

        if ($verifProfil == false) {
            unset($_SESSION['profil']);

            header('Location: ../index.php');
            exit();
        }else {
            $horraire = new horraire;

            $horraires = $horraire->horraire();

            for ($i=0; $i < count($horraires); $i++) { 
                foreach ($horraires[$i] as $key => $value) {
                    if ($key != 'jour') {
                        if (is_null($value)) {
                            $horraires[$i][$key] = '00:00';
                        }else {
                            $val = explode(':', $value);

                            $horraires[$i][$key] = $val[0] . ':' . $val[1];
                        }
                    }
                }
            }

            include_once('../view/horraire_html.php');
        }
    }else {
        unset($_SESSION['profil']);
            
        header('Location: ../index.php');
        exit();
    }
?>