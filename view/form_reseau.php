<?php
    if (isset($reseau) && is_array($reseau) && $reseau) {
        if (file_exists('src/reseaux/' . $reseau['image']) != true) {
            $reseau['image'] = 'default.svg';
        }
?>

<div id="form">
    <form action="#" method="post" id="formmodreseau" ENCTYPE="multipart/form-data">
            <button type='button' id="fermer">
                <i class="fas fa-times"></i>
            </button>
            <input type="hidden" name="id" value="<?= htmlspecialchars($reseau['id']) ?>">
            <img class="previewmod" src="src/reseaux/<?= htmlspecialchars($reseau['image']) ?>">
            <input type="file" name="image" id="image" data-preview=".previewmod">
            <input type="text" name="titre" id="titre" placeholder="Titre" value="<?= htmlspecialchars($reseau['titre']) ?>" required>
            <input type="url" name="url" id="url" placeholder="Url" value="<?= htmlspecialchars($reseau['url']) ?>" required>
            <input type="submit" value="Envoyer">
    </form>
</div>

<?php
    }else {
        echo 'false';
    }
?>