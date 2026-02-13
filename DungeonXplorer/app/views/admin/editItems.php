<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<body>
    <a href="index.php?url=admin/admin" class="primary-btn">Revenir sur la page d'administration</a>
    <h1>Gestion des Trésors</h1>
    
    <!-- Si un message est présent, on l'affiche -->
    <?php if (isset($message)): ?>
        <p class="alert-message"><?= htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter un trésor -->
    <a href="index.php?url=admin/addItem" class="secondary-btn">Ajouter un Trésor</a>

    <!-- Si des trésors existent, afficher la liste -->
    <?php if (isset($items) && !empty($items)): ?>
        <table class="form-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Poids</th>
                    <th>Valeur</th>
                    <th>Empilable</th>
                    <th>Prix</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['ITE_ID']); ?></td>
                        <td><?= htmlspecialchars($item['ITE_NAME']); ?></td>
                        <td><?= htmlspecialchars($item['ITE_DESCRIPTION']); ?></td>
                        <td><?= htmlspecialchars($item['ITE_POIDS']); ?></td>
                        <td><?= htmlspecialchars($item['ITE_VALEUR']); ?></td>
                        <td><?= $item['ITE_STACKABLE'] == 1 ? 'Oui' : 'Non'; ?></td>
                        <td><?= htmlspecialchars($item['ITE_PRIX']); ?></td>
                        <td>
                            <a href="index.php?url=admin/editItem/<?= $item['ITE_ID']; ?>" class="secondary-btn">Modifier</a>
                        </td>
                        <td>
                            <form action="index.php?url=admin/deleteItem" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trésor ?');">
                                <input type="hidden" name="ite_id" value="<?= $item['ITE_ID']; ?>">
                                <button class="delete-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php else: ?>
        <p>Aucun trésor trouvé.</p>
    <?php endif; ?>

</body>
<section></section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
