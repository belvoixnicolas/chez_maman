<?php
    if (isset($dataMenu) && is_array($dataMenu)) {
?>
    <div id="form">
        <form action="#" id="formmenumod" method="post" ENCTYPE="multipart/form-data" value="<?= $dataMenu['id'] ?>">
            <button type='button' id="fermer">
                <i class="fas fa-times"></i>
            </button>
            <img class="previewmod" src="src/menu/<?= $dataMenu['image'] ?>">
            <input type="text" name="titre" id="titre" placeholder="Titre" value="<?= $dataMenu['titre'] ?>" required>
            <input type="file" name="image" id="image" data-preview=".previewmod" required>
            <input type="submit" value="envoyer">
        </form>
    </div>
<?php 
    }else {
        echo 'false id';
    }
?>