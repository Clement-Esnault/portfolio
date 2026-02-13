<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <a href="index.php?url=admin/admin" class="primary-btn">Revenir sur la page d'admin</a>
    <h1>Modifier le Monstre</h1>

    <!-- Affichage des messages -->
    <?php if (isset($message)): ?>
        <p class="alert-message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Formulaire de modification du monstre -->
    <form action="index.php?url=admin/updateMonster" method="POST">
    <input type="hidden" name="ent_id" value="<?= $monster['ENT_ID']; ?>">
    
    <div class="form-group">
        <label for="ent_nom">Nom du monstre :</label>
        <input type="text" name="ent_nom" id="ent_nom" value="<?= htmlspecialchars($monster['ENT_NOM']); ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_description">Description :</label>
        <textarea name="ent_description" id="ent_description" required><?= htmlspecialchars($monster['ENT_DESCRIPTION']); ?></textarea>
    </div>

    <div class="form-group">
        <label for="ent_pv">PV :</label>
        <input type="number" name="ent_pv" id="ent_pv" value="<?= $monster['ENT_PV']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_mana">Mana :</label>
        <input type="number" name="ent_mana" id="ent_mana" value="<?= $monster['ENT_MANA']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_strength">Force :</label>
        <input type="number" name="ent_strength" id="ent_strength" value="<?= $monster['ENT_STRENGTH']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_initiative">Initiative :</label>
        <input type="number" name="ent_initiative" id="ent_initiative" value="<?= $monster['ENT_INITIATIVE']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_capacity">Capacité :</label>
        <input type="text" name="ent_capacity" id="ent_capacity" value="<?= htmlspecialchars($monster['ENT_CAPACITY']); ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_attack">Attaque :</label>
        <input type="number" name="ent_attack" id="ent_attack" value="<?= $monster['ENT_ATTACK']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_pv_max">PV Max :</label>
        <input type="number" name="ent_pv_max" id="ent_pv_max" value="<?= $monster['ENT_PV_MAX']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_mana_max">Mana Max :</label>
        <input type="number" name="ent_mana_max" id="ent_mana_max" value="<?= $monster['ENT_MANA_MAX']; ?>" required>
    </div>

    <div class="form-group">
        <label for="ent_loot_id">Loot :</label>
        <select name="ent_loot_id" id="ent_loot_id">
            <option value="0">Aucun</option>
            <?php foreach ($loots as $loot): ?>
                <option value="<?= $loot['MON_LOOT_ID']; ?>" <?= $loot['MON_LOOT_ID'] == $monster['MON_LOOT_ID'] ? 'selected' : ''; ?>>
                    <?= htmlspecialchars($loot['ITE_NAME']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <button type="submit" class="primary-btn">Modifier le Monstre</button>
    </div>
</form>


    <!-- Bouton de suppression -->
    <div class="form-group">
        <a href="index.php?url=admin/deleteMonster/<?php echo $monster['ENT_ID']; ?>" 
           class="delete-btn" 
           onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce monstre ?');">
           Supprimer le monstre
        </a>
    </div>

</body>
<section></section>
<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
