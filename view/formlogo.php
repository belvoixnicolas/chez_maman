        <section id="sectionformlogo">
            <h2>
                logo
            </h2>
            <?php
                if (isset($logo, $titre)) {
                    if ($logo == false) {
                        $logo = 'default.svg';
                    }
                    if ($titre == false) {
                        $titre = 'titre';
                    }
            ?>

                <img src="src/logo/<?= $logo ?>" alt="Logo de <?= $titre ?>">

            <?php
                }else {
            ?>

                <img src="src/logo/default.svg" alt="Logo du site">

            <?php
                }
            ?>

            <form action="#" method="post" id="formlogo">
                <input type="file" name="logo" id="logo">

                <input type="submit" value="envoyer">
            </form>
            <script src="js/ajax/formlogo.js"></script>
        </section>