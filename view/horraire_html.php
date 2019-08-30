<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php include_once('../view/head.php') ?>
        <style type="text/css">
            img {
                height: 5vh;
            }
        </style>
    </head>
    <body id="horraire">
        <div id="message" class='hidden'>
            <span class="text"></span>
            <button>
                <i class="fas fa-times"></i>
            </button>
        </div>
        <?php include_once('../view/navadmin.php') ?>

        <main>
            <h1>Gestion des horraires</h1>
            <article>
            <?php if (isset($horraires) && is_array($horraires) && count($horraires) && $horraires) { ?>
                <form action="#" method="post" id="formHorraire">
                    <table>

                        <?php 
                            $i = 0;
                            foreach ($horraires as $value) {
                                $i++;
                        ?>

                            <tr id="<?= $i ?>">
                                <th><?= htmlspecialchars($value['jour']) ?></th>
                                
                                <td>
                                    <label for="<?= htmlspecialchars($value['jour']) ?>_ouvertMat">
                                        de
                                    </label>
                                </td>
                                <td>
                                    <input type="time" name="<?= htmlspecialchars($value['jour']) ?>_ouvertMat" id="<?= htmlspecialchars($value['jour']) ?>_ouvertMat" min="00:00" max="12:00" step="60" placeholder="hh:mm" value="<?= htmlspecialchars($value['ouvertMat']) ?>">
                                </td>
                                <td>
                                    <label for="<?= htmlspecialchars($value['jour']) ?>_fermeMat">
                                        à
                                    </label>
                                </td>
                                <td>
                                    <input type="time" name="<?= htmlspecialchars($value['jour']) ?>_fermeMat" id="<?= htmlspecialchars($value['jour']) ?>_fermeMat" min="00:00" max="12:00" step="60" placeholder="hh:mm" value="<?= htmlspecialchars($value['fermeMat']) ?>">
                                </td>
                                <td>
                                    <label for="<?= htmlspecialchars($value['jour']) ?>_ouvertAp">
                                        et de
                                    </label>
                                </td>
                                <td>
                                    <input type="time" name="<?= htmlspecialchars($value['jour']) ?>_ouvertAp" id="<?= htmlspecialchars($value['jour']) ?>_ouvertAp" step="60" placeholder="hh:mm" value="<?= htmlspecialchars($value['ouvertAp']) ?>">
                                </td>
                                <td>
                                    <label for="<?= htmlspecialchars($value['jour']) ?>_fermeAp">
                                        à
                                    </label>
                                </td>
                                <td>
                                    <input type="time" name="<?= htmlspecialchars($value['jour']) ?>_fermeAp" id="<?= htmlspecialchars($value['jour']) ?>_fermeAp" step="60" placeholder="hh:mm" value="<?= htmlspecialchars($value['fermeAp']) ?>">
                                </td>
                            </tr>

                        <?php
                            }
                        ?>
                    </table>
                </form>
                <script src="js/ajax/horraire.js"></script>
            <?php } ?>
            </article>
        </main>
    </body>
</html>