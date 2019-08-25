<section id="sectionreseau">
    <h2>reseaux</h2>

    <ul>
        <?php 
            if (isset($reseaux, $model) && $reseaux && $model) {
                error_reporting(0);

                foreach ($reseaux as $value) {
                    if (is_null($value['url'])) {
                        $class = 'class="erreur"';
                        $text = "(Aucun lien)";
                    }elseif (file($value['url']) == false) {
                        $class = 'class="erreur"';
                        $text = "(Lien mort)";
                    }else {
                        $class = '';
                        $text = '';
                    }

                    $construction = implode($model);

                    $construction = str_replace('%id%', htmlspecialchars($value['id']), $construction);
                    $construction = str_replace('%img%', htmlspecialchars($value['image']), $construction);
                    $construction = str_replace('%titre%', htmlspecialchars($value['titre']), $construction);
                    $construction = str_replace('%url%', htmlspecialchars($value['url']), $construction);
                    $construction = str_replace('%txt%', $text, $construction);
                    $construction = str_replace('%class%', $class, $construction);
                    
                    echo $construction;
                }
            } 
        ?>
    </ul>

    <form action="#" method="post" id="formreseau" ENCTYPE="multipart/form-data">
            <img class="preview">
            <input type="file" name="image" id="image" data-preview=".preview" required>
            <input type="text" name="titre" id="titre" placeholder="Titre" required>
            <input type="url" name="url" id="url" placeholder="Url" required>
            <input type="submit" value="Envoyer">
    </form>
    <script src="js/ajax/modreseau.js"></script>
</section>