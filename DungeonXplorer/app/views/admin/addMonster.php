<?php
// Inclure le fichier de configuration ou la connexion à la base de données
include(ROOT_DIR . 'app/views/includes/header.php'); 

// Affichage d'un message si il y a une erreur
if (isset($_GET['error'])) {
    echo "<p class='error'>Erreur : " . htmlspecialchars($_GET['error']) . "</p>";
}

// Affichage d'un message si l'ajout est réussi
if (isset($_GET['message'])) {
    echo "<p class='success'>" . htmlspecialchars($_GET['message']) . "</p>";
}
?>
<a href="index.php?url=admin/editMonsters" class="primary-btn">Revenir sur la page des monstres</a>
<h1>Ajouter un Monstre</h1>
<form action="index.php?url=admin/insertMonster" method="POST">
    <label for="ent_nom">Nom du Monstre :</label>
    <input type="text" id="ent_nom" name="ent_nom" required>

    <label for="ent_description">Description du Monstre :</label>
    <textarea id="ent_description" name="ent_description" required></textarea>

    <label for="ent_pv">Points de Vie :</label>
    <input type="number" id="ent_pv" name="ent_pv" required>

    <label for="ent_mana">Mana :</label>
    <input type="number" id="ent_mana" name="ent_mana" required>

    <label for="ent_strength">Force :</label>
    <input type="number" id="ent_strength" name="ent_strength" required>

    <label for="ent_initiative">Initiative :</label>
    <input type="number" id="ent_initiative" name="ent_initiative" required>

    <label for="ent_capacity">Capacité :</label>
    <input type="text" id="ent_capacity" name="ent_capacity" required>

    <label for="ent_attack">Attaque :</label>
    <input type="number" id="ent_attack" name="ent_attack" required>

    <label for="ent_pv_max">Points de Vie Max :</label>
    <input type="number" id="ent_pv_max" name="ent_pv_max" required>

    <label for="ent_mana_max">Mana Max :</label>
    <input type="number" id="ent_mana_max" name="ent_mana_max" required>

    <input type="submit" value="Ajouter le Monstre">
</form>
<section></section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
