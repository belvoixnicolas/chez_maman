<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include('../view/head.php');
    ?>
</head>
<body id="menu">
    <?php include('../view/navbar.php'); ?>
    <main>
        <?php
            if (isset($menus) && $menus) {
                include('../view/section_menu.php');
            }
        ?>
    </main>
    <?php include('../view/footer.php'); ?>
    <script src="js/navbar.js"></script>
</body>
</html>