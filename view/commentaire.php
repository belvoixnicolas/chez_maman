<article id="commentaire">
    <h3>
        Commentaire
    </h3>
    <?php if (isset($avies) && $avies) { ?>
        <section class="commentaires">
            <h4>commentaires</h4>
            
            <ul>
                <?php 
                    $i = 1;
                    foreach ($avies as $value) { 
                ?>
                
                <li>
                    <img src="src/img/cupcake<?= htmlspecialchars($i) ?>.svg" alt="Icon">
                    <p>
                        <?= nl2br(htmlspecialchars($value['text'])) ?>
                    </p>
                </li>
                        
                <?php
                            if ( $i == 3) {
                                $i = 1;
                            }else {
                                $i++;
                            }
                        }
                ?>
            </ul>
        </section>
    <?php } ?>
        <section class="formulaire">
            <h4>formulaire</h4>
            <form action="#" method="post" id="formposte">
                <input type="text" name="com" id="com" placeholder="Laisser nous un commentaire">
        
                <input type="submit" value="Envoyer">
            </form>
            <script src="js/ajax/post_avie.js"></script>
        </section>
</article>