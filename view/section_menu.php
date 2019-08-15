<?php
    require_once('../model/menu.php');
    $produit = new menu;

    foreach ($menus as $value) {
?>

<article id="<?= htmlspecialchars($value['titre']) ?>">
    <h2>
        <img src="src/menu/<?= htmlspecialchars($value['image']) ?>" alt="<?= htmlspecialchars($value['titre']) ?>">
    </h2>
    <ul>
        <?php 
            if ($produits = $produit->produits($value['id'])) {
                foreach ($produits as $value) {
        ?>

        <li>
            <figure>
                <img src="src/produit/<?= htmlspecialchars($value['image']) ?>" alt="Photo du <?= htmlspecialchars($value['titre']) ?>">
                <?php if (isset($mobile) && $mobile) { ?>
                    <i class="fas fa-hand-point-up"></i>
                <?php } ?>
                <figcaption>
                    <p><?= nl2br(htmlspecialchars($value['text'])) ?></p>
                    <h5><?= htmlspecialchars($value['prix']) ?> €</h5>
                </figcaption>
            </figure>
        </li>

        <?php
                }
            }
        ?>
        
    </ul>
</article>

<?php
    }
?>