<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include('head.php');
    ?>
</head>
<body id="menu">
    <?php include('../view/navbar.php'); ?>
    <main>
        <?php
            if (isset($menus) && $menus) {
                include('section_menu.php');
            }
        ?>
    </main>
    <?php include('footer.php'); ?>
    <script src="js/navbar.js"></script>
</body>
</html>