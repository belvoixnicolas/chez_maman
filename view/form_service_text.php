<?php
    if (isset($id) && is_int($id)) {
?>
    <div id="form">
        <form action="#" method="post" id="formservicetext" value="<?= $id ?>">
            <button type='button' id="fermer">
                <i class="fas fa-times"></i>
            </button>
            <textarea name="text" id="text" required><?php
                    if (isset($text) && $text) {
                        echo $text['text'];
                    }
            ?></textarea>
            <input type="submit" value="envoyer">
        </form>
    </div>
<?php 
    }else {
        echo 'false id';
    }
?>