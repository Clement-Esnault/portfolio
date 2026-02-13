<?php include_once(ROOT_DIR . 'app/views/includes/header.php'); ?>
<div class="combat-container">
    <h2>⚔️ Combat</h2>

    <div class="combat-info">
        <!-- Héros -->
        <div class="combatant <?= $hero ? 'attacker' : '' ?>">
            <h3><?= $hero->getNom() ?></h3>
            <div class="stats">
                <span>PV: <?= $hero->getPv() ?>/<?= $hero->getPvMax() ?></span>
                <span>Mana: <?= $hero->getMana() ?>/<?= $hero->getManaMax() ?></span>
            </div>
            <div class="bar-container">
                <div class="bar-pv" style="width: <?= ($hero->getPv() / $hero->getPvMax())*100 ?>%;"></div>
            </div>
            <div class="bar-container">
                <div class="bar-mana" style="width: <?= ($hero->getManaMax() > 0 ? ($hero->getMana() / $hero->getManaMax())*100 : 0) ?>%;"></div>
            </div>
        </div>

        <!-- Monstre -->
        <div class="combatant <?= $monstre ? 'attacker' : '' ?>">
            
            <h3><?= $monstre->getNom() ?></h3>
            <div class="stats">
                <span>PV: <?= $monstre->getPv() ?>/<?= $monstre->getPvMax() ?></span>
                <span>Mana: <?= $monstre->getMana() ?>/<?= $monstre->getManaMax() ?></span>
            </div>
            <div class="bar-container">
                <div class="bar-pv" style="width: <?= ($monstre->getPv() / $monstre->getPvMax())*100 ?>%;"></div>
            </div>
            <div class="bar-container">
                <div class="bar-mana" style="width: <?= ($monstre->getManaMax() > 0 ? ($monstre->getMana() / $monstre->getManaMax())*100 : 0) ?>%;"></div>
            </div>
        </div>
    </div>

    <!-- Journal de combat -->
    <div id="combat-log">
        <h3>Journal de combat</h3>
        <div id="combat-log-content">
            <!-- Les actions seront injectées ici via PHP ou JS -->
            <?= $combat_log ?? 'Le combat commence…' ?>
        </div>
    </div>

    <!-- Actions du joueur -->
    <div class="action-buttons">
        <button class="attack-btn" <?= $combatTermine ? 'disabled' : '' ?> onclick="location.href='?url=combat&action=attack'">Attaque</button>
        <?php if (!$combatTermine && $hero->getMana() > 0): ?>
            <form method="post" action="?url=combat&action=magic">
                <select name="selected_spell_id">
                    <option value="">Sélectionner un sort</option>
                    <?php foreach ($spells as $spell): ?>
                        <option value="<?= $spell['ACT_ID'] ?>"><?= $spell['ACT_LIBELLE'] ?> (Mana: <?= $spell['ACT_COUT'] ?>)</option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="magic-btn">Lancer le sort</button>
            </form>
        <?php endif; ?>
        <button class="potion-btn" <?= $combatTermine ? 'disabled' : '' ?> onclick="location.href='?url=combat&action=potion'">Potion</button>
        <?php if (!$combatTermine): ?>
            <form method="post" action="?url=combat&action=potion">
                <select name="selected_potion_name">
                    <option value="">Boire une potion</option>
                    <?php foreach ($potions as $potion): ?>
                        <option value="<?= $potion['ITE_NAME'] ?>"><?= $potion['ITE_NAME'] ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="magic-btn">Boire la potion</button>
            </form>
        <?php endif; ?>
    </div>

    <?php if (($combatTermine) && ($hero->getPv() > 0)): ?>
        <div>
            <a href="index.php?url=chapterController" class="primary-btn">
                ⚔️ Vous avez gagnez.
            </a>
        <div>
    <?php elseif (($combatTermine) && ($hero->getPv() <= 0)): ?>
        <div class="primary-btn">
            <a href="index.php?url=home" class="primary-btn">
                ⚔️ Vous êtes mort
            </a>
        <div>
    <?php endif; ?>
</div>
<section></section>
<?php include_once(ROOT_DIR . 'app/views/includes/footer.php'); ?>