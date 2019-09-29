<?php
    require_once('../model/entreprise.php');

    $entrepriseHead = new entreprise;

    $titreHead = $entrepriseHead->titre();
    $phraseHead = $entrepriseHead->phrase();
    $descriptionHead = $entrepriseHead->description();

    if ($phraseHead) {
        $titreHead .= " | " . $phraseHead;
    }

    $array = explode('/' ,$_SERVER['PHP_SELF']);

    if (end($array) == 'acceuil.php' || end($array) == 'menu.php' || end($array) == 'connexion.php') {
        $indexHead = true;
    }else {
        $indexHead = false;
    }
?>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $titreHead ?></title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="apple-touch-icon" sizes="180x180" href="src/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="src/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="src/favicon/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="src/favicon/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="src/favicon/favicon-16x16.png">
    <link rel="manifest" href="src/favicon/site.webmanifest">
    <link rel="mask-icon" href="src/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="src/favicon/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Chez maman">
    <meta name="application-name" content="Chez maman">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="src/favicon/browserconfig.xml">
    <meta name="theme-color" content="">
    <?php if ($descriptionHead) { ?>
        <meta name="description" content="<?= $descriptionHead ?>" />
    <?php } ?>
    <?php if ($indexHead) { ?>
        <meta name="robots" content="index">
    <?php }else { ?>
        <meta name="robots" content="noindex">
    <?php } ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/source_colorconvertor.js"></script>
    <script src="js/navigateur_color.js"></script>