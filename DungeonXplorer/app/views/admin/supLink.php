<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<?php
// Vérification de l'ID d'aventure dans la session, s'il existe
if (isset($_POST['adventure_id'])) {
    $_SESSION['choix_adv_id'] = $_POST['adventure_id'];
    // Redirection pour éviter de soumettre le formulaire à nouveau
    header("Location: index.php?url=admin/addLink");
    exit();
}
?>

<section class="flex-col chapitre">
<!-- Affichage des liens -->
<a href="index.php?url=admin/editChapters" class="primary-btn">Revenir sur la page des chapitres</a>
<h1>Liste des liens entre chapitres</h1>

<?php foreach ($links as $link): ?>
    <div class="link-item">
        <p>Chapitre depuis: <?php echo $link['CHA_TITLE_1']; ?> -> Chapitre vers: <?php echo $link['CHA_TITLE_2']; ?></p>
        <p>Description: <?php echo $link['LIN_DESCRIPTION']; ?></p>

        <!-- Bouton pour supprimer le lien -->
        <a href="index.php?url=admin/deleteLink&adv_id=<?php echo $link['ADV_ID']; ?>&cha_first=<?php echo $link['CHA_ID']; ?>&cha_second=<?php echo $link['LIN_NEXT_CHAPTER']; ?>" 
            class="delete-btn" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce lien ?');">
            Supprimer
            </a>
    </div>
<?php endforeach; ?>

</section>
<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
