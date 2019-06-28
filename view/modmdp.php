<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once('head.php');
    ?>
</head>
<body id="modmdp">
    <?php
        if (isset($modmdp)) {
    ?>

        <div id="erreur">
            <?php
                if ($modmdp['result']) {
                    echo 'Un mail vous à étais envoyer avec un nouveaux mot de passe';
                }else {
                    echo $modmdp['text'];
                }
            ?>
        </div>

    <?php
        }
    ?>
    <nav>
        <a href="../index.php?page=connexion"><i class="fas fa-chevron-left"></i></a>
    </nav>
    <main>
        <h1>
            Mot de passe oublier
        </h1>
        <form action="#" method="post">
            <input type="email" name="mail" id="mail" placeholder="Email" required>

            <input type="submit" value="Envoyer">
        </form>
    </main>
</body>
</html>