<section id="sectionformtitre">
    <h2>
        Titre
    </h2>

    <form action="#" method="post" id='formtitre'>
        <?php
            $val = "";

            if (isset($titre) && $titre && $titre != "titre") {
                $val = 'value="' . $titre . '"';
            }
        ?>
        <input type="text" name="titre" id="titre" placeholder="Entrer le nom du site" <?= $val ?> required>

        <input type="submit" value="envoyer">
    </form>
    <script src="js/ajax/formtitre.js"></script>
</section>