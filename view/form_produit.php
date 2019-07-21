<?php
    if (isset($produit) && is_array($produit)) {
        if (file_exists('src/produit/' . $produit['image']) == false) {
            $produit['image'] = 'default.svg';
        }
?>
    <div id="form">
        <form action="#" method="post" id="formproduitmod" ENCTYPE="multipart/form-data">
            <button type='button' id="fermer">
                <i class="fas fa-times"></i>
            </button>
            <input type="hidden" name="idproduit" value="<?= $produit['id'] ?>">
            <input type="hidden" name="idmenu" value="<?= $produit['id_menu'] ?>">
            <img class="previewmod" src="src/produit/<?= $produit['image'] ?>">
            <input type="file" name="image" id="image" data-preview=".previewmod">
            <input type="text" name="titre" id="titre" placeholder="Titre" value="<?= $produit['titre'] ?>" required>
            <textarea name="text" id="text" placeholder="Text"><?= $produit['text'] ?></textarea>
            <input type="number" name="prix" id="prix" placeholder="Prix" value="<?= $produit['prix'] ?>" step="0.01">
            <input type="submit" value="envoyer">
        </form>
    </div>
<?php 
    }else {
        echo 'false id';
    }
?>