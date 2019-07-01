<section id="sectionformadresse">
    <h2>
        adresse
    </h2>

    <form action="#" method="post" id='formadresse'>
        <?php
            $nbrue = "";
            $rue = "";
            $ville = "";
            $cp = "";

            if (isset($address) && is_array($address) && $address) {
                $nbrue = 'value="' . $address['numero'] . '"';
                $rue = 'value="' . $address['rue'] . '"';
                $ville = 'value="' . $address['ville'] . '"';
                $cp = 'value="' . $address['cp'] . '"';
            }
        ?>

        <input type="number" name="nrue" id="nrue" placeholder="N° de rue" <?= $nbrue ?> required>
        <input type="text" name="rue" id="rue" placeholder="Rue" <?= $rue ?> required>
        <input type="text" name="ville" id="ville" placeholder="Ville" <?= $ville ?> required>
        <input type="number" name="cp" id="cp" placeholder="CP" <?= $cp ?> required>
        
        <?php
            if (isset($address) && is_array($address) && $address) {
        ?>

            <input type="button" id='sup' value="Suprimer">

        <?php
            }
        ?>
        <input type="submit" value="envoyer">
    </form>
    <script src="js/ajax/formadresse.js"></script>
</section>