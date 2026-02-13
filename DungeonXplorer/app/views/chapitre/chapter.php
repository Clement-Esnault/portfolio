<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="flex-col chapitre">
    <h1><?php echo $chapter->getTitle(); ?></h1>
    <p><?php echo $chapter->getDescription(); ?></p>

    <?php if (isset($_SESSION['monster_id']) && isset($_SESSION['monster_name']) && ($_SESSION['combat_ended'] === false) && $_SESSION['have_fight']===true): ?>
        <!-- Redirection vers le combat -->
        <form method="post" action="index.php?url=combat">
            <input type="hidden" name="chapter_id" value="<?php echo $_SESSION['chapter_id']; ?>" />
            <button type="submit" class="button">
                Affronter le monstre : <?= htmlspecialchars($_SESSION['monster_name']) ?>
            </button>
        </form>
    <?php else: ?>
        <h2>Choisissez votre chemin:</h2>
        <?php foreach ($chapter->getChoices() as $index => $choice): ?>
            <form method="post" action="index.php?url=chapterController">
                <input type="hidden" name="cha" value="<?= $choice['chapter'] ?>">
                <input type="hidden" name="com" value="<?= $index ?>">
                <button type="submit" class="button">
                    <?= htmlspecialchars($choice['text']) ?>
                </button>
            </form>
        <?php endforeach; ?>

        <!-- Bouton de sauvegarde -->
        <form method="post" action="index.php?url=saveGame">
            <input type="hidden" name="chapter_id" value="<?= $_SESSION['chapter_id'] ?>">
            <button type="submit" class="button">Sauvegarder le jeu</button>
        </form>
        <a class="button" href="showInventory" class="button">Inventaire</a>
    <?php endif; ?>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
