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
<body id="gestionavie">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php include_once('../view/navadmin.php') ?>

    <main>
        <h1>avies</h1>

        <section class="nbfav">
            <p>
                <?php 
                    if (isset($compteur) && $compteur) {
                        $nb = $compteur;
                    }else {
                        $nb = 0;
                    }
                ?>
                <span><?= $nb ?></span> / 5
            </p>
        </section>
        <section class="avies">
            <?php   if (isset($avies) && $avies) { ?>
                <ul>

                    <?php 
                        $i = 1;
                        foreach ($avies as $value) { 
                            if ($value['afficher'] == 1) {
                                $value['afficher'] = 'fas fa-star';
                            }else {
                                $value['afficher'] = 'far fa-star';
                            }
                    ?>
                        <li class="avie">
                            <div class="img">
                                <img src="src/img/cupcake<?= $i ?>.svg" alt="Image avie">
                            </div>
                            <p class="text">
                                <?= nl2br(htmlspecialchars($value['text'])) ?>
                            </p>
                            <button id="buttonfavorie" value="<?= htmlspecialchars($value['id']) ?>"><i class="<?= htmlspecialchars($value['afficher']) ?>"></i></button>
                            <button id="buttonsup" value="<?= htmlspecialchars($value['id']) ?>">
                                <i class="fas fa-times"></i>
                            </button>
                        </li>
                    <?php 
                            if ( $i == 3) {
                                $i = 1;
                            }else {
                                $i++;
                            }
                        } 
                    ?>
                </ul>
                <script src="js/ajax/avie.js"></script>
            <?php   }else {   ?>
                <p>il y a aucun avie pour l'instant</p>
            <?php } ?>
        </section>
        <script src="js/ajax/formdescription.js"></script>
    </main>
</body>
</html>