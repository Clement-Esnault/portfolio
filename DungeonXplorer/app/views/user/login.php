<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

    <section>
        <div class="container">
            <h2>Se connecter</h2>
            <form action="confirmLogin" method="post">
                <div class="form-group">
                    <label for="email">Adresse e-mail :</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="">Se connecter</button>
            </form>
            <p>Pas encore de compte ?</p>
            <a href="signup">
                S'inscrire
            </a>
        </div>
    </section>
    <?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>