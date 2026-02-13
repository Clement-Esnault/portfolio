<?php

class AdventureModel
{
    protected $db;
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function getSavedAdventures($userId) {
        $sql = "
            SELECT 
                s.SAV_ID, 
                s.ADV_ID, 
                s.CHA_ID,
                a.ADV_LIBELLE, 
                h.ENT_NOM,
                h.ENT_ID
            FROM DUN_SAVE s
            JOIN DUN_ADVENTURE a ON s.ADV_ID = a.ADV_ID
            JOIN DUN_ENTITY h ON s.ENT_ID = h.ENT_ID
            WHERE s.COM_ID = :user_id
            ORDER BY s.SAV_ID DESC;
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHeroIdFromSave($savId) {
        $sql = "
            SELECT ENT_ID
            FROM DUN_SAVE
            WHERE SAV_ID = :sav_id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':sav_id', $savId, PDO::PARAM_INT);
        $stmt->execute();
        $hero = $stmt->fetch(PDO::FETCH_ASSOC);

        return $hero ? $hero['ENT_ID'] : null;
    }

    // Récupère toutes les aventures disponibles
    public function getAllAdventures() {
        $sql = "SELECT ADV_ID, ADV_LIBELLE FROM DUN_ADVENTURE";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupère le premier chapitre d'une aventure
    public function getFirstChapter($advId) {
        $sql = "SELECT CHA_ID FROM DUN_CHAPTER WHERE ADV_ID = :adv_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':adv_id', $advId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>