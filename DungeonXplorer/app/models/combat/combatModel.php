<?php

class CombatModel {

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }


    public static function initiative(Entity $a, Entity $b): Entity {
        $initA = rand(1, 6) + $a->getInitiative();
        $initB = rand(1, 6) + $b->getInitiative();

        return ($initA >= $initB) ? $a : $b;
    }

    public static function attaquePhysique(Entity $attaquant, Entity $defenseur): int {
        $attaque = $attaquant->attaquePhysique();
        $defense = $defenseur->defense();

        $degats = max(0, $attaque - $defense);
        $defenseur->subirDegats($degats);

        return $degats;
    }

    public static function attaqueMagique(Entity $attaquant, Entity $defenseur): int {
        // Vérification du mana
        if ($attaquant->getMana() <= 0) {
            return 0; // Pas de mana, pas de dégâts
        }
    
        // Choisir un sort au hasard (ou sélectionner un sort spécifique)
        $sort = Combat::choisirSort($attaquant);
        if ($sort) {
            // Calculer les dégâts
            $degats = $sort['ACT_VALEUR'];
    
            // Réduire le mana du héros en fonction du coût du sort
            $manaCout = $sort['ACT_COUT'];
            $attaquant->setMana($attaquant->getMana() - $manaCout);
    
            // Appliquer les dégâts au monstre
            $defenseur->subirDegats($degats);
    
            // Ajouter un log de l'action
            $_SESSION['combat_log'][] = "{$attaquant->getNom()} lance le sort {$sort['ACT_LIBELLE']} sur {$defenseur->getNom()} et inflige $degats dégâts.";
            
            return $degats;
        }
        
        return 0; // Pas de sort sélectionné
    }
    
    public static function choisirSort(Entity $hero): ?array {
        // Logique pour choisir un sort (par exemple, on peut choisir le premier sort disponible)
        $spells = $hero->getSpells($hero->getId());
        if (empty($spells)) {
            return null;
        }
        
        // Retourner le premier sort disponible (à ajuster en fonction de la logique)
        return $spells;
    }
    

    /*public static function utiliserPotion($idHero, string $potionName): int {
        $potions = EntityBDD::getPotion($idHero);  // Récupère les potions du héros
    
        $potion = null;
        foreach ($potions as $p) {
            if ($p['ITE_NAME'] === $potionName) {
                $potion = $p;
                break;
            }
        }
    
        if (!$potion) {
            echo "Potion non trouvée dans l'inventaire.";
            return 0;
        }
    
        // Déterminer l'effet de la potion
        if ($potion['ITE_NAME'] == 'Potion de PV') {
            // Restauration de PV
            $restauration = $hero->getPvMax() * 0.5;  // Exemple : 50% des PV max
            if ($hero->getPv() < $hero->getPvMax()) {
                $nouveauPv = min($hero->getPvMax(), $hero->getPv() + $restauration);
                $hero->setPv($nouveauPv);
                $val = $nouveauPv - $hero->getPv();  // Montant récupéré en PV
            } else {
                $val = 0;  // Si les PV sont déjà au maximum
            }
        } elseif ($potion['ITE_NAME'] == 'Potion de Mana') {
            // Restauration de Mana
            $restauration = $hero->getManaMax() * 0.5;  // Exemple : 50% du Mana max
            if ($hero->getMana() < $hero->getManaMax()) {
                $nouveauMana = min($hero->getManaMax(), $hero->getMana() + $restauration);
                $hero->setMana($nouveauMana);
                $val = $nouveauMana - $hero->getMana();  // Montant récupéré en Mana
            } else {
                $val = 0;  // Si le Mana est déjà au maximum
            }
        }
    
        // Retirer la potion de l'inventaire après l'utilisation
        EntityBDD::retirerPotionDuInventaire($hero->getId(), $potion['COM_RANG']);
        
        return $val;  // Retourne la valeur récupérée (PV ou Mana)
    }*/
    
    
      public static function finCombat(Entity $hero, Entity $monstre): bool {
        if ($hero->getPv() <= 0 || $monstre->getPv() <= 0) {
            $_SESSION['combat_log'][] = "⚔️ Le combat est terminé !";
            return true; // Fin du combat
        }
    
        return false;
    }
    
    public function isFinished(Entity $hero, Entity $monster): bool {
        // Si les PV du héros ou du monstre sont à 0 ou en dessous, le combat est terminé
        if ($hero->getPv() <= 0 || $monster->getPv() <= 0) {
            return true; // Combat terminé
        }
        return false; // Le combat continue
    }

    public function getMonsterInChapter(int $advId, int $chaId): ?array
    {
        $sql = "SELECT i.ENT_ID, e.ENT_NOM
                FROM DUN_INTRODUCE i
                JOIN DUN_ENTITY e ON i.ENT_ID = e.ENT_ID
                WHERE i.ADV_ID = ? AND i.CHA_ID = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$advId, $chaId]);

        $monster = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $monster ?: null;
    }

}
