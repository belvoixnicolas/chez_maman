<?php
    require_once('../model/section_menu.php');
    $produit = new sectionMenu;

    foreach ($menus as $value) {
?>

<article id="<?= $value['titre'] ?>">
    <h2>
        <img src="src/menu/<?= $value['image'] ?>" alt="<?= $value['titre'] ?>">
    </h2>
    <ul>
        <?php 
            if ($produits = $produit->produit($value['id'])) {
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