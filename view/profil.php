<section id="sectionprofil">
    <h2>
        Profil
    </h2>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Mail</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                if (isset($profils) && $profils) { 
                    foreach ($profils as $value) {
                        if ($value['admin'] == 1) {
                            $icon = '<i class="fas fa-user"></i>';
                        }else {
                            $icon = '<i class="far fa-user"></i>';
                        }
            ?>

                <tr>
                    <td class="nom"><?= htmlspecialchars($value['nom']) ?></td>
                    <td class="mail"><?= htmlspecialchars($value['mail']) ?></td>
                    <td class="admin"><button id="modifprofil" name="id" value="<?= htmlspecialchars($value['id']) ?>"><?= $icon ?></button></td>
                    <td class="sup"><button id="supprofil" name="id" value="<?= htmlspecialchars($value['id']) ?>"><i class="fas fa-times"></i></button></td>
                </tr>

            <?php
                    }
                } 
            ?>
        </tbody>
    </table>

    <form action="#" method="post" id="formprofil">
        <input type="text" name="nom" id="nomprofil" placeholder="Nom" required>
        <input type="email" name="mail" id="mailprofil" placeholder="Mail" required>

        <input type="submit" value="Envoyer">
    </form>
    <script src="js/ajax/formprofil.js"></script>
</section>