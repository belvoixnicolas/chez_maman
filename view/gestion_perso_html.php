<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
        include_once('../view/head.php');
    ?>
</head>
<body id="gestionPerso">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php
        include_once('../view/navadmin.php');
    ?>
    <main>
        <form action="#" method="post" id="formident">
            <fieldset>
                <legend>
                    changer mail
                </legend>

                <input type="email" name="mail" id="mail" placeholder="changer d'email">
                <input type="email" name="verifmail" id="verifmail" placeholder="réécrivez l'email" disabled>
            </fieldset>
            <fieldset>
                <legend>
                    changer de mot de passe
                </legend>

                <input type="password" name="pwd" id="pwd" placeholder="changer de mot de passe">
                <input type="password" name="verifpwd" id="verifpwd" placeholder="réécrivez votre mot de passe" disabled>
            </fieldset>

            <input type="submit" value="Changer">
        </form>
        <script src="js/ajax/modif_ident.js"></script>
    </main>
</body>
</html>