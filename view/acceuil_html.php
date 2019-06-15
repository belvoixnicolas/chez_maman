<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Chez maman Restaurant brunch</title>
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
    <meta name="theme-color" content="#ffffff">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body id="index">
    <?php include('navbar.php') ?>
    <?php include('header.php') ?>
    <main>
        <?php
            if (isset($description) && $description) {
                include('description.php');
            }
        ?>
        <?php include('commentaire.php') ?>
        <?php 
            if (isset($services) && $services) {
                include('service.php');
            }
         ?>
        <?php include('horraireLocalisation.php') ?>
    </main>
    <footer>
        <p id="pc">Copyright 2019 &copy; Chez maman | Conception &amp; Réalisation : <a href="http://www.nicolas-belvoix.fr" target="_blank" rel="noopener noreferrer">nicolas-belvoix.fr</a></p>
        <p id="tel" class="none">
            <span>
                Copyright 2019 &copy; Chez maman
            </span>
            <span>
                Conception &amp; Réalisation : <a href="http://www.nicolas-belvoix.fr" target="_blank" rel="noopener noreferrer">nicolas-belvoix.fr</a>
            </span>
        </p>
        <a href="#">Connexion</a>
    </footer>
    <script src="js/navbar.js"></script>
</body>
</html>