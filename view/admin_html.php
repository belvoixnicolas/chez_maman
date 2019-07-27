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
                <a href="../index.php?page=gestion">
                    Gestion
                </a>
            </li>
            <?php
                if (isset($profiluser['admin']) && $profiluser['admin'] == 1) {
            ?>

                <li>
                    <a href="../index.php?page=description">
                        Description
                    </a>
                </li>

            <?php
                }
            ?>
            <li>
                <a href="../index.php?page=avie">
                    Avis
                </a>
            </li>
            <?php
                if (isset($profiluser['admin']) && $profiluser['admin'] == 1) {
            ?>

                <li>
                    <a href="../index.php?page=service">
                        Service
                    </a>
                </li>

            <?php
                }
            ?>
            <li>
                <a href="../index.php?page=menugestion">
                    Menu
                </a>
            </li>
            <?php
                if (isset($profiluser['admin']) && $profiluser['admin'] == 1) {
            ?>

                <li>
                    <a href="../index.php?page=horraire">
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