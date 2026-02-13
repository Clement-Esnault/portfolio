<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="choose-hero">
        <?php if (isset($errorMessage)): ?>
            <script>
                alert("<?php echo $errorMessage; ?>");
            </script>
        <?php elseif (!isset($_SESSION['hero_name'])): ?>
            <div class="divForm">
                <form action="choixHero" method="POST" class="formHero">
                    <div class="divHeroStats">
                        <container class="container_hero_infos">
                            <!-- Champs pour le nom et la biographie -->
                            <div class="heroInfo">
                                <label for="hero_name">Nom :</label>
                                <input type="text" id="hero_name" name="hero_name" placeholder="Entrez le nom de votre héros" required
                                    value="<?php echo isset($_POST['hero_name']) ? htmlspecialchars($_POST['hero_name']) : ''; ?>">
                            </div>
                            <div class="heroInfo">
                                <label for="hero_bio">Biographie :</label>
                                <input type="text" id="hero_bio" name="hero_bio" placeholder="Entrez la biographie de votre héros"
                                    value="<?php echo isset($_POST['hero_bio']) ? htmlspecialchars($_POST['hero_bio']) : ''; ?>">
                            </div>
                        </container>
                        <container class="container_hero_stats">
                            <p> 5 Points à allouer </p>
                            <!-- Champs pour les points -->
                            <div class="heroStat">
                                <label for="strength">Force :</label>
                                <input type="number" id="strength" name="strength" min="0" max="5" value="<?php echo isset($_POST['strength']) ? $_POST['strength'] : 0; ?>" required>
                            </div>
                            <div class="heroStat">
                                <label for="initiative">Initiative :</label>
                                <input type="number" id="initiative" name="initiative" min="0" max="5" value="<?php echo isset($_POST['initiative']) ? $_POST['initiative'] : 0; ?>" required>
                            </div>
                            <div class="heroStat">
                                <label for="attack">Attaque :</label>
                                <input type="number" id="attack" name="attack" min="0" max="5" value="<?php echo isset($_POST['attack']) ? $_POST['attack'] : 0; ?>" required>
                            </div>
                            <div class="heroStat">
                                <label for="pv">Points de Vie :</label>
                                <input type="number" id="pv" name="pv" min="0" max="5" value="<?php echo isset($_POST['pv']) ? $_POST['pv'] : 0; ?>" required>
                            </div>
                            <div class="heroStat">
                                <label for="mana">Points de Mana :</label>
                                <input type="number" id="mana" name="mana" min="0" max="5" value="<?php echo isset($_POST['mana']) ? $_POST['mana'] : 0; ?>" required>
                            </div>

                            <div class="heroStat">
                                <label for="total_points">Total des Points :</label>
                                <input type="number" id="total_points" name="total_points" value="0" max="5" readonly>
                            </div>

                            <div class="heroStat">
                                <button type="submit" name="submit_hero" id="submit_hero" disabled>Valider le choix du héros</button>
                            </div>
                        </container>
                    </div>

                    <div class="divHeroClass">
                        <container class="container_hero_class">
                            <div class="class-buttons">
                                <!-- Radio button pour les classes, et description qui s'affiche ou se rend invisible si radiobutton séléctionné ou pas -->
                                <?php if (!empty($classes)): ?>
                                    <?php foreach ($classes as $class): ?>
                                        <div class="class-option">
                                            <input type="radio" id="class_<?php echo $class['CLA_ID']; ?>" name="class_id" value="<?php echo $class['CLA_ID']; ?>" <?php echo (isset($_POST['class_id']) && $_POST['class_id'] == $class['CLA_ID']) ? 'checked' : ''; ?>>
                                            <label for="class_<?php echo $class['CLA_ID']; ?>"><?php echo htmlspecialchars($class['CLA_LIBELLE']); ?></label>
                                            <div class="class-description" id="desc_<?php echo $class['CLA_ID']; ?>" style="display: none;">
                                                <p><?php echo htmlspecialchars($class['CLA_DISCRIPTION']); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>Aucune classe disponible.</p>
                                <?php endif; ?>
                            </div>
                        </container>
                    </div>
                    
                    <div class="divHeroImg">
                        <img id="heroClassImage" src="public/img/class/default.png" alt="Image de la classe" style="max-width: 100%; height: auto;">
                        <p>Aperçu du héro</p>
                    </div>
                </form>
            </div>
        <?php else :?>
            <div class="flex-col">
                <p>Félicitations, vous avez créé votre héros !</p>
                <p>Cliquez ci-dessous pour commencer l'aventure :</p>
                <a href="chapterController" class="button">Commencer l'aventure</a>
            </div>
        <?php endif; ?>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>


<script>
    document.addEventListener('DOMContentLoaded', function () {

    // Fonction pour calculer le total des points
        function updateTotalPoints() {
            // Récupérer les valeurs des champs
            var strength = parseInt(document.getElementById("strength").value) || 0;
            var initiative = parseInt(document.getElementById("initiative").value) || 0;
            var attack = parseInt(document.getElementById("attack").value) || 0;
            var pv = parseInt(document.getElementById("pv").value) || 0;
            var mana = parseInt(document.getElementById("mana").value) || 0;

            // Calculer la somme des points
            var totalPoints = strength + initiative + attack + pv + mana;

            // Vérifier que le champ total_points existe
            var totalPointsInput = document.getElementById("total_points");
            if (totalPointsInput) {
                totalPointsInput.value = totalPoints;

                // Vérifier si le total dépasse 5 et ajuster la couleur
                if (totalPoints > 5) {
                    totalPointsInput.style.backgroundColor = '#ff0000'; // rouge clair
                } else {
                    totalPointsInput.style.backgroundColor = '#00ff00'; // vert clair
                }
            }

            // Désactiver/activer le bouton de soumission en fonction du total
            var submitButton = document.getElementById("submit_hero");
            if (totalPoints > 5) {
                submitButton.disabled = true;  // Désactiver le bouton si total > 5
            } else {
                submitButton.disabled = false; // Activer le bouton si total <= 5
            }
        }

        var inputs = ["strength", "initiative", "attack", "pv", "mana"];
        inputs.forEach(function(inputId) {
            var inputElement = document.getElementById(inputId);
            if (inputElement) {
                inputElement.addEventListener("input", updateTotalPoints);
            }
        });

        updateTotalPoints();

        ///////////////////////////////////////
        // Afficher image et desc des clases //
        ///////////////////////////////////////

        function updateClassImage(classId) {
            const classImages = {
                '1': 'public/img/class/guerrier.png', 
                '2': 'public/img/class/mage.png', 
                '3': 'public/img/class/voleur.png', 
                '4': 'public/img/class/clerc.png' 
            };

            const imageSrc = classImages[classId] || '';

            const heroClassImage = document.getElementById('heroClassImage');
            heroClassImage.src = imageSrc;
        }

        document.querySelectorAll('input[name="class_id"]').forEach(function (radio) {
            radio.addEventListener('change', function () {

                updateClassImage(this.value);

                // Cacher les descriptions :
                document.querySelectorAll('.class-description').forEach(function (desc) {
                    desc.style.display = 'none';
                });

                // Afficher la description de la classe sélectionnée seulement :
                const classId = this.value;
                document.getElementById('desc_' + classId).style.display = 'block';
            });
        });

        // Si une classe est déjà sélectionnée, afficher sa description et son image
        if (document.querySelector('input[name="class_id"]:checked')) {
            const selectedClassId = document.querySelector('input[name="class_id"]:checked').value;
            document.getElementById('desc_' + selectedClassId).style.display = 'block';
            updateClassImage(selectedClassId);
        }

    });
 </script>
