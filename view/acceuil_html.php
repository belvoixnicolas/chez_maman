<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('../view/head.php') ?>
</head>
<body id="index">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php include('../view/navbar.php'); ?>
    <?php include('../view/header.php'); ?>
    <main>
        <?php
            if (isset($description) && $description) {
                include('../view/description.php');
            }
        ?>
        <?php include('../view/commentaire.php'); ?>
        <?php 
            if (isset($services) && $services) {
                include('../view/service.php');
            }
         ?>
        <?php include('../view/horraireLocalisation.php'); ?>
    </main>
    <?php include('../view/footer.php'); ?>
    <script src="js/navbar.js"></script>
</body>
</html>