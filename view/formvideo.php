<section id="sectionformvideo">
    <h2>video</h2>
    <video id="video" autoplay loop muted>
        <?php if (isset($video) && is_array($video) == false) { ?>
            <source src="src/video/<?= htmlspecialchars($video) ?>" type="video/mp4">
        <?php } ?>
        <source src="src/video/default.webm" type="video/webm">
        <source src="src/video/default.ogg" type="video/ogg">
        <source src="src/video/default.mp4" type="video/mp4">
    </video>

    <form action="#" method="post" id="formvideo" enctype="multipart/form-data">
        <input type="file" name="video" id="video" >
        <label for="video">La vidéo doit être au format mp4 et une taille max de 64 Mo</label>

        <input type="submit" value="Envoyer">
    </form>
    <script src="js/ajax/modvideo.js"></script>
</section>