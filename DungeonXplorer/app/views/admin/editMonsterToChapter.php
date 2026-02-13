<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <a href="index.php?url=admin/editChapters" class="primary-btn">Revenir sur la page des chapitres</a>
    <h1>Changer le monstre pour ce chapitre</h1>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter un monstre au chapitre -->
    
    <?php if (!$currentMonster): ?>
    <h2>Ajouter un monstre au chapitre</h2>
    <form action="index.php?url=admin/insertMonsterToChapter" method="POST">
        <input type="hidden" name="chapter_id" value="<?php echo $chapterId; ?>">
        <label for="monster_id">Choisir un monstre :</label>
        <select name="monster_id" id="monster_id">
            <option value="">-- Sélectionnez un monstre --</option>
            <?php foreach ($monsters as $monster): ?>
                <option value="<?php echo $monster['ENT_ID']; ?>">
                    <?php echo $monster['ENT_NOM']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Ajouter le monstre</button>
    </form>
    
    <!-- Si un monstre est déjà associé, afficher l'option pour le supprimer -->
    <?php else: ?>
        <h2>Monstre actuel : <?php echo $currentMonster['ENT_NOM']; ?></h2>
        <form action="index.php?url=admin/deleteMonsterFromChapter" method="POST">
            <input type="hidden" name="chapter_id" value="<?php echo $chapterId; ?>">
            <input type="hidden" name="monster_id" value="<?php echo $currentMonster['ENT_NOM']; ?>">
            <button type="submit" class="delete-btn">Supprimer ce monstre</button>
        </form>
    <?php endif ?>
</body>
<section></section>
</html>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
