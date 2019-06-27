<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('head.php'); ?>
</head>
<body id="connexion">
    <nav>
        <a href="../index.php?page=index"><i class="fas fa-chevron-left"></i></a>
    </nav>
    <main>
        <h1>connexion</h1>
        <form action="#" method="post">
            <?php
                if (isset($mail) && $mail) {
                    $mailText = 'value="' . $mail . '"';
                }else {
                    $mailText = '';
                }
            ?>
            <input type="text" name="mail" id="mail" placeholder="Email" <?= $mailText   ?> required>
            <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>
            
            <?php
                if (isset($mail) == false || $mail == false) {
            ?>
                <fieldset>
                    <input type="checkbox" name="souv" id="souv">
                    <label for="souv">
                        Se souvenir de moi
                    </label>
                </fieldset>
            <?php
                }
            ?>

            <input type="submit" value="Connexion">
        </form>

        <a href="#">
            Mot de passe oublier
        </a>
    </main>
</body>
</html>