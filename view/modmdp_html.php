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
            if ($modmdp['result']) {
                $modmdp['text'] = "Un mail vous a été envoyer avec votre nouveaux mot de passe";
            }
    ?>

        <div id="message" class='<?= var_export($modmdp['result']) ?>'>
            <span class="text"><?= htmlspecialchars($modmdp['text']) ?></span>
            <button>
                <i class="fas fa-times"></i>
            </button>
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
    <script src="js/conect.js"></script>
</body>
</html>