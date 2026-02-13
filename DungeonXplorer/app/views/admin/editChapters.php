<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <a href="index.php?url=admin/admin" class="primary-btn">Revenir sur la page d'admin</a>
    <h1>Gestion des Chapitres</h1>
    

    <!-- Si un message est présent, on l'affiche -->
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Formulaire pour sélectionner une aventure -->
    <form action="index.php?url=admin/editChapters" method="POST">
        <label for="adventure_id">Choisir une aventure :</label>
        <select name="adventure_id" id="adventure_id">
            <option value="">-- Sélectionnez une aventure --</option>
            <?php foreach ($adventures as $adventure): ?>
                <option value="<?php echo $adventure['ADV_ID']; ?>" 
                    <?php echo (isset($_SESSION['choix_adv_id']) && $_SESSION['choix_adv_id'] == $adventure['ADV_ID']) ? 'selected' : ''; ?>>
                    <?php echo $adventure['ADV_LIBELLE']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Choisir l'aventure</button>
    </form>

    <!-- Si des chapitres existent pour l'aventure, afficher les chapitres -->
    <?php if (isset($_SESSION['choix_adv_id']) && !empty($chapters)): ?>
        <a href="index.php?url=admin/addChapter" class="secondary-btn">Ajouter un chapitre</a>
        <h2>Chapitres de l'Aventure</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Contenu</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($chapters as $chapter): ?>
                    <tr>
                        <td><?php echo $chapter['CHA_ID']; ?></td>
                        <td><?php echo $chapter['CHA_TITLE']; ?></td>
                        <td><?php echo $chapter['CHA_CONTENT']; ?></td>
                        <td><a href="index.php?url=admin/editChapter/<?php echo $chapter['CHA_ID']; ?>" class="secondary-btn">Modifier</a></td>
                        <td><a href="index.php?url=admin/deleteChapter/<?php echo $chapter['CHA_ID']; ?>" class="delete-btn">Supprimer</a></td>
                        <td><a href="index.php?url=admin/editMonsterToChapter/<?php echo $chapter['CHA_ID']; ?>" class="secondary-btn">Changer de Monstre</a></td>
                    </tr>
                   
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Ajouter un lien entre chapitres -->
        <a href="index.php?url=admin/addLink&adv_id=<?php echo $_SESSION['choix_adv_id']; ?>" class="secondary-btn">Ajouter un lien entre chapitres</a>
        <a href="index.php?url=admin/supLink&adv_id=<?php echo $_SESSION['choix_adv_id']; ?>" class="secondary-btn">Supprimer un lien entre chapitres</a>
    <?php else: ?>
        <p>Aucun chapitre trouvé pour cette aventure.</p>
    <?php endif; ?>
</body>
<section></section>
</html>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
