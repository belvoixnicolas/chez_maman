<article id="service">
    <h3>
        Services
    </h3>
    <?php
        foreach ($services as $value) {
    ?>

    <section>
        <h4><?= $value['titre'] ?></h4>
        <img src="src/services/<?= htmlspecialchars($value['image']) ?>" alt="illustration de <?= htmlspecialchars($value['titre']) ?>">
        <p>
            <?= nl2br(htmlspecialchars($value['text'])) ?>
        </p>
    </section>

    <?php
        }
    ?>
</article>