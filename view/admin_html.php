<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include('../view/head.php');
    ?>
</head>
<body id="admin">
    <nav>
        <ul>
            <li>
                <a href="../index.php?page=gestion" id="gestion">
                    Gestion
                </a>
            </li>
            <?php
                if (isset($profiluser['admin']) && $profiluser['admin'] == 1) {
            ?>

                <li>
                    <a href="../index.php?page=description" id="description">
                        Description
                    </a>
                </li>

            <?php
                }
            ?>
            <li>
                <a href="../index.php?page=avie" id="avis">
                    Avis
                </a>
            </li>
            <?php
                if (isset($profiluser['admin']) && $profiluser['admin'] == 1) {
            ?>

                <li>
                    <a href="../index.php?page=service" id="service">
                        Service
                    </a>
                </li>

            <?php
                }
            ?>
            <li>
                <a href="../index.php?page=menugestion" id="menu">
                    Menu
                </a>
            </li>
            <?php
                if (isset($profiluser['admin']) && $profiluser['admin'] == 1) {
            ?>

                <li>
                    <a href="../index.php?page=horraire" id="horraires">
                        Horraires
                    </a>
                </li>

            <?php
                }
            ?>
        </ul>
    </nav>
</body>
</html>