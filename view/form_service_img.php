<?php
    if (isset($id) && is_int($id)) {
?>
    <div id="form">
        <form action="#" method="post" id="formserviceimg" ENCTYPE="multipart/form-data" value="<?= $id ?>">
            <button type='button' id="fermer">
                <i class="fas fa-times"></i>
            </button>
            <input type="file" name="img" id="img" required>
            <input type="submit" value="envoyer">
        </form>
    </div>
<?php 
    }else {
        echo 'false id';
    }
?>