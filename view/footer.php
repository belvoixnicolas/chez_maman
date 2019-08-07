    <footer>
        <?php if (isset($reseaux) && $reseaux) { ?>
            <ul class="reseaux">
                <?php foreach ($reseaux as $value) { ?>
                    <li>
                        <a href="<?= htmlspecialchars($value['url']) ?>" title="<?= htmlspecialchars($value['titre']) ?>" target="_blank" rel="noopener noreferrer">
                            <img src="src/reseaux/<?= htmlspecialchars($value['image']) ?>" alt="Logo de <?= htmlspecialchars($value['titre']) ?>">
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
        <p id="pc">Copyright 2019 &copy; Chez maman | Conception &amp; Réalisation : <a href="http://www.nicolas-belvoix.fr" target="_blank" rel="noopener noreferrer">nicolas-belvoix.fr</a></p>
        <p id="tel">
            <span>
                Copyright 2019 &copy; Chez maman
            </span>
            <span>
                Conception &amp; Réalisation : <a href="http://www.nicolas-belvoix.fr" target="_blank" rel="noopener noreferrer">nicolas-belvoix.fr</a>
            </span>
        </p>
        <a href="../index.php?page=connexion">Connexion</a>
    </footer>