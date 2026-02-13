<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>
<?php
if (isset($_POST['adventure_id'])) {
    $_SESSION['choix_adv_id'] = $_POST['adventure_id'];
    // Redirection pour éviter de re-soumettre le formulaire
    header("Location: index.php?url=admin/addLink");
    exit();
}
?>


<body>
    <a href="index.php?url=admin/editChapters" class="primary-btn">Revenir sur la page des chapitres</a>
    <h1>Ajouter un lien entre chapitres</h1>

    <!-- Vérifier si un message d'erreur ou de succès existe -->
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>

    
    <?php if (isset($_SESSION['choix_adv_id'])): ?>
        <?php 
        $adv_id = $_SESSION['choix_adv_id']; // Utiliser l'ID d'aventure dans la session
        $chapters = $this->adminModel->getChaptersByAdventure($adv_id); 
        ?>
        <?php if (!empty($chapters)): ?>
            <!-- Formulaire pour choisir les chapitres à lier -->
            <form action="index.php?url=admin/insertLink" method="POST">
                <h2>Choisir les chapitres à lier</h2>

                <!-- Sélectionner le premier chapitre -->
                <label for="cha_first">Chapitre 1 :</label>
                <select name="cha_first" id="cha_first">
                    <?php foreach ($chapters as $chapter): ?>
                        <option value="<?php echo $chapter['CHA_ID']; ?>"><?php echo $chapter['CHA_TITLE']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Sélectionner le deuxième chapitre -->
                <label for="cha_second">Chapitre 2 :</label>
                <select name="cha_second" id="cha_second">
                    <?php foreach ($chapters as $chapter): ?>
                        <option value="<?php echo $chapter['CHA_ID']; ?>"><?php echo $chapter['CHA_TITLE']; ?></option>
                    <?php endforeach; ?>
                </select>

                <!-- Description du lien -->
                <label for="description">Description du lien :</label>
                <textarea name="description" id="description" rows="4" cols="50"></textarea>

                <input type="hidden" name="adv_id" value="<?php echo $adv_id; ?>">

                <input type="submit" value="Ajouter le lien">
            </form>
        <?php else: ?>
            <p>Aucun chapitre disponible pour cette aventure.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
<section></section>
</html>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
