<?php
require_once ROOT_DIR . 'app/models/combat/Entity.php';

class EntityModel {

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Trouver une entité par son ID
    public function findById(int $id): ?Entity {
        $stmt = $this->db->prepare("SELECT * FROM DUN_ENTITY WHERE ENT_ID = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Entity($data) : null;
    }

    // Récupérer les sorts d'une entité (en l'occurrence, un héros)
    public function getSpells(int $entId): array {
        $sql = "SELECT ACT_ID,ACT_LIBELLE, ACT_COUT, ACT_VALEUR
                FROM DUN_ENTITY
                JOIN DUN_HERO USING(ENT_ID)
                JOIN DUN_CLASS USING(CLA_ID)
                JOIN DUN_ALLOW USING(CLA_ID)
                JOIN DUN_ACTION USING(ACT_ID)
                WHERE ENT_ID = :ent_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ent_id', $entId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    // Mettre à jour les PV de l'entité dans la base de données
    public function updatePvInDb(Entity $entity): void {
        $newPv = $entity->getPv(); // Stocke la valeur dans une variable
        $id = $entity->getId();
        $sql = "UPDATE DUN_ENTITY SET ENT_PV = :new_pv WHERE ENT_ID = :entity_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':new_pv', $newPv, PDO::PARAM_INT); // Passe la variable à bindParam
        $stmt->bindParam(':entity_id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
    public function updateManaInDb(Entity $entity): void {
        $newMana = $entity->getMana(); // Stocke la valeur dans une variable
        $id = $entity->getId();
        $sql = "UPDATE DUN_ENTITY SET ENT_MANA = :new_mana WHERE ENT_ID = :entity_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':new_mana', $newMana, PDO::PARAM_INT); // Passe la variable à bindParam
        $stmt->bindParam(':entity_id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Récupérer un monstre dans un chapitre spécifique
    public function getMonsterInChapter(int $advId, int $chaId): ?array {
        $sql = "SELECT i.ENT_ID, e.ENT_NOM
                FROM DUN_INTRODUCE i
                JOIN DUN_ENTITY e ON i.ENT_ID = e.ENT_ID
                WHERE i.ADV_ID = ? AND i.CHA_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$advId, $chaId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getPotion(int $entId): array {
        $sql = "SELECT it.ITE_NAME, it.ITE_ID, c.NB_ITEM
                FROM DUN_ENTITY e
                JOIN DUN_INVENTORY i ON e.ENT_ID = i.ENT_ID
                JOIN DUN_COMPOSE c ON e.ENT_ID = c.ENT_ID
                JOIN DUN_ITEM it ON it.ITE_ID = c.ITE_ID
                JOIN DUN_ITEM_TYPE t ON t.TYP_ITEM_ID = it.TYP_ITEM_ID
                WHERE t.TYP_ITEM_ID = 4
                AND e.ENT_ID = :ent_id";  // Préciser 'e' pour ENT_ID
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ent_id', $entId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    
    

    public function retirerObjetInventaire(int $entId, int $idItem): void {
        // Préparer la requête SQL pour retirer l'objet basé sur l'ENT_ID, ITE_ID et COM_RANG
        $sql = "UPDATE DUN_COMPOSE
                SET NB_ITEM = NB_ITEM-1
                WHERE ENT_ID = :ent_id AND ITE_ID = :ite_id";
    
        // Préparer et exécuter la requête
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ent_id', $entId, PDO::PARAM_INT);
        $stmt->bindParam(':ite_id', $idItem, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function utiliserPotion(Entity $hero, string $potionName): int {
        // Récupérer les potions du héros
        $potions = $this->getPotion($hero->getId()); 
        
        $potion = null;
        foreach ($potions as $p) {
            if ($p['ITE_NAME'] === $potionName) {
                $potion = $p;
                break;
            }
        }
    
        // Si la potion n'est pas trouvée
        if (!$potion) {
            echo "Potion non trouvée dans l'inventaire.";
            return 0;  // Aucun effet
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
    
        // Si une valeur a été récupérée, retirer la potion de l'inventaire
        if ($val > 0) {
            $this->retirerObjetDuInventaire($hero->getId(), $potion['ITE_ID']);
        }
    
        return $val;  // Retourne la valeur récupérée (PV ou Mana)
    }
    



}

?>
