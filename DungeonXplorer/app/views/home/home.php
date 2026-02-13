<?php

$isConnected = isset($_SESSION['user_id']);

unset($_SESSION['hero_object']);

/*var_dump(
    is_dir(ROOT_DIR . 'app'),
    is_dir(ROOT_DIR . 'app/models'),
    is_dir(ROOT_DIR . 'app/models/combat'),
    file_exists(ROOT_DIR . 'app/models/combat/EntityBDD.php')
);*/

?>

<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="home-section">
<script src="https://kit.fontawesome.com/0b14d7e148.js" crossorigin="anonymous"></script>
    <div class="container home-container">

        <h1>DungeonXplorer</h1>

        <p class="home-intro">
        Bienvenue sur DungeonXplorer, l'univers de dark fantasy où se mêlent aventure, stratégie et immersion
        totale dans les récits interactifs.
        Ce projet est né de la volonté de l’association Les Aventuriers du Val Perdu de raviver l’expérience unique
        des livres dont vous êtes le héros. Notre vision : offrir à la communauté un espace où chacun peut
        incarner un personnage et plonger dans des quêtes épiques et personnalisées.
        Dans sa première version, DungeonXplorer permettra aux joueurs de créer un personnage parmi trois
        classes emblématiques — guerrier, voleur, magicien — et d’évoluer dans un scénario captivant, tout en
        assurant à chacun la possibilité de conserver sa progression.
        Nous sommes enthousiastes de partager avec vous cette application et espérons qu'elle saura vous
        plonger au cœur des mystères du Val Perdu !
        </p>

        <?php if ($isConnected): ?>
            <div class="home-actions">

                <a href="decouvrir" class="primary-btn">
                    <i class="fa-solid fa-dice"></i> Commencer une nouvelle aventure
                </a>

                <a href="continue" class="secondary-btn">
                    <i class="fa-solid fa-hand-fist"></i> Continuer l’aventure
                </a>

            </div>
        <?php else: ?>
            <div class="home-actions">
                <a href="login" class="primary-btn">
                    <i class="fa-solid fa-key"></i> Se connecter
                </a>

                <a href="signup" class="secondary-btn">
                    <i class="fa-solid fa-pencil"></i> Créer un compte
                </a>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
