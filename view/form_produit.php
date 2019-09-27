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
            <input type="hidden" name="idproduit" value="<?= htmlspecialchars($produit['id']) ?>">
            <input type="hidden" name="idmenu" value="<?= htmlspecialchars($produit['id_menu']) ?>">
            <img class="previewmod" src="src/produit/<?= htmlspecialchars($produit['image']) ?>">
            <input type="file" name="image" id="image" data-preview=".previewmod">
            <input type="text" name="titre" id="titre" placeholder="Titre" value="<?= htmlspecialchars($produit['titre']) ?>" required>
            <textarea name="text" id="text" placeholder="Text"><?= $produit['text'] ?></textarea>
            <input type="text" name="prix" id="prix" placeholder="Prix" value="<?= htmlspecialchars($produit['prix']) ?>" pattern="\d+(,|.\d{1,2})?">
            <input type="submit" value="envoyer">
        </form>
    </div>
<?php 
    }else {
        echo 'false id';
    }
?>