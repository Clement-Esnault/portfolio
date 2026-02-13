<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <a href="index.php?url=admin/admin" class="primary-btn">Revenir sur la page d'administration</a>
    <h1>Gestion des Monstres</h1>
    
    <!-- Si un message est présent, on l'affiche -->
    <?php if (isset($_GET['message'])): ?>
        <p class="alert-message"><?= htmlspecialchars($_GET['message']); ?></p>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <p class="alert-error"><?= htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter un monstre -->
    <a href="index.php?url=admin/addMonster" class="secondary-btn">Ajouter un Monstre</a>

    <!-- Si des monstres existent, afficher la liste -->
    <?php if (isset($monsters) && !empty($monsters)): ?>
        <table class="form-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>PV</th>
                    <th>Mana</th>
                    <th>Force</th>
                    <th>Initiative</th>
                    <th>Capacité</th>
                    <th>Attaque</th>
                    <th>PV Max</th>
                    <th>Mana Max</th>
                    <th>Loot</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($monsters as $monster): ?>
                    <tr>
                        <td><?= htmlspecialchars($monster['ENT_NOM']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_DESCRIPTION']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_PV']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_MANA']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_STRENGTH']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_INITIATIVE']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_CAPACITY']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_ATTACK']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_PV_MAX']); ?></td>
                        <td><?= htmlspecialchars($monster['ENT_MANA_MAX']); ?></td>
                        <td>
                            <?php 
                                // Vérifie si un loot est associé à ce monstre
                                $lootFound = false;
                                foreach ($loots as $loot) {
                                    if ($loot['MON_LOOT_ID'] == $monster['MON_LOOT_ID']) {
                                        // Si un loot est trouvé, on l'affiche
                                        echo  htmlspecialchars($loot['ITE_NAME']);
                                        $lootFound = true;
                                        break;
                                    }
                                }
                                
                                // Si aucun loot n'est trouvé, afficher "Aucun"
                                if (!$lootFound) {
                                    echo "Aucun";
                                }
                            ?>
                        </td>
                        <td>
                            <a href="index.php?url=admin/editMonster/<?= $monster['ENT_ID']; ?>" class="secondary-btn">Modifier</a>
                        </td>
                        <td>
                            <form action="index.php?url=admin/deleteMonster" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce monstre ?');">
                                <input type="hidden" name="ent_id" value="<?= $monster['ENT_ID']; ?>">
                                <button class="delete-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>Aucun monstre trouvé.</p>
    <?php endif; ?>
</body>
<section></section>
<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
