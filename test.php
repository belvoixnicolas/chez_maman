<?php
    require_once('model/bdd.php');

    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $bdd = new bdd;
        $bdd = $bdd->co();
        $req = $bdd->prepare('INSERT INTO produit (id, titre, text, image, prix, id_menu) VALUES (NULL, `titre`, `text`, :img, 52, 17)');

        switch ($file['type']) {
            case 'image/gif':
            case 'image/jpeg':
            case 'image/png':
            case 'image/svg+xml':

                $type = true;
                break;
            
            default:
                $type = false;
                break;
        }

        if ($type) {
            if (move_uploaded_file($file['tmp_name'], 'controller/src/produit/' . $file['name'])) {
                for ($i=0; $i < 50; $i++) { 
                    copy('controller/src/produit/' . $file['name'], 'controller/src/produit/' . $i . $file['name']);

                    $req->execute(array(
                        ':img' => $i . $file['name']
                    ));
                }
            }else {
                echo 'erreur upload';
            }
        }else {
            echo 'type non reconue';
        }
    }
?>

<form action="#" method="post" ENCTYPE="multipart/form-data">
    <input type="file" name="file">
    <input type="submit" value="envoyer">
</form>