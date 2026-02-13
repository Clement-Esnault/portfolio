<?php

class HeroModel {

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Récupérer les classes disponibles
    public function getClasses() {
        $sql = "SELECT CLA_ID, CLA_LIBELLE, CLA_DISCRIPTION FROM DUN_CLASS";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer les statistiques d'une classe par son ID
    public function getClassStats($classId) {
        $sql = "SELECT * FROM DUN_CLASS WHERE CLA_ID = :class_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':class_id', $classId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insérer une entité (le héros)
    public function insertEntity($heroName, $baseStats, $finalStats) {
        $sql = "INSERT INTO DUN_ENTITY (ENT_NOM, ENT_DESCRIPTION, ENT_PV, ENT_MANA, ENT_STRENGTH, ENT_INITIATIVE, ENT_ATTACK, ENT_PV_MAX, ENT_MANA_MAX)
                VALUES (:hero_name, 'Entité de type héros', :base_pv, :base_mana, :strength, :initiative, :attack, :base_pv, :base_mana)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':hero_name', $heroName, PDO::PARAM_STR);
        $stmt->bindParam(':base_pv', $finalStats['pv'], PDO::PARAM_INT);
        $stmt->bindParam(':base_mana', $finalStats['mana'], PDO::PARAM_INT);
        $stmt->bindParam(':strength', $finalStats['strength'], PDO::PARAM_INT);
        $stmt->bindParam(':initiative', $finalStats['initiative'], PDO::PARAM_INT);
        $stmt->bindParam(':attack', $finalStats['attack'], PDO::PARAM_INT);
        $stmt->bindParam(':base_pv', $finalStats['pv'], PDO::PARAM_INT);  // Utiliser les PV finaux
        $stmt->bindParam(':base_mana', $finalStats['mana'], PDO::PARAM_INT);  // Utiliser les Mana finaux
        $stmt->execute();
    
        return $this->db->lastInsertId();
    }
    

    // Insérer un héros dans la table DUN_HERO
    public function insertHero($classId, $heroBio ,$entityId) {
        $stmt = $this->db->query("SELECT COALESCE(MAX(HER_ID), 0) + 1 AS new_her_id FROM DUN_HERO");
        $newHerId = (int)$stmt->fetch(PDO::FETCH_ASSOC)['new_her_id'];

        $sql = "INSERT INTO DUN_HERO
                (HER_ID, CLA_ID, ENT_ID, HER_MONNAIE, HER_BIOGRAPHY, HER_XP, HER_LEVEL)
                VALUES (:her_id, :class_id, :entity_id, 0, :hero_bio, 0, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':her_id', $newHerId, PDO::PARAM_INT);
        $stmt->bindParam(':class_id', $classId, PDO::PARAM_INT);
        $stmt->bindParam(':entity_id', $entityId, PDO::PARAM_INT);
        $stmt->bindParam(':hero_bio', $heroBio, PDO::PARAM_STR);
        $stmt->execute();

        return $newHerId;
    }

    public function saveHero($classId ,$entityId, $heroId) {
        $sql = "INSERT INTO DUN_HERO
                (HER_ID, CLA_ID, ENT_ID, HER_MONNAIE, HER_BIOGRAPHY, HER_XP, HER_LEVEL)
                VALUES (:her_id, :class_id, :entity_id, :her_monnaie, :hero_bio, :her_xp, :her_level)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':her_id', $heroId, PDO::PARAM_INT); // HER_ID = héros existant
        $stmt->bindParam(':class_id', $classId, PDO::PARAM_INT);
        $stmt->bindParam(':entity_id', $entityId, PDO::PARAM_INT);
        $stmt->bindParam(':hero_bio', $heroBio, PDO::PARAM_STR);
        $stmt->bindParam(':her_xp', $herXp, PDO::PARAM_INT);
        $stmt->bindParam(':her_level', $herLevel, PDO::PARAM_INT);
        $stmt->bindParam(':her_monnaie', $herMonnaie, PDO::PARAM_INT);
        $stmt->execute();

        return $this->db->lastInsertId();;
    }

    // Récupérer l'aventure par ID
    public function getAdventure($advId) {
        $sql = "SELECT * FROM DUN_ADVENTURE WHERE ADV_ID = :adv_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':adv_id', $advId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdventureFirstChapter($advId) {
        $sql = "SELECT CHA_ID FROM DUN_CHAPTER WHERE ADV_ID = :adv_id and CHA_ID = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':adv_id', $advId, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->fetch(PDO::FETCH_ASSOC);
        $chap = $stmt->fetch(PDO::FETCH_ASSOC);
        return $chap['CHA_ID'];

    }
}
