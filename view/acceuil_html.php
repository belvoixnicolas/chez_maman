<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('head.php') ?>
</head>
<body id="index">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
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
    <?php include('footer.php') ?>
    <script src="js/navbar.js"></script>
</body>
</html>