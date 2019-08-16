<?php
    if (isset($_POST['mdp'])) {
        $mdp = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>hash mot de passe</title>
</head>
<body>
    <h1>Hashage de mot de passe</h1>

    <?php if (isset($mdp)) { ?>

        <h2>Le hashage est : <?= $mdp ?></h2>

    <?php } ?>

    <form action="#" method="post">
        <input type="text" name="mdp" required>
        <input type="submit" value="Hasher">
    </form>
</body>
</html>