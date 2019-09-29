<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include('../view/head.php'); ?>
</head>
<body id="connexion">
    <?php
        if (isset($connexion) && $connexion == false) {
    ?>

        <div id="message" class='false'>
            <span class="text">Le mot de passe ou l'addresse mail est mauvais</span>
            <button>
                <i class="fas fa-times"></i>
            </button>
        </div>

    <?php
        }else {
    ?>
        <div id="message" class='hidden'>
            <span class="text"></span>
            <button>
                <i class="fas fa-times"></i>
            </button>
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
                $checked = '';
                if (isset($mail)) {
                    $checked = 'checked';
                }
            ?>
                <fieldset>
                    <input type="checkbox" name="souv" id="souv" <?= $checked ?>>
                    <label for="souv">
                        Se souvenir de moi
                    </label>
                </fieldset>

            <input type="submit" value="Connexion">
        </form>

        <a href="../index.php?page=modmdp">
            Mot de passe oublier
        </a>
        <?= $_SERVER['HTTP_HOST'] ?>
    </main>
    <script src="js/conect.js"></script>
</body>
</html>