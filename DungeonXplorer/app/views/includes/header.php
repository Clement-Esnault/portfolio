<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DungeonXplorer</title>
    <link rel="stylesheet" href="public/css/styles.css">
    <script src="public/script/script.js"></script>
</head>
<body>
    <header>
            <div class="flex-row">         
                <a id="logoImg" href="home">
                    <picture>
                        <source media="(max-width: 768px)" srcset="public/img/logo/dungeonLogoMinLight.png">
                        <img src="public/img/logo/dungeonLogoFullLight.png" alt="Logo" style="height: 100px; width:auto;">
                    </picture>            
                </a>
                <a class="button flex-row" href="home">
                    <img src="public/img/icons/home.png" alt="Logo" style="height:34px; width:auto;">
                    <p>Accueil</p>
                </a>
                <?php if(isset($_SESSION['user_id'])): ?>
                <a class="button flex-row" href="decouvrir">
                    <img src="public/img/icons/compass.png" alt="Logo" style="height:34px; width:auto;">
                    <p>Decouvrir</p>
                </a>
                <?php endif; ?>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <a class="button flex-row" href="continue">
                        <img src="public/img/icons/compass.png" alt="Logo" style="height:34px; width:auto;">
                        <p>Continue</p>
                    </a>
                <?php endif; ?>
                <?php if (isset($_SESSION['chapter_id']) && isset($_SESSION['sav_id'])): ?>
                    <a href="chapitre?adv_id=<?php echo htmlspecialchars($_SESSION['adv_id']); ?>&chapter_id=<?php echo htmlspecialchars($_SESSION['chapter_id']); ?>&sav_id=<?php echo htmlspecialchars($_SESSION['sav_id']); ?>" class="button">
                        <p>Reprendre</p>
                    </a>
                <?php endif; ?>  

            </div>
            <div class="flex-row">
                <a class="button flex-row" href="about">
                    <img src="public/img/icons/info.png" alt="Logo" style="height:34px; width:auto;">
                    <p>A propos</p>
                </a>
                <?php if(!isset($_SESSION['user_id'])): ?>
                    <a class="button flex-row" href="login">
                        <img src="public/img/icons/account.png" alt="Logo" style="height:34px; width:auto;">
                        <p>Se connecter</p>
                    </a>
                <?php else: ?>
                    <a class="button flex-row" href="profile">
                        <img src="public/img/icons/account.png" alt="Logo" style="height:34px; width:auto;">
                        <?= htmlspecialchars($_SESSION['pseudo']); ?>
                    </a>
                <?php endif; ?>
            </div>
    </header>
    <main>