<?php
    require_once('../model/avie.php');

    if (isset($_POST['text'])) {
        $avie = new avie;

        echo $avie->setAvie($_POST['text']);
    }else {
        echo false;
    }
?>