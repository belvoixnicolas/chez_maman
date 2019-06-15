<nav>
        <section class="bar">
            <h4>navbar</h4>
            <div class="menuBurger">
                <i class="fas fa-bars"></i>
            </div>
            <div class="horraire">
                <img src="src/img/paneau_ouvert.svg" alt="Paneau ouvert" />
                <p>
                    jusqu'à 17 h 00
                </p>
            </div>
            <ul class="lien">
                <li>
                    <button>
                        Appeler
                    </button>
                </li>
                <li>
                    <?= $lien; ?>
                </li>
                <li>
                    <a href="https://goo.gl/maps/Vm3LQ9AkFP3qhctG9" target="_blank" rel="noopener noreferrer nofollow">
                        Itinéraire
                    </a>
                </li>
            </ul>
            <ul class="reseaux">
                <li>
                    <a href="https://www.instagram.com/chez_maman_charleville/" target="_blank" rel="noopener noreferrer">
                        <img src="src/img/instagram.png" alt="Instagram">
                    </a>
                </li>
                <li>
                    <a href="https://www.facebook.com/FabulousTrucknMagicCakes/" target="_blank" rel="noopener noreferrer">
                        <img src="src/img/facebook.png" alt="Facebook">
                    </a>
                </li>
            </ul>
        </section>
        <section class="menu close">
            <h4>menu</h4>
            <ul>
            
            </ul>
        </section>
        <script src="js/lien.js"></script>
    </nav>