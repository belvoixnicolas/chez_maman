<section id="sectionformtel">
    <h2>
        telephone
    </h2>

    <form action="#" method="post" id='formtel'>
        <?php
            $val = "";

            if (isset($tel) && $tel) {
                $val = 'value="' . htmlspecialchars($tel) . '"';
            }
        ?>

        <!-- laisser vide suprimer -->
        <input type="tel" name="tel" id="tel" placeholder="Entrer un numéro de téléphone" <?= $val ?>>
    
        <input type="submit" value="envoyer">
    </form>
    <script src="js/ajax/formtel.js"></script>
</section>