<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<?php
// Vérifie si un chapitre a été trouvé
if (!isset($chapter)) {
    echo '<p>Chapitre introuvable.</p>';
    exit;
}
?>

<div class="container">
    <a href="index.php?url=admin/editChapters" class="primary-btn">Revenir à la page des chapitres</a>
    <h2>Modifier le Chapitre : <?= htmlspecialchars($chapter['CHA_TITLE']) ?></h2>
    
    <!-- Affichage d'un message de succès ou d'erreur -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>
    
    <!-- Formulaire de modification du chapitre -->
    <form action="index.php?url=admin/updateChapter/<?= $chapter['CHA_ID'] ?>" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($chapter['CHA_TITLE']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Contenu</label>
            <textarea class="form-control" id="content" name="content" rows="5" required><?= htmlspecialchars($chapter['CHA_CONTENT']) ?></textarea>
        </div>
        <button type="submit" class="primary-btn">Mettre à jour le chapitre</button>
    </form>
    
    <!-- Lien pour revenir à la liste des chapitres -->
    <a href="index.php?url=admin/editChapters" class="secondary-btn">Retour à la liste des chapitres</a>
</div>
<section></section>
<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
