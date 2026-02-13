<?php

class InventoryModel
{
    protected $db;
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getInventory($entId) {
        $sql = "SELECT
        c.ITE_ID,
        c.TYP_ITEM_ID,
        ITE_NAME,
        ITE_DESCRIPTION,
        ITE_POIDS,
        ITE_VALEUR,
        ITE_STACKABLE,
        ITE_PRIX
        from DUN_COMPOSE c
        join DUN_ITEM USING (ITE_ID)
        where ENT_ID = :entId
        ;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':entId', $entId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createInventory($entityId) {
        $sqlInsertInventory = "INSERT INTO DUN_INVENTORY (ENT_ID, INV_ID, INV_CAPACITY) VALUES (?, 1, 99)";
        $stmtInsert = $this->db->prepare($sqlInsertInventory);
        $stmtInsert->execute([$entityId]);
    }
    
    public function insertCompose($entityId, $itemId, $typeItemId, $nb_item) {
        $sqlInsertCompose = "INSERT INTO DUN_COMPOSE (TYP_ITEM_ID, ITE_ID, ENT_ID, INV_ID, NB_ITEM) VALUES (?, ?, ?, 1, ?)";
        $stmtInsert = $this->db->prepare($sqlInsertCompose);
        $stmtInsert->execute([$typeItemId, $itemId, $entityId, $nb_item]);
    }

    public function getInventoryStats($entId) {
        $sql = "SELECT
        c.ITE_ID,
        c.TYP_ITEM_ID,
        ITE_NAME,
        ITE_DESCRIPTION,
        ITE_POIDS,
        ITE_VALEUR,
        ITE_STACKABLE,
        ITE_PRIX
        from DUN_COMPOSE c
        join DUN_ITEM USING (ITE_ID)
        where ENT_ID = :entId
        ;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':entId', $entId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPlayerStats($entId) {
        $sql = "SELECT 
            ENT_NOM,
            ENT_PV,
            ENT_MANA,
            ENT_STRENGTH,
            ENT_INITIATIVE,
            ENT_CAPACITY,
            ENT_ATTACK,
            HER_MONNAIE,
            HER_XP,
            HER_LEVEL,
            CLA_LIBELLE,
            CLA_POIDS_MAX
        FROM `DUN_ENTITY` E
        JOIN DUN_HERO H USING(ENT_ID)
        JOIN DUN_CLASS USING (CLA_ID)
        WHERE ENT_ID = :entId;
        ";
    
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':entId', $entId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    
    
    
}
?>