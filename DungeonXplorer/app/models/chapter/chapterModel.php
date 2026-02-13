<?php

require_once ROOT_DIR . 'app/models/chapter/Chapter.php'; 
require_once ROOT_DIR . 'app/models/combat/Entity.php'; 
require_once ROOT_DIR . 'app/models/hero/InventoryModel.php';


class ChapterModel
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function loadChaptersFromDB($advId)
    {
        $sql = "SELECT * FROM DUN_CHAPTER JOIN DUN_ADVENTURE USING (ADV_ID)
                WHERE ADV_ID = :advId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':advId', $advId, PDO::PARAM_INT);
        $stmt->execute();

        $chapters = [];
        while ($row = $stmt->fetch($this->db::FETCH_ASSOC)){
            $chapter = new Chapter( 
                $row['CHA_ID'], // l'ID du chapitre
                $row['ADV_LIBELLE'], // titre du chapitre
                $row['CHA_CONTENT'], // contenu du chapitre
                $this->loadChoices($row['CHA_ID'], $row['ADV_ID']), // choix du chapitre
                "images/img_" . $row['ADV_ID'] . "_" . $row['CHA_ID'] . ".png"
            );
            $chapters[] = $chapter;
        }
        return $chapters;
    }

    public function getChapter($id, $advId)
    {
        $chapters = $this->loadChaptersFromDB($advId);
        foreach ($chapters as $chapter) {
            if ((int)$chapter->getId() === (int)$id) {
                return $chapter;
            }
        }
        return null;
    }

    public function loadChoices($chapterID, $advId)
    {
        $sql = "SELECT DISTINCT LIN_DESCRIPTION, LIN_NEXT_CHAPTER FROM DUN_LINKS l
            JOIN DUN_CHAPTER c ON l.CHA_ID = c.CHA_ID
            JOIN DUN_ADVENTURE a ON l.ADV_ID = a.ADV_ID
            WHERE c.CHA_ID = ? AND a.ADV_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$chapterID, $advId]);

        $choices = [];
        while ($row = $stmt->fetch($this->db::FETCH_ASSOC)){
            $choices[] = [
                'text' => $row['LIN_DESCRIPTION'], 
                'chapter' => $row['LIN_NEXT_CHAPTER']
            ];
        }
        return $choices;
    }

    public function saveGame(int $advId, int $chaId){
        $comId = $_SESSION['user_id'];  // ID du joueur
        $entId = $_SESSION['hero_id'];  // ID de l'entité (héros)
        $herId = $_SESSION['her_id'] ?? null;  // HER_ID du héros racine, peut être null si pas défini

        // --- Charger l'entité actuelle ---
        $stmt = $this->db->prepare("SELECT * FROM DUN_ENTITY WHERE ENT_ID = ?");
        $stmt->execute([$entId]);
        $heroData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$heroData) {
            throw new Exception("Héros introuvable pour ENT_ID=$entId");
        }

        // Créer un clone de l'héro actuel
        $heroObject = new Entity($heroData);
        $heroClone  = clone $heroObject;

        // --- Insérer le clone dans DUN_ENTITY ---
        $sqlEntity = "INSERT INTO DUN_ENTITY 
                    (ENT_NOM, ENT_DESCRIPTION, ENT_PV, ENT_PV_MAX, ENT_MANA, ENT_MANA_MAX, ENT_STRENGTH, ENT_INITIATIVE, ENT_ATTACK, ENT_CAPACITY) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtEntity = $this->db->prepare($sqlEntity);
        $stmtEntity->execute([
            $heroClone->getNom(),
            $heroClone->getDescription(),
            $heroClone->getPv(),
            $heroClone->getPvMax(),
            $heroClone->getMana(),
            $heroClone->getManaMax(),
            $heroClone->getStrength(),
            $heroClone->getInitiative(),
            $heroClone->getAttack(),
            $heroClone->getCapacity()
        ]);

        $entIdClone = $this->db->lastInsertId();

        // --- Insérer dans DUN_HERO (HER_ID inchangé) ---
        $sqlHero = "INSERT INTO DUN_HERO
                    (HER_ID, ENT_ID, CLA_ID, HER_MONNAIE, HER_BIOGRAPHY, HER_XP, HER_LEVEL)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmtHero = $this->db->prepare($sqlHero);
        $stmtHero->execute([
            $herId,  // on conserve le HER_ID existant
            $entIdClone,  // Utiliser $entIdClone pour le clone
            $_SESSION['class_id'] ?? 1,
            $_SESSION['her_monnaie'] ?? 0,
            $_SESSION['her_biography'] ?? '',
            $_SESSION['her_xp'] ?? 0,
            $_SESSION['her_level'] ?? 1
        ]);

        $inventoryModel = new InventoryModel($this->db);

            $invId = $inventoryModel->createInventory($entIdClone);

            $stmtCompose = $this->db->prepare("SELECT * FROM DUN_COMPOSE WHERE ENT_ID = ?");
            $stmtCompose->execute([$entId]);
            $composeItems = $stmtCompose->fetchAll(PDO::FETCH_ASSOC);

            foreach ($composeItems as $item) {
                $inventoryModel->insertCompose($entIdClone,$item['ITE_ID'],$item['TYP_ITEM_ID'],$item['NB_ITEM']);
            }

        // --- Sauvegarder dans DUN_SAVE ---
        $sqlSave = "INSERT INTO DUN_SAVE (ADV_ID, CHA_ID, COM_ID, ENT_ID, SAV_ID)
                    VALUES (?, ?, ?, ?,
                        (SELECT COALESCE(MAX(SAV_ID), 0) + 1
                        FROM DUN_SAVE
                        WHERE ADV_ID = ? AND CHA_ID = ? AND COM_ID = ? AND ENT_ID = ?)
                    )";
        $stmtSave = $this->db->prepare($sqlSave);
        $stmtSave->execute([$advId, $chaId, $comId, $entIdClone, $advId, $chaId, $comId, $entIdClone]);

        // --- Mettre à jour la session ---
        $_SESSION['hero_id']     = $entIdClone;
        $_SESSION['hero_object'] = new Entity([
            'ENT_ID' => $entIdClone,
            'ENT_NOM' => $heroClone->getNom(),
            'ENT_DESCRIPTION' => $heroClone->getDescription(),
            'ENT_PV' => $heroClone->getPv(),
            'ENT_PV_MAX' => $heroClone->getPvMax(),
            'ENT_MANA' => $heroClone->getMana(),
            'ENT_MANA_MAX' => $heroClone->getManaMax(),
            'ENT_STRENGTH' => $heroClone->getStrength(),
            'ENT_INITIATIVE' => $heroClone->getInitiative(),
            'ENT_ATTACK' => $heroClone->getAttack(),
            'ENT_CAPACITY' => $heroClone->getCapacity()
        ]);

        // Nettoyage des variables de session inutiles
        unset($_SESSION['combat_log'], $_SESSION['combat_ended'], $_SESSION['combat_monster_id']);
    }

}

?>