<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once('head.php') ?>
    <style type="text/css">
        img {
            height: 5vh;
        }
    </style>
</head>
<body id="gestioservice">
    <div id="message" class='hidden'>
        <span class="text"></span>
        <button>
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php include_once('navadmin.php') ?>

    <main>
        <h1>service</h1>
        <section class="services">
            <h2>services</h2>
            <ul>
                <li class="service">
                    <img src="src/services/wifi.svg" alt="titre">
                    <p class="text">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Facere dolorum optio quod unde molestias, veritatis ratione accusamus totam error excepturi natus, aut ad magnam laudantium voluptate sunt. Fugiat laudantium nulla officia autem. Nobis reprehenderit, vel veniam placeat iure voluptas, eveniet facilis aperiam, incidunt recusandae expedita quaerat delectus odit animi. Nesciunt?
                    </p>
                    <button>
                        <i class="fas fa-times"></i>
                    </button>
                </li>
            </ul>
        </section>
        <section class="formservice">
            <form action="#" method="post">
                <img src="truc" alt="titre">
                <input type="file" name="image" id="image">
                <textarea name="txt" id="txt"></textarea>
                <input type="submit" value="envoyer">
            </form>
        </section>
    </main>
</body>
</html>