<?php
    require_once('../model/menu.php');
    $produit = new menu;

    foreach ($menus as $value) {
?>

<article id="<?= $value['titre'] ?>">
    <h2>
        <img src="src/menu/<?= $value['image'] ?>" alt="<?= $value['titre'] ?>">
    </h2>
    <ul>
        <?php 
            if ($produits = $produit->produits($value['id'])) {
                foreach ($produits as $value) {
        ?>

        <li>
            <figure>
                <img src="src/produit/<?= $value['image'] ?>" alt="Photo du <?= $value['titre'] ?>">
                <figcaption>
                    <p><?= $value['text'] ?></p>
                    <h5><?= $value['prix'] ?> €</h5>
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