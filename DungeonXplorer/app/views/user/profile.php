<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="profile-section">
    <div class="container profile-container">
        <h2>Profil</h2>
        <div class="profile-container">
            <div class="profile-info">
                <h3>Vos informations :</h3>
                <p><strong>Pseudo :</strong> <?= htmlspecialchars($_SESSION['pseudo']); ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($_SESSION['email']); ?></p>
            </div>

            <div class="profile-actions">
                <a href="continue" class="primary-btn">
                    🔄 Continuer l’aventure
                </a>
                <a href="logoff" class="secondary-btn">
                    Se Deconnecter
                </a>
                <form action="index.php?url=profile/deleteAccount" method="post" onsubmit="return confirmDeletion()">
                    <button class="delete-btn" type="submit">Supprimer mon compte</button>
                </form>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'G'): ?>
                    <a href="admin" class="primary-btn">Panneau Admin</a>
                <?php endif; ?>

                <div class="modal" id="confirmModal">
                    <div class="modal-content">
                        <h2>Confirmation</h2>
                        <p>Cette action est irréversible. Voulez-vous continuer ?</p>
                        <div class="modal-actions">
                            <button class="cancel-btn" id="cancelBtn">Annuler</button>
                            <a href="delete" class="confirm-btn">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="heroes-section">
            <h3>Vos Héros :</h3>
            <div class="heroes-container">
                <?php
                if (isset($heroes) && !empty($heroes)) {
                    foreach ($heroes as $hero) : ?>
                        <div class="hero-card">
                            <p><strong>Nom :</strong> <?= htmlspecialchars($hero['ENT_NOM']); ?></p>
                            <p><strong>Classe :</strong> <?= htmlspecialchars($hero['CLA_LIBELLE']); ?></p>
                            <p><strong>Niveau :</strong> <?= htmlspecialchars($hero['HER_LEVEL']); ?></p>
                            <p><strong>Biographie :</strong> <?= htmlspecialchars($hero['HER_BIOGRAPHY']); ?></p>
                            <form action="index.php?url=profile/deleteHero" method="post">
                                <input type="hidden" name="ent_id" value="<?= $hero['ENT_ID']; ?>">
                                <button class="delete-btn">Supprimer ce héros</button>
                            </form>
                        </div>
                    <?php endforeach;
                } else { ?>
                    <p>Aucun héros pour le moment.</p>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>

<script>
    // Fonction de confirmation avant suprpession du compte
    function confirmDeletion() {
        return confirm("Attention : Cette action est irréversible. Voulez-vous vraiment supprimer votre compte et toutes ses données associées ?");
    }
</script>