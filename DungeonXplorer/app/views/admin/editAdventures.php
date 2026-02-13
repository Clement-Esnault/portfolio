<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <div class="container">
    <div class="form-group"> 
        <a href="index.php?url=admin/admin" class="primary-btn">Revenir sur la page d'administration</a>
    </div>
    <div class="form-group">
        <a href="index.php?url=admin/addAdventure" class="primary-btn">Ajouter une aventure</a>
    </div>
        <?php foreach ($adventures as $adventure): ?> 
            <h1 class="page-title">Éditer l'aventure : <?php echo $adventure['ADV_LIBELLE']; ?></h1>

            <!-- Afficher les messages -->
            <?php if (isset($message)): ?>
                <div class="alert-message"><?php echo $message; ?></div>
            <?php endif; ?>
        
            <!-- Formulaire de modification d'aventure -->
            <form class="form" action="index.php?url=admin/updateAdventure/<?php echo $adventure['ADV_ID']; ?>" method="POST">
                <div class="form-group">
                    <label for="libelle" class="form-label">Nom de l'aventure :</label>
                    <input type="text" name="libelle" id="libelle" class="form-input" value="<?php echo $adventure['ADV_LIBELLE']; ?>" required placeholder="Entrez le nom de l'aventure">
                </div>
                <div class="form-group">
                    <label for="description" class="form-label">Description :</label>
                    <textarea name="description" id="description" class="form-input" required placeholder="Entrez la description"><?php echo htmlspecialchars($adventure['ADV_DISCRIPTION']); ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="primary-btn">Mettre à jour l'aventure</button>
                </div>
                
                <div class="form-group">
                    <a href="index.php?url=admin/deleteAdventure&adv_id=<?php echo $adventure['ADV_ID']; ?>" 
                    id="deleteBtn" 
                    class="delete-btn" 
                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette aventure ? Cela supprimera tous les chapitres, monstres et sauvegardes associés.');">
                        Supprimer l'aventure
                    </a>
                </div>
            </form>

            <!-- Modal -->
            <div id="confirmModal" class="modal">
                <div class="modal-content">
                    <p>Êtes-vous sûr de vouloir supprimer cette aventure ?</p>
                    <button id="cancelBtn" class="secondary-btn">Annuler</button>
                    <button class="delete-btn">Confirmer</button>
                </div>
            </div>

        <?php endforeach; ?>
        

    </div>
</body>
<section></section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>

