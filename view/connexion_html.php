<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('head.php'); ?>
</head>
<body id="connexion">
    <?php
        if (isset($connexion) && $connexion == false) {
    ?>

        <div id="erreur">
            Le mot de passe ou l'addresse mail est mauvais
        </div>

    <?php
        }
    ?>
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
            <input type="email" name="mail" id="mail" placeholder="Email" <?= $mailText   ?> required>
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

        <a href="../index.php?page=modmdp">
            Mot de passe oublier
        </a>
    </main>
</body>
</html>