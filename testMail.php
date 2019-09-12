<?php
    if (isset($_POST['txt'], $_POST['mail'], $_POST['sujet']) && $_POST['sujet'] != '' && $_POST['txt'] != '' && $_POST['mail'] != '') {
        $site = $_SERVER['HTTP_HOST'];
        $from = "webmaster@chezmaman.com";
        $nom = "Chez maman";
        $to = $_POST['mail'];
        $sujet = $_POST['sujet'];
        $text = "Hello every Body !!!";
        $html = $_POST['txt'];

        $from = $nom." <".$from.">";

        $limite = "_----------=_parties_".md5(uniqid (rand()));

        $header  = "Reply-to: ".$from."\n";
        $header .= "From: ".$from."\n";
        $header .= "X-Sender: <".$site.">\n";
        $header .= "X-Mailer: PHP\n";
        $header .= "X-auth-smtp-user: ".$from." \n";
        $header .= "X-abuse-contact: ".$from." \n";
        $header .= "Date: ".date("D, j M Y G:i:s O")."\n";
        $header .= "MIME-Version: 1.0\n";
        $header .= "Content-Type: multipart/alternative; boundary=\"".$limite."\"";

        $message = "";

        $message .= "--".$limite."\n";
        $message .= "Content-Type: text/plain\n";
        $message .= "charset=\"iso-8859-1\"\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $text;

        $message .= "\n\n--".$limite."\n";
        $message .= "Content-Type: text/html; ";
        $message .= "charset=\"iso-8859-1\"; ";
        $message .= "Content-Transfer-Encoding: 8bit;\n\n";
        $message .= $html;

        $message .= "\n--".$limite."--";
        mail($to, $sujet, $message, $header);
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>test Mail</title>
    <style>
        form {
            min-height: 70vh;
            display: flex;
            flex-flow: column nowrap;
            justify-content: space-around;
            align-items: center;
        }

        input, textarea {
            width: 70%;
        }

        input[type=submit] {
            width: 50%;
        }
    </style>
</head>
<body>
    <h1>Teste d'envoie de mail</h1>

    <?php if (isset($mail) && $mail) { ?>

        <h2>Le mail a été envoyer</h2>

    <?php } ?>

    <form action="#" method="post">
        <input type="email" name="mail" placeholder="mail">
        <input type="text" name="sujet" placeholder="sujet">
        <textarea name="txt" cols="30" rows="10" placeholder="text Mail"></textarea>
        <input type="submit" value="Tester">
    </form>
</body>
</html>