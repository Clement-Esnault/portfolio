<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="admin-section">
    <div class="container">
        <a href="index.php?url=admin/admin" class="primary-btn">Revenir sur la page d'administration</a>
        <h2>Supprimer un Utilisateur</h2>

        <!-- Affichage des utilisateurs à modifier -->
        <?php if (isset($users) && !empty($users)): ?>
            <h1 class="page-title">Gestion des Utilisateurs</h1>

            <!-- Affichage des messages -->
            <?php if (isset($message)): ?>
                <div class="alert-message"><?php echo $message; ?></div>
            <?php endif; ?>

            <!-- Tableau des utilisateurs -->
            <table class="form-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pseudo</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['COM_ID']); ?></td>
                            <td><?php echo htmlspecialchars($user['COM_PSEUDO']); ?></td>
                            <td><?php echo htmlspecialchars($user['COM_EMAIL']); ?></td>
                            <td><?php echo $user['COM_TYPE'] == 'A' ? 'Administrateur' : 'Utilisateur'; ?></td>
                            
                            <td>
                                <form method="POST" action="index.php?url=admin/deleteUser/<?php echo $user['COM_ID']; ?>" 
                                    onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                    <button type="submit" class="delete-btn">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <p>Aucun utilisateur trouvé.</p>
        <?php endif; ?>

        <!-- Affichage des messages de succès ou erreur -->
        <?php if (isset($_GET['message'])): ?>
            <div class="message">
                <p><?= htmlspecialchars($_GET['message']) ?></p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>
