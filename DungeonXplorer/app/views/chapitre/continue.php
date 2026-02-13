<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="continue">
    <h1>Continuer une aventure</h1>

    <?php if (count($savedAdventures) > 0): ?>
        <div class="saved-adventures">
            <?php foreach ($savedAdventures as $adventure): ?>
                <div class="adventure">
                    <h2><?php echo htmlspecialchars($adventure['ADV_LIBELLE']); ?></h2>
                    <p>Nom de votre héros : <?php echo htmlspecialchars($adventure['ENT_NOM']); ?></p>
                    <p>Chapitre : <?php echo htmlspecialchars($adventure['CHA_ID']); ?></p>
                    <a href="chapterController?adv_id=<?php echo $adventure['ADV_ID']; ?>&cha_id=<?php echo $adventure['CHA_ID']; ?>&ent_id=<?php echo $adventure['ENT_ID']; ?>" class="button">
                        Continuer
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Aucune aventure sauvegardée.</p>
    <?php endif; ?>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
