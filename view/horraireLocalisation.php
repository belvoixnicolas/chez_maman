<article id="horraire_et_localisation">
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
                <th><?= $value['jour'] ?></th>
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

        <a href="https://www.google.com/maps/place/<?= $lien ?>" target="_blank" rel="noopener noreferrer nofollow">
            <?= $address['numero'] . ' ' . $address['rue'] ?><br/>
            <?= $address['ville'] . ' ( ' . $address['cp'] . ' )' ?>
        </a>

        <?php
            }else {
                $lien = 'paris';
            }
        ?>
        <iframe
        src="https://www.google.com/maps/embed/v1/place?key=AIzaSyC7QhxvnZ6DQHSnkgOZFl0l3nA977SSaGQ&q=<?= $lien ?>" allowfullscreen>
        </iframe>
    </section>
</article>