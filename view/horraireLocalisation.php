<article id="horraires_et_localisation">
    <h3>
        horraire et localisation
    </h3>
    <section class="horraire">
            <h4>horraire</h4>
        <table>
            <?php
                if (isset($horraireTab) && $horraireTab) {
                    $tableau = '';
                    foreach ($horraireTab as $value) {
            ?>

            <tr>
                <th><?= htmlspecialchars($value['jour']) ?></th>
                <td><?= $value['heure'] ?></td>
            </tr>

            <?php
                    }
                }
            ?>
        </table>
    </section>
    <section class="localisation">
        <h4>localisation</h4>
        <?php 
            if (isset($address) && $address) {
                $lien = str_replace(' ', '+', $address['numero'] . ' ' . $address['rue'] . ' ' . $address['cp'] . ' ' . $address['ville']);
        ?>

        <a href="https://www.google.com/maps/place/<?= htmlspecialchars($lien) ?>" target="_blank" rel="noopener noreferrer nofollow">
            <?= htmlspecialchars($address['numero']) . ' ' . htmlspecialchars($address['rue']) ?><br/>
            <?= htmlspecialchars($address['ville']) . ' (' . htmlspecialchars($address['cp']) . ')' ?>
        </a>

        <?php
            }else {
                $lien = 'paris';
            }
        ?>
        <iframe
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyC7QhxvnZ6DQHSnkgOZFl0l3nA977SSaGQ&q=<?= htmlspecialchars($lien) ?>" allowfullscreen>
        </iframe>
    </section>
</article>