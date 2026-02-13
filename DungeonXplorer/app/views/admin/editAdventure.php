<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <h1>Éditer l'aventure : <?php echo $adventure['ADV_LIBELLE']; ?></h1>

    <!-- Afficher les messages -->
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Formulaire de modification d'aventure -->
    <form action="index.php?url=admin/editAdventure/<?php echo $adventure['ADV_ID']; ?>" method="POST">
        <label for="libelle">Nom de l'aventure :</label>
        <input type="text" name="libelle" id="libelle" value="<?php echo $adventure['ADV_LIBELLE']; ?>" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required><?php echo $adventure['ADV_DESCRIPTION']; ?></textarea>

        <button type="submit">Mettre à jour l'aventure</button>
    </form>

    <a href="index.php?url=admin/editAdventures" class="button">Retour à la gestion des aventures</a>
</body>
<section></section>
</html>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
