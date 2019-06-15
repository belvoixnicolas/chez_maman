<article id="service">
    <h3>
        Services
    </h3>
    <?php
        foreach ($services as $value) {
    ?>

    <section>
        <h4><?= $value['titre'] ?></h4>
        <img src="src/services/<?= $value['image'] ?>" alt="illustration de <?= $value['titre'] ?>">
        <p>
            <?= $value['text'] ?>
        </p>
    </section>

    <?php
        }
    ?>
</article>