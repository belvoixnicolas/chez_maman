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

                    <?php 
                        $i = 0;
                        foreach ($horraires as $value) {
                            $i++;
                    ?>

                        <fieldset id="<?= $i ?>">
                            <legend><?= $value['jour'] ?></legend>
                            <label for="<?= $value['jour'] ?>_ouvertMat">
                                De
                            </label>
                            <input type="time" name="<?= $value['jour'] ?>_ouvertMat" id="<?= $value['jour'] ?>_ouvertMat" min="00:00" max="12:00" step="60" placeholder="hh:mm" value="<?= $value['ouvertMat'] ?>">
                            <label for="<?= $value['jour'] ?>_fermeMat">
                                à
                            </label>
                            <input type="time" name="<?= $value['jour'] ?>_fermeMat" id="<?= $value['jour'] ?>_fermeMat" min="00:00" max="12:00" step="60" placeholder="hh:mm" value="<?= $value['fermeMat'] ?>">
                            <label for="<?= $value['jour'] ?>_ouvertAp">
                                et de
                            </label>
                            <input type="time" name="<?= $value['jour'] ?>_ouvertAp" id="<?= $value['jour'] ?>_ouvertAp" min="12:00" max="23:59" step="60" placeholder="hh:mm" value="<?= $value['ouvertAp'] ?>">
                            <label for="<?= $value['jour'] ?>_fermeAp">
                                à
                            </label>
                            <input type="time" name="<?= $value['jour'] ?>_fermeAp" id="<?= $value['jour'] ?>_fermeAp" min="12:00" max="23:59" step="60" placeholder="hh:mm" value="<?= $value['fermeAp'] ?>">
                        </fieldset>

                    <?php
                        }
                    ?>
                </form>
                <script src="js/ajax/horraire.js"></script>
            <?php } ?>
            </article>
        </main>
    </body>
</html>