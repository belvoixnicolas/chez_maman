<header id="header">
        <video autoplay loop muted>
            <?php 
                if (isset($video) && $video) {
            ?>

            <source src="src/video/<?= $video['webm'] ?>" type="video/webm">
            <source src="src/video/<?= $video['ogg'] ?>" type="video/ogg">
            <source src="src/video/<?= $video['mp4'] ?>" type="video/mp4">

            <?php
                }else {
            ?>

            <source src="src/video/default.webm" type="video/webm">
            <source src="src/video/default.ogg" type="video/ogg">
            <source src="src/video/default.mp4" type="video/mp4">

            <?php
                }
            ?>
        </video>
        <section class="info">
            <h4>info</h4>
            <h1>
                <?php 
                    if (isset($logo) && $logo && isset($titre) && $titre) {
                ?>

                <img src="src/logo/<?= $logo?>" alt="<?= $titre ?>">

                <?php
                    }elseif (isset($logo) && $logo) {
                ?>

                <img src="src/logo/<?= $logo?>" alt="Logo">

                <?php
                    }elseif (isset($titre) && $titre) {
                        echo $titre;
                    }
                ?>
                
            </h1>
                <?php
                    if (isset($phrase) && $phrase) {
                ?>

                <h2>
                        <?= $phrase ?>
                </h2>

                <?php
                    }
                ?>
        </section>
    </header>