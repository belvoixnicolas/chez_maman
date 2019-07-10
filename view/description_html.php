<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once('head.php') ?>
</head>
<body id="gestiondescription">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php include_once('navadmin.php') ?>

    <main>
        <h1>description</h1>

        <form action="#" method="post" id="formdescription">
            <textarea name="description" placeholder="Description" required><?php
                    if (isset($descript) && $descript) {
                        echo $descript;
                    }
                ?></textarea>
            
            <?php 
                if (isset($descript) && $descript) {
            ?>
                <button type="button" id="supdesciption">Suprimer</button>
            <?php
                }
            ?>
            <input type="submit" value="Envoyer">
        </form>
        <script src="js/ajax/formdescription.js"></script>
    </main>
</body>
</html>