<header id="header">
        <video autoplay loop muted>
            <?php 
                if (isset($video) && is_array($video) == false) {
            ?>

                <source src="src/video/<?= htmlspecialchars($video) ?>" type="video/mp4">

            <?php
                }
            ?>

            <source src="src/video/default.webm" type="video/webm">
            <source src="src/video/default.ogg" type="video/ogg">
            <source src="src/video/default.mp4" type="video/mp4">
        </video>
        <section class="info">
            <h4>info</h4>
            <h1>
                <?php 
                    if (isset($logo) && $logo && isset($titre) && $titre) {
                ?>

                <img src="src/logo/<?= htmlspecialchars($logo) ?>" alt="<?= htmlspecialchars($titre) ?>">

                <?php
                    }elseif (isset($logo) && $logo) {
                ?>

                <img src="src/logo/<?= htmlspecialchars($logo) ?>" alt="Logo">

                <?php
                    }elseif (isset($titre) && $titre) {
                        echo htmlspecialchars($titre);
                    }
                ?>
                
            </h1>
                <?php
                    if (isset($phrase) && $phrase) {
                ?>

                <h2>
                        <?= htmlspecialchars($phrase) ?>
                </h2>

                <?php
                    }
                ?>
        </section>
    </header>