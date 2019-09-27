<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php include_once('../view/head.php') ?>
    </head>
    <body id="menugestionproduit">
        <div id="message" class='hidden'>
            <span class="text"></span>
            <button>
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php include_once('../view/navadmin.php') ?>

        <main>
            <?php
                if (isset($menuData) && is_array($menuData) && $menuData){
                    $titreMenu = $menuData['titre'];

                    if (file_exists('src/menu/' . $menuData['image'])) {
                        $imgMenu = $menuData['image'];
                    }else {
                        $imgMenu = 'default.svg';
                    }
                }else {
                    $titreMenu = 'inconue';
                    $imgMenu = 'default.svg';
                }
            ?>
            <h1>Liste de produit du menu <?= htmlspecialchars($titreMenu) ?></h1>
            <article class="listeproduit">
                <h2>
                    <img src="src/menu/<?= htmlspecialchars($imgMenu) ?>" alt="Logo du menu <?= htmlspecialchars($titreMenu) ?>">
                </h2>
                <ul>
                    <?php
                        if (isset($produitHtml) && $produitHtml) {
                            echo $produitHtml;
                        }
                    ?>
                </ul>
            </article>
            <article class="formproduit">
                <h2>formumaire ajout de produit</h2>
                <form action="#" id="formproduit" method="post" ENCTYPE="multipart/form-data">
                    <?php if (isset($id)) { ?>
                        <input type="hidden" name="idmenu" value="<?= $id ?>">
                    <?php } ?>
                    <img class="preview">
                    <input type="file" name="image" id="image" data-preview=".preview" required>
                    <input type="text" name="titre" id="titre" placeholder="Titre" required>
                    <textarea name="text" id="text" placeholder="Text"></textarea>
                    <input type="text" name="prix" id="prix" placeholder="Prix" pattern="\d+(,|.\d{1,2})?">
                    <input type="submit" value="envoyer">
                </form>
            </article>
            <script src="js/ajax/produit.js"></script>
        </main>
    </body>
</html>