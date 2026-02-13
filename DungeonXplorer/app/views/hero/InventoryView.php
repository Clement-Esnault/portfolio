<?php include(ROOT_DIR . 'app/views/includes/header.php'); ?>

<section class="flex-col">
    <div class="inventory">
        <div class="divItems">
            <?php foreach ($items as $item): ?>
                <div class="invItem" onclick="selectItem(<?php echo $item['ITE_ID']; ?>)">
                    <img id="heroClassImage" src="public/img/items/<?php echo $item['ITE_ID']; ?>.png"  alt="Image de l'item">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="divDescItem">
            <p id="itemName"></p>
            <p id="itemType"></p>     
            <p id="itemDescription"></p>  
            <p id="itemWeight"></p>   
            <p id="itemValue"></p>       
            <p id="itemPrice"></p>     
        </div>
        <div class="divPlayerStatus">
            <h2>Statistiques de <?php echo htmlspecialchars($_SESSION['hero_name']); ?></h2>
            <div class="flex-row">
                <h3 id="statName">Classe</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['CLA_LIBELLE']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Niveau</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['HER_LEVEL']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">XP</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['HER_XP']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">PV</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['ENT_PV']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Mana</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['ENT_MANA']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Force</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['ENT_STRENGTH']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Initiative</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['ENT_INITIATIVE']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Capacité</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['ENT_CAPACITY']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Attaque</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['ENT_ATTACK']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Monnaie</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['HER_MONNAIE']); ?></h4>
            </div>
            <div class="flex-row">
                <h3 id="statName">Poids Max</h3>
                <h4 class="stat"><?php echo htmlspecialchars($stats['CLA_POIDS_MAX']); ?></h4>
            </div>
        </div>
        <a class="button bottom-right" href="chapterController" class="button">Retour au chapitre</a>

    </div>
</section>

<?php include(ROOT_DIR . 'app/views/includes/footer.php'); ?>

<script>

    const types = ['Rien', 'Arme', 'Armure', 'Nourriture', 'Potion', 'Trésor', 'Bouclier']

    function selectItem(itemId) {
        var items = <?php echo json_encode($items); ?>;
        var selectedItem = items.find(item => item.ITE_ID === itemId);

        if (selectedItem) {
            document.getElementById('itemName').textContent = selectedItem.ITE_NAME;
            document.getElementById('itemType').textContent = "Type: " + types[selectedItem.TYP_ITEM_ID];
            document.getElementById('itemDescription').textContent = "Description: " + selectedItem.ITE_DESCRIPTION;
            document.getElementById('itemWeight').textContent = "Poids: " + selectedItem.ITE_POIDS + " kg";
            document.getElementById('itemValue').textContent = "Valeur: " + selectedItem.ITE_VALEUR;
            document.getElementById('itemPrice').textContent = "Prix: " + selectedItem.ITE_PRIX + " écus";

            // Retirer selected aux elements
            var itemElements = document.querySelectorAll('.invItem');
            itemElements.forEach(item => {
                item.classList.remove('selected');
            });

            // Ajouter la classe "selected" seulement à l'item cliqué
            var selectedItemElement = document.querySelector('.invItem img[src="public/img/items/' + selectedItem.ITE_ID + '.png"]').parentElement;
            selectedItemElement.classList.add('selected');
        }
    }
</script>