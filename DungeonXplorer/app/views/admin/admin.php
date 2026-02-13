<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="admin-navigation">
    <div class="container">
        <h2>Gestion de l'Administration</h2>
        <a href="index.php?url=profile" class="primary-btn">Revenir sur la page de profile</a>
        <div class="admin-links">
            <a href="index.php?url=admin/editChapters" class="button">Modifier les Chapitres</a>
            <a href="index.php?url=admin/editItems" class="button">Modifier les Trésors</a>
            <a href="index.php?url=admin/editUsers" class="button">Modifier les Users</a>
            <a href="index.php?url=admin/editMonsters" class="button">Modifier les Monstres</a>
            <a href="index.php?url=admin/editAdventures" class="button">Modifier les Aventures</a>
        </div>
    </div>
</section>


<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>