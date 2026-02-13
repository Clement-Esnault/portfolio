<?php include(ROOT_DIR . 'app/views/includes/header.php'); 
?>

<section class="discover">
    <?php if (!isset($_POST['adv_id'])): ?>
        <h1>Choisissez une aventure</h1>
        <?php if (count($adventures) > 0): ?>
            <form action="" method="post">
                <ul>
                    <?php foreach ($adventures as $adventure): ?>
                        <li>
                            <button type="submit" name="adv_id" value="<?php echo htmlspecialchars($adventure['ADV_ID']); ?>">
                                <?php echo htmlspecialchars($adventure['ADV_LIBELLE']); ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </form>
        <?php else: ?>
            <p>Aucune aventure disponible.</p>
        <?php endif; ?>
    <?php endif; ?>

   <?php if (isset($_POST['adv_id'])): ?>
        <h1>Créez votre héros</h1>
        <a class="button flex-row" href="choixHero">
            <p>Je crée mon héros</p>
        </a>
    <?php endif; ?>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
