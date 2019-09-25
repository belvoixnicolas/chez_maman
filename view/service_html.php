<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once('../view/head.php') ?>
</head>
<body id="gestionservice">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php include_once('../view/navadmin.php') ?>

    <main>
        <h1>service</h1>
        <section class="services">
            <h2>services</h2>
                <ul>
                    <?php 
                        if (isset($services) && $services) {
                            foreach ($services as $value) { 
                    ?>
                        <li id="<?= htmlspecialchars($value['id']) ?>" class="service">
                            <div class="image">
                                <img src="src/services/<?= htmlspecialchars($value['image']) ?>" alt="image de <?= htmlspecialchars($value['titre']) ?>">
                                <button id="modimg" value="<?= htmlspecialchars($value['id']) ?>">Modifier</button>
                            </div>
                            <div class="txt">
                                <p class="text">
                                    <span>
                                        <?= nl2br(htmlspecialchars($value['text'])) ?>
                                    </span>
                                </p>
                                <button id="modtext" value="<?= htmlspecialchars($value['id']) ?>">Modifier</button>
                            </div>
                            <button id="supservice" value="<?= htmlspecialchars($value['id']) ?>">
                                <i class="fas fa-times"></i>
                            </button>
                        </li>
                    <?php
                            }
                        } 
                    ?>
                </ul>
        </section>
        <section class="formservice">
            <form action="#" id="formservice" method="post" ENCTYPE="multipart/form-data">
                <img class="preview">
                <input type="text" name="titre" id="titre" placeholder="Titre" required>
                <input type="file" name="image" id="image" data-preview=".preview" required>
                <textarea name="txt" id="txt" placeholder="Text" required></textarea>
                <input type="submit" value="envoyer">
            </form>
        </section>
    </main>
    <script src="js/ajax/servicemod.js"></script>
</body>
</html>