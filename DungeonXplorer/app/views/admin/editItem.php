<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <div class="container">
        <div class="form-group">
            <a href="index.php?url=admin/editItems" class="primary-btn">Revenir sur la page des trésors</a>
        </div>

        <!-- Affichage des messages -->
        <?php if (isset($message)): ?>
            <div class="alert-message"><?php echo $message; ?></div>
        <?php endif; ?>

        <h1 class="page-title">Modifier le Trésor : <?php echo htmlspecialchars($item['ITE_NAME']); ?></h1>

        <!-- Formulaire de modification du trésor -->
        <form action="index.php?url=admin/updateItem" method="POST">
            <input type="hidden" name="itemId" value="<?php echo $item['ITE_ID']; ?>">

            <div class="form-group">
                <label for="name" class="form-label">Nom du trésor :</label>
                <input type="text" name="name" id="name" class="form-input" value="<?php echo htmlspecialchars($item['ITE_NAME']); ?>" required placeholder="Entrez le nom du trésor">
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description :</label>
                <textarea name="description" id="description" class="form-input" required placeholder="Entrez la description"><?php echo htmlspecialchars($item['ITE_DESCRIPTION']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="poids" class="form-label">Poids :</label>
                <input type="number" name="poids" id="poids" class="form-input" value="<?php echo htmlspecialchars($item['ITE_POIDS']); ?>" required placeholder="Entrez le poids">
            </div>

            <div class="form-group">
                <label for="valeur" class="form-label">Valeur :</label>
                <input type="number" name="valeur" id="valeur" class="form-input" value="<?php echo htmlspecialchars($item['ITE_VALEUR']); ?>" required placeholder="Entrez la valeur">
            </div>

            <div class="form-group">
                <label for="stackable" class="form-label">Empilable :</label>
                <select name="stackable" id="stackable" class="form-input" required>
                    <option value="1" <?php echo $item['ITE_STACKABLE'] == 1 ? 'selected' : ''; ?>>Oui</option>
                    <option value="0" <?php echo $item['ITE_STACKABLE'] == 0 ? 'selected' : ''; ?>>Non</option>
                </select>
            </div>

            <div class="form-group">
                <label for="price" class="form-label">Prix :</label>
                <input type="number" name="price" id="price" class="form-input" value="<?php echo htmlspecialchars($item['ITE_PRIX']); ?>" required placeholder="Entrez le prix">
            </div>

            <div class="form-group">
                <label for="typeId" class="form-label">Type de trésor :</label>
                <select name="typeId" id="typeId" class="form-input" required>
                    <option value="">Sélectionner un type</option>
                    <?php foreach ($types as $type): ?>
                        <option value="<?php echo $type['TYP_ITEM_ID']; ?>"
                            <?php echo $type['TYP_ITEM_ID'] == $item['TYP_ITEM_ID'] ? 'selected' : ''; ?>>
                            <?php echo $type['TYP_ITEM_LIBELLE']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="form-group">
                <button type="submit" class="primary-btn">Modifier le trésor</button>
            </div>
        </form>

        <!-- Bouton de suppression -->
        <div class="form-group">
            <a href="index.php?url=admin/deleteItem/<?php echo $item['ITE_ID']; ?>" 
               class="delete-btn" 
               onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trésor ?');">
               Supprimer le trésor
            </a>
        </div>

    </div>

</body>
<section></section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
