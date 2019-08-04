<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once('../view/head.php');
    ?>
    <style type="text/css">
        img {
            height: 5vh;
        }
    </style>
</head>
<body id="gestionEntreprise">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php
        include_once('../view/navadmin.php');
    ?>
    <main>
    <?php
        include_once('../view/formlogo.php');
    ?>
    <?php
        include_once('../view/formtitre.php');
    ?>
    <?php
        include_once('../view/formphrase.php');
    ?>
    <?php
        include_once('../view/formvideo.php');
    ?>
    <?php
        include_once('../view/formtel.php');
    ?>
    <?php
        include_once('../view/formadresse.php');
    ?>
    <?php
        include_once('../view/formReseau.php');
    ?>
    <?php
        include_once('../view/profil.php');
    ?>
    </main>
</body>
</html>