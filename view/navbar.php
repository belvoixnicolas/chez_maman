<nav>
        <section class="bar">
            <h4>navbar</h4>
            <div class="menuBurger">
                <i class="fas fa-bars"></i>
            </div>
            <div class="horraire">
                <?php 
                    if (isset($etat) && $etat) {
                ?>

                    <img src="src/img/<?= $etat['image'] ?>" alt="Paneau" />
                    <p>
                        <?php 
                            if ($etat['text']) {
                                echo $etat['text'];
                            }
                        ?>
                    </p>

                <?php
                    }
                ?>
            </div>
            <ul class="lien">
                <?php
                    if (isset($numero) && $numero) {
                        if ($numero['mobile']) {
                ?>

                    <li>
                        <a href="tel:+33<?= substr($numero['numero'], 1) ?>">
                            Appeler
                        </a>
                    </li>

                <?php
                        }else {
                ?>

                    <li>
                        <span>
                            <?= implode('.', str_split($numero['numero'], 2)) ?>
                        </span>
                    </li>

                <?php
                        }
                    }
                ?>
                <li>
                    <?= $lien; ?>
                </li>
                <?php
                    if (isset($lienAddress) && $lienAddress) {
                        $lien = str_replace(' ', '+', $lienAddress['numero'] . ' ' . $lienAddress['rue'] . ' ' . $lienAddress['cp'] . ' ' . $lienAddress['ville']);
                ?>

                    <li>
                        <a href="https://www.google.com/maps/place/<?= $lien ?>" target="_blank" rel="noopener noreferrer nofollow">
                            Itinéraire
                        </a>
                    </li>

                <?php
                    }
                ?>
            </ul>
            <?php
                if (isset($reseaux) && $reseaux) {
            ?>

            <ul class="reseaux">
                <?php
                    foreach ($reseaux as $value) {
                ?>

                <li>
                    <a href="<?= $value['url'] ?>" target="_blank" rel="noopener noreferrer">
                        <img src="src/reseaux/<?= $value['image'] ?>" alt="Logo de <?= $value['titre'] ?>">
                    </a>
                </li>

                <?php
                    }
                ?>
            </ul>

            <?php
                }
            ?>
        </section>
        <section class="menu close">
            <h4>menu</h4>
            <ul>
            
            </ul>
        </section>
        <script src="js/lien.js"></script>
    </nav>