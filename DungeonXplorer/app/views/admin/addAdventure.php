<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <div class="container">
    <a href="index.php?url=admin/admin" class="primary-btn">Revenir sur la page des aventures</a>
        <h1 class="page-title">Ajouter une aventure</h1>

        <!-- Afficher les messages -->
        <?php if (isset($message)): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Formulaire d'ajout d'aventure -->
        <form class="form" action="index.php?url=admin/insertAdventure" method="POST">
            <div class="form-group">
                <label for="libelle" class="form-label">Nom de l'aventure :</label>
                <input type="text" name="libelle" id="libelle" class="form-input" required placeholder="Entrez le nom de l'aventure">
            </div>

            <div class="form-group">
                <label for="description" class="form-label">Description :</label>
                <textarea name="description" id="description" class="form-input" required placeholder="Entrez la description"></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Ajouter l'aventure</button>
            </div>

        </form>

        <div class="form-group">
            <a href="index.php?url=admin/editAdventures" class="secondary-btn">Retour à la gestion des aventures</a>
        </div>
    </div>
</body>
<section></section>
</html>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
