<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="choose-hero">
        <?php if (isset($_SESSION['hero_name'])): ?>
        <p>Félicitations, vous avez créé votre héros ! Cliquez ci-dessous pour commencer l'aventure :</p>
        <a href="chapterController" class="button">Commencer l'aventure</a>
    <?php endif; ?>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>