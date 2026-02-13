<?php

require_once(ROOT_DIR . 'app/models/combat/EntityModel.php');
require_once(ROOT_DIR . 'app/models/combat/combatModel.php');

class CombatController {

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function lancerCombat(): void {
        if (!isset($_SESSION['hero_id'])) {
            die("Aucun héros en session");
        }

        // Créer une instance de EntityModel pour interagir avec la base de données
        $repo = new EntityModel($this->db);

        // --- Chargement des entités ---
        $monstreId = $_SESSION['monster_id'] ?? null;
        if (!$monstreId) {
            die("Aucun monstre à combattre.");
        }

        $hero = $repo->findById($_SESSION['hero_id']);
        $monstre = $repo->findById($monstreId);

        if (!$hero || !$monstre) {
            die("Entité introuvable");
        }

        // --- Gestion de l'état du combat ---
        $resetCombat = false;
        if (!isset($_SESSION['combat_log'])) {
            $resetCombat = true;
        } elseif (!empty($_SESSION['combat_ended'])) {
            $resetCombat = true;
        } elseif (!isset($_SESSION['combat_monster_id']) || $_SESSION['combat_monster_id'] != $monstreId) {
            // Nouveau monstre → reset
            $resetCombat = true;
        }

        if ($resetCombat) {
            $_SESSION['combat_log'] = ["Le combat commence…"];
            $_SESSION['combat_ended'] = false;
            $_SESSION['hero_pv'] = (int) $hero->getPv();
            $_SESSION['monstre_pv'] = (int) $monstre->getPv();
            $_SESSION['combat_monster_id'] = $monstreId; // pour savoir quel monstre est en cours
        }

        // --- Restauration des PV depuis la session ---
        $hero->setPv($_SESSION['hero_pv']);
        $monstre->setPv($_SESSION['monstre_pv']);

        // --- Combat déjà terminé → affichage simple ---
        if (!empty($_SESSION['combat_ended'])) {
            $combatTermine = true;
            $combat_log = implode('<br>', $_SESSION['combat_log']);
            include ROOT_DIR . 'app/views/combat/Combat.php';
            return;
        }

        // --- Action du joueur ---
        $action = $_GET['action'] ?? null;

        if ($action) {

            // --- Tour du héros ---
            switch ($action) {
                case 'attack':
                    $degats = CombatModel::attaquePhysique($hero, $monstre);
                    $_SESSION['combat_log'][] =
                        "{$hero->getNom()} attaque {$monstre->getNom()} et inflige $degats dégâts.";
                    break;

                case 'magic':
                    $spellId = $_POST['selected_spell_id'] ?? null;
                    if ($spellId) {
                        $spells = $repo->getSpells($hero->getId());
                        $selectedSpell = null;
                
                        foreach ($spells as $spell) {
                            if ($spell['ACT_ID'] == $spellId) {
                                $selectedSpell = $spell;
                                break;
                            }
                        }
                
                        if ($selectedSpell) {
                            // Si le héros a assez de mana
                            if ($hero->getMana() >= $selectedSpell['ACT_COUT']) {
                                $degats = $selectedSpell['ACT_VALEUR'];
                                // Appliquer les dégâts au monstre
                                $monstre->subirDegats($degats);
                
                                // Réduire le mana du héros
                                $hero->setMana($hero->getMana() - $selectedSpell['ACT_COUT']);
                
                                // Log de combat
                                $_SESSION['combat_log'][] = "{$hero->getNom()} lance le sort {$selectedSpell['ACT_LIBELLE']} sur {$monstre->getNom()} et inflige $degats dégâts.";
                
                                // Mise à jour des PV dans la session et la base de données
                                $_SESSION['hero_pv'] = $hero->getPv();
                                $_SESSION['monstre_pv'] = $monstre->getPv();
                                $repo->updatePvInDb($hero);  // Mise à jour des PV du héros dans la DB
                
                                // Vérifier si le monstre est mort
                                if ($monstre->getPv() <= 0) {
                                    $_SESSION['combat_log'][] = "{$monstre->getNom()} est mort!";
                                    $_SESSION['combat_ended'] = true;
                                }
                            } else {
                                $_SESSION['combat_log'][] = "{$hero->getNom()} n'a pas assez de mana!";
                            }
                        } else {
                            $_SESSION['combat_log'][] = "Sort invalide!";
                        }
                    }

                    case 'potion':
                        $selectedPotionName = $_POST['selected_potion_name'] ?? null;
                    
                        if ($selectedPotionName) {
                            // Utiliser la méthode pour appliquer la potion
                            $val = $repo->utiliserPotion($hero, $selectedPotionName);
                    
                            if ($val > 0) {
                                // Enregistrer un log de l'action avec un message détaillé
                                $_SESSION['combat_log'][] = "{$hero->getNom()} boit une potion ($selectedPotionName) et récupère $val PV ou Mana.";
                            } else {
                                // Si aucune valeur n'a été récupérée, afficher que la potion n'a pas eu d'effet
                                $_SESSION['combat_log'][] = "{$hero->getNom()} tente de boire une potion ($selectedPotionName), mais cela n'a pas d'effet (potions inutilisables ou déjà à plein).";
                            }
                        } 
                        break;
            }

            // --- Tour du monstre (seulement si vivant) ---
            if ($monstre->getPv() > 0 && $hero->getPv() > 0) {
                $degats = CombatModel::attaquePhysique($monstre, $hero);
                $_SESSION['combat_log'][] =
                    "{$monstre->getNom()} attaque {$hero->getNom()} et inflige $degats dégâts.";
                
            }

            // --- Sauvegarde des PV ---
            $_SESSION['hero_pv'] = $hero->getPv();
            $_SESSION['monstre_pv'] = $monstre->getPv();

            $repo->updatePvInDb($hero);
            $repo->updateManaInDb($hero);

            // --- Fin du combat ---
            if ($hero->getPv() <= 0 || $monstre->getPv() <= 0) {
                $_SESSION['combat_log'][] = "⚔️ Le combat est terminé !";
                $_SESSION['combat_ended'] = true;
            // Retourner au chapitre précédent
               // $_SESSION['chapter_id'] = $_SESSION['previous_chapter_id'];
            }
        }

        $combatTermine = $_SESSION['combat_ended'];
        $combat_log = implode('<br>', $_SESSION['combat_log']);

        $spells = $repo->getSpells($hero->getId());
        $potions = $repo->getPotion($hero->getId());

        include ROOT_DIR . 'app/views/combat/Combat.php';

        if ($combatTermine) {
            unset($_SESSION['monster_id']);
            unset($_SESSION['monster_name']);
            unset($_SESSION['combat_monster_id']);
            unset($_SESSION['combat_log']);

            unset($_SESSION['monstre_pv']);
        }
    }

    
}
?>
