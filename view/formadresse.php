<section id="sectionformadresse">
    <h2>
        adresse
    </h2>

    <form action="#" method="post" id='formadresse'>
        <?php
            $val = "";

            if (isset($phrase) && $phrase) {
                $val = 'value="' . $phrase . '"';
            }
        ?>

        <!-- laisser vide suprimer -->
        <input type="text" name="phrase" id="phrase" placeholder="Entrer un slogan" <?= $val ?>>

        <input type="submit" value="envoyer">
    </form>
    <!-- <script src="js/ajax/formadresse.js"></script> -->
</section>