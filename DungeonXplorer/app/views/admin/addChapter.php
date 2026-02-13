<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>
<a href="index.php?url=admin/editChapters" class="primary-btn">Revenir sur la page des chapitres</a>
<h2>Ajouter un Nouveau Chapitre</h2>

<form action="index.php?url=admin/addChapter" method="POST">
    <div>
        <label for="title">Titre du chapitre :</label>
        <input type="text" name="title" id="title" required>
    </div>

    <div>
        <label for="content">Contenu du chapitre :</label>
        <textarea name="content" id="content" required></textarea>
    </div>

    <div>
        <label for="adventure_id">Choisir l'Aventure :</label>
        <select name="adventure_id" id="adventure_id" required>
            <option value="">Sélectionner une aventure</option>
            <?php foreach ($adventures as $adventure): ?>
                <option value="<?= $adventure['ADV_ID'] ?>"><?= htmlspecialchars($adventure['ADV_LIBELLE']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div>
        <button type="submit">Ajouter le Chapitre</button>
    </div>
    

    <?php if (isset($_GET['error'])): ?>
        <p style="color: red;"><?= htmlspecialchars($_GET['error']) ?></p>
    <?php endif; ?>
</form>
<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>