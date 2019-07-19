<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once('head.php') ?>
    <style type="text/css">
        img {
            height: 5vh;
        }
    </style>
</head>
<body id="gestioservice">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php include_once('navadmin.php') ?>

    <main>
        <h1>service</h1>
        <section class="services">
            <h2>services</h2>
            <?php if (isset($services) && $services) { ?>
                <ul>
                    <?php foreach ($services as $value) { ?>
                        <li id="<?= $value['id'] ?>" class="service">
                            <div class="image">
                                <img src="src/services/<?= $value['image'] ?>" alt="image de <?= $value['titre'] ?>">
                                <button id="modimg" value="<?= $value['id'] ?>">Modifier</button>
                            </div>
                            <div class="txt">
                                <p class="text">
                                    <?= $value['text'] ?>
                                </p>
                                <button id="modtext" value="<?= $value['id'] ?>">Modifier</button>
                            </div>
                            <button id="supservice" value="<?= $value['id'] ?>">
                                <i class="fas fa-times"></i>
                            </button>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
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