<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php include_once('../view/head.php') ?>
        <style type="text/css">
            img {
                height: 5vh;
            }
        </style>
    </head>
    <body id="menugestion">
        <div id="message" class='hidden'>
            <span class="text"></span>
            <button>
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php include_once('../view/navadmin.php') ?>

        <main>
            <h1>Gestion du menu</h1>
            <article class="listemenu">
                <h2>liste menu</h2>
                <ul>
                    <?php
                        if (isset($menuGestion) && $menuGestion) {
                            echo $menuGestion;
                        }
                    ?>
                </ul>
            </article>
            <article class="formmenu">
                <h2>formumaire ajout de menu</h2>
                <form action="#" id="formmenu" method="post" ENCTYPE="multipart/form-data">
                    <img class="preview">
                    <input type="text" name="titre" id="titre" placeholder="Titre" required>
                    <input type="file" name="image" id="image" data-preview=".preview" required>
                    <input type="submit" value="envoyer">
                </form>
            </article>
        </main>
        <script src="js/ajax/menuMod.js"></script>
    </body>
</html>