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
                $nbrue = 'value="' . htmlspecialchars($address['numero']) . '"';
                $rue = 'value="' . htmlspecialchars($address['rue']) . '"';
                $ville = 'value="' . htmlspecialchars($address['ville']) . '"';
                $cp = 'value="' . htmlspecialchars($address['cp']) . '"';
            }
        ?>

        <input type="number" name="nrue" id="nrue" placeholder="N° de rue" <?= $nbrue ?> required>
        <input type="text" name="rue" id="rue" placeholder="Rue" <?= $rue ?> required>
        <input type="text" name="ville" id="ville" placeholder="Ville" <?= $ville ?> required>
        <input type="number" name="cp" id="cp" placeholder="CP" <?= $cp ?> required>

        <div class="boutton">
            <?php
                if (isset($address) && is_array($address) && $address) {
                    $class = "class=\"\"";
                }else {
                    $class = "class=\"hidden\"";
                }
            ?>
            <input type="button" id='sup' value="supprimer" <?= $class ?>>
            <input type="submit" value="envoyer">
        </div>
    </form>
    <script src="js/ajax/formadresse.js"></script>
</section>