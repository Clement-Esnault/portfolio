<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="admin-section">
    <a href="index.php?url=admin/editItems" class="primary-btn">Revenir sur la page d'administration</a>
    <div class="container">
        <h2>Ajouter un nouvel item</h2>
        
        <?php if (isset($_GET['error'])): ?>
            <p class="error"><?= htmlspecialchars($_GET['error']) ?></p>
        <?php elseif (isset($_GET['message'])): ?>
            <p class="success"><?= htmlspecialchars($_GET['message']) ?></p>
        <?php endif; ?>
        
        <form method="POST" action="index.php?url=admin/insertItem">
            <label for="name">Nom de l'item</label>
            <input type="text" name="name" id="name" required>
            
            <label for="description">Description de l'item</label>
            <textarea name="description" id="description" required></textarea>
            
            <label for="weight">Poids</label>
            <input type="number" name="weight" id="weight">
            
            <label for="value">Valeur</label>
            <input type="number" name="value" id="value">
            
            <label for="stackable">Empilable</label>
            <select name="stackable" id="stackable" required>
                <option value="1">Oui</option>
                <option value="0">Non</option>
            </select>
            
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" required>
            
            <label for="type_id">Type d'item</label>
            <select name="type_id" id="type_id" required>
                <?php foreach ($itemTypes as $type): ?>
                    <option value="<?= $type['TYP_ITEM_ID'] ?>"><?= htmlspecialchars($type['TYP_ITEM_LIBELLE']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="xp">XP associée à cet item</label>
            <input type="number" name="xp" id="xp" required>
            
            <button type="submit" class="button">Ajouter l'item</button>
        </form>
    </div>
</section>
<section></section>
<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
