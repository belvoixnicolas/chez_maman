<section id="sectionformphrase">
    <h2>
        Phrase
    </h2>

    <form action="#" method="post" id='formphrase'>
        <?php
            $val = "";

            if (isset($phrase) && $phrase) {
                $val = 'value="' . htmlspecialchars($phrase) . '"';
            }
        ?>

        <!-- laisser vide supprimer -->
        <input type="text" name="phrase" id="phrase" placeholder="Phrase d'accroche" <?= $val ?>>

        <input type="submit" value="envoyer">
    </form>
    <script src="js/ajax/formphrase.js"></script>
</section>