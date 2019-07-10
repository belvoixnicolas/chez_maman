    <nav id="navbaradmin">
        <section class="bar">
            <h4>navbar</h4>
            <div class="menuBurger">
                <i class="fas fa-bars"></i>
            </div>

            <?php
                $self = explode('/', $_SERVER['PHP_SELF']);
                
                if (end($self) == 'gestion.php' && isset($session['admin']) && $session['admin'] == 1) {
            ?>

            <ul class="lien">
                    <li>
                        <a href="../index.php?page=gestion&precis=entreprise">
                            Entreprise
                        </a>
                    </li>
                    <li>
                        <a href="../index.php?page=gestion&precis=perso">
                            Personnel
                        </a>
                    </li>
            </ul>

            <?php
                }
            ?>
        </section>
        <section class="menu close">
            <h4>menu</h4>
            <ul>
                <li>
                    <a href="../index.php?page=gestion">
                        gestion
                    </a>
                </li>
                <?php
                    if ($_SESSION['profil']['admin'] == 1) {
                ?>

                    <li>
                        <a href="../index.php?page=description">
                            description
                        </a>
                    </li>
                
                <?php
                    }
                ?>
                <li>
                    <a href="../index.php?page=">
                        avis
                    </a>
                </li>
                <?php
                    if ($_SESSION['profil']['admin'] == 1) {
                ?>

                    <li>
                        <a href="../index.php?page=">
                            services
                        </a>
                    </li>
                
                <?php
                    }
                ?>
                <li>
                    <a href="../index.php?page=">
                        menu
                    </a>
                </li>
                <?php
                    if ($_SESSION['profil']['admin'] == 1) {
                ?>

                    <li>
                        <a href="../index.php?page=" id="déco">
                            horraire
                        </a>
                    </li>
                
                <?php
                    }
                ?>
                <li>
                    <a href="#" id="deconnexion">
                        déconnexion
                    </a>
                </li>
            </ul>
        </section>
    </nav>
    <script src="js/navbaradmin.js"></script>