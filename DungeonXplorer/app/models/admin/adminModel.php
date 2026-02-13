<?php

class adminModel {

    protected $db;

    // --- Constructeur ---
    public function __construct($db) {
        $this->db = $db;
    }

    // ========================
    // --- CHAPITRES (Chapters) ---
    // ========================

    public function getChapters() {
        $sql = "SELECT ADV_ID, CHA_ID, CHA_TITLE, CHA_CONTENT FROM DUN_CHAPTER";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getChaptersByAdventure($adv_id) {
        $sql = "SELECT CHA_ID, CHA_TITLE,CHA_CONTENT FROM DUN_CHAPTER WHERE ADV_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$adv_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getChapterById($chapterId) {
        $stmt = $this->db->prepare("SELECT ADV_ID, CHA_ID, CHA_TITLE, CHA_CONTENT FROM DUN_CHAPTER WHERE CHA_ID = :cha_id");
        $stmt->execute(['cha_id' => $chapterId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertChapter($title, $content, $adventureId) {
        $sql = "SELECT MAX(CHA_ID) AS max_cha_id FROM DUN_CHAPTER WHERE ADV_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$adventureId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $newChaId = $result['max_cha_id'] + 1;

        $sql = "INSERT INTO DUN_CHAPTER (CHA_ID, CHA_TITLE, CHA_CONTENT, ADV_ID) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$newChaId, $title, $content, $adventureId]);
    }

    public function updateChapter($chapterId, $title, $content) {
        $sql = "UPDATE DUN_CHAPTER SET CHA_TITLE = ?, CHA_CONTENT = ? WHERE CHA_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title, $content, $chapterId]);
        
        return $stmt->rowCount() > 0;
    }

    public function deleteChapter($chapterId) {
        $sql = "DELETE FROM DUN_INTRODUCE WHERE CHA_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$chapterId]);

        $sql = "DELETE FROM DUN_HAVE WHERE CHA_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$chapterId]);

        $sql = "DELETE FROM DUN_SAVE WHERE CHA_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$chapterId]);

        $sql = "DELETE FROM DUN_CHAPTER WHERE CHA_ID = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$chapterId]);
    }

    // =========================
    // --- LIENS (Links) ---
    // =========================

    public function getLinks() {
        $sql = "SELECT 
                    L.ADV_ID, 
                    L.CHA_ID, 
                    L.LIN_NEXT_CHAPTER, 
                    L.LIN_DESCRIPTION, 
                    C1.CHA_TITLE AS CHA_TITLE_1, 
                    C2.CHA_TITLE AS CHA_TITLE_2
                FROM DUN_LINKS L
                INNER JOIN DUN_CHAPTER C1 ON L.CHA_ID = C1.CHA_ID
                INNER JOIN DUN_CHAPTER C2 ON L.LIN_NEXT_CHAPTER = C2.CHA_ID";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertLinkB($adv_id, $cha_first, $cha_second, $description) {
        $sql = "INSERT INTO DUN_LINKS (ADV_ID, CHA_ID, LIN_NEXT_CHAPTER, LIN_DESCRIPTION) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$adv_id, $cha_first, $cha_second, $description]);
    }

    public function insertLink() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adv_id = (int) $_POST['adv_id'];
            $cha_first = (int) $_POST['cha_first'];
            $cha_second = (int) $_POST['cha_second'];
            $description = htmlspecialchars(trim($_POST['description']));

            if (empty($description)) {
                header("Location: index.php?url=admin/addLink&adv_id=$adv_id&message=La description est obligatoire.");
                exit();
            }

            try {
                $this->insertLinkB($adv_id, $cha_first, $cha_second, $description);
                header("Location: index.php?url=admin/editChapters&adv_id=$adv_id&message=Lien ajouté avec succès.");
            } catch (Exception $e) {
                header("Location: index.php?url=admin/addLink&adv_id=$adv_id&message=Erreur lors de l'ajout du lien.");
            }
            exit();
        }
    }

    public function deleteLink($adv_id, $cha_first, $cha_second) {
        $sql = "SELECT COUNT(*) FROM DUN_LINKS WHERE ADV_ID = ? AND CHA_ID = ? AND LIN_NEXT_CHAPTER = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$adv_id, $cha_first, $cha_second]);

        if ($stmt->fetchColumn() == 0) {
            header("Location: index.php?url=admin/editChapters&message=Lien non trouvé.");
            exit();
        }

        $sql = "DELETE FROM DUN_LINKS WHERE ADV_ID = ? AND CHA_ID = ? AND LIN_NEXT_CHAPTER = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$adv_id, $cha_first, $cha_second]);
    }

    // =========================
    // --- OBJETS (Items) ---
    // =========================

    public function getItems() {
        $sql = "SELECT 
                    TYP_ITEM_ID,
                    ITE_ID,
                    ITE_NAME,
                    ITE_DESCRIPTION,
                    ITE_POIDS,
                    ITE_VALEUR,
                    ITE_STACKABLE,
                    ITE_PRIX,
                    TYP_ITEM_LIBELLE
                FROM DUN_ITEM
                JOIN DUN_ITEM_TYPE USING(TYP_ITEM_ID)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getItemsById($itemId) {
        $sql = "SELECT 
                    TYP_ITEM_ID,
                    ITE_ID,
                    ITE_NAME,
                    ITE_DESCRIPTION,
                    ITE_POIDS,
                    ITE_VALEUR,
                    ITE_STACKABLE,
                    ITE_PRIX,
                    TYP_ITEM_LIBELLE
                FROM DUN_ITEM
                JOIN DUN_ITEM_TYPE USING(TYP_ITEM_ID)
                WHERE ITE_ID = :item_id"; 
        
        $stmt = $this->db->prepare($sql);

        $stmt->execute(['item_id' => $itemId]);  
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function getItemsType() {
        $sql = "SELECT 
                    TYP_ITEM_ID,
                    TYP_ITEM_LIBELLE
                FROM DUN_ITEM_TYPE";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNextItemId() {
        $sql = "SELECT MAX(ITE_ID) AS max_id FROM DUN_ITEM";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['max_id'] + 1;
    }

    public function getNextMonsterLootId() {
        $sql = "SELECT MAX(MON_LOOT_ID) AS max_id FROM DUN_MONSTER_LOOT";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['max_id'] + 1;
    }


    public function insertItem($name, $description, $weight, $value, $stackable, $price, $typeId, $xp) {
        // Convertir les valeurs booléennes pour 'stackable' en 0 ou 1
        $stackable = $stackable ? 1 : 0;  // Si 'stackable' est TRUE, assignez 1, sinon assignez 0
    
        $nextItemId = $this->getNextItemId();
        $nextMonsterLootId = $this->getNextMonsterLootId();  
    
        $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

        // Insérer dans DUN_ITEM
        $sql = "INSERT INTO DUN_ITEM (ITE_ID, ITE_NAME, ITE_DESCRIPTION, ITE_POIDS, ITE_VALEUR, ITE_STACKABLE, ITE_PRIX, TYP_ITEM_ID) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nextItemId, $name, $description, $weight, $value, $stackable, $price, $typeId]);
    
        // Insérer dans DUN_MONSTER_LOOT
        $sql = "INSERT INTO DUN_MONSTER_LOOT (MON_LOOT_ID, MON_LOOT_XP, MON_LOOT_QUANTITY) 
                VALUES (?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nextMonsterLootId, $xp]);
    
        // Insérer dans DUN_DROP
        $sql = "INSERT INTO DUN_DROP (TYP_ITEM_ID, ITE_ID, MON_LOOT_ID) 
                VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$typeId, $nextItemId, $nextMonsterLootId]);
    }
    

    public function updateItem($itemId, $name, $description, $poids, $valeur, $stackable, $price, $typeId) {
        // Vérification des champs obligatoires
        if (empty($name) || empty($description) || empty($typeId)) {
            throw new Exception("Nom, description et type sont obligatoires.");
        }
        
        // Étape 1 : Récupérer le MON_LOOT_ID depuis DUN_DROP en fonction de l'ITE_ID
        $sql = "SELECT MON_LOOT_ID FROM DUN_DROP WHERE ITE_ID = :itemId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['itemId' => $itemId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($row) {
            $monLootId = $row['MON_LOOT_ID'];
        } else {
            throw new Exception("Aucun MON_LOOT_ID trouvé pour cet item.");
        }
    
        $sql = "UPDATE DUN_DROP SET TYP_ITEM_ID = :typeId WHERE ITE_ID = :itemId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'itemId' => $itemId,
            'typeId' => $typeId
        ]);


        // Étape 2 : Mettre à jour DUN_ITEM avec les nouvelles informations
        $sql = "UPDATE DUN_ITEM SET 
                    ITE_NAME = :name, 
                    ITE_DESCRIPTION = :description, 
                    ITE_POIDS = :poids, 
                    ITE_VALEUR = :valeur , 
                    ITE_STACKABLE = :stackable, 
                    ITE_PRIX = :price, 
                    TYP_ITEM_ID = :typeId
                WHERE ITE_ID = :itemId";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'itemId' => $itemId,
            'name' => $name,
            'description' => $description,
            'poids' => $poids,
            'valeur' => $valeur,
            'stackable' => $stackable,
            'price' => $price,
            'typeId' => $typeId
        ]);
    
        // Étape 3 : Mettre à jour DUN_MONSTER_LOOT avec le XP
        $sql = "UPDATE DUN_MONSTER_LOOT SET 
                    MON_LOOT_XP = :xp 
                WHERE MON_LOOT_ID = :monLootId";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'monLootId' => $monLootId,
            'xp' => $xp
        ]);
    
        // Étape 4 : Mettre à jour DUN_DROP avec les nouvelles valeurs de TYP_ITEM_ID
        $sql = "UPDATE DUN_DROP SET 
                    TYP_ITEM_ID = :typeId 
                WHERE ITE_ID = :itemId";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'itemId' => $itemId,
            'typeId' => $typeId
        ]);
    }
    

    public function deleteItem($itemId) {
        $this->db->beginTransaction();
        
        try {
            // 1. Supprimer les enregistrements dans DUN_DROP qui font référence à l'ITE_ID
            $sql = "DELETE FROM DUN_DROP WHERE ITE_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$itemId]);
    
            // 2. Supprimer les enregistrements associés dans DUN_MONSTER_LOOT
            $sql = "DELETE FROM DUN_MONSTER_LOOT WHERE MON_LOOT_ID = (SELECT MON_LOOT_ID FROM DUN_DROP WHERE ITE_ID = ? LIMIT 1)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$itemId]);
    
            // 3. Supprimer l'item dans DUN_HAVE si nécessaire
            $sql = "DELETE FROM DUN_HAVE WHERE ITE_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$itemId]);
    
            // 4. Supprimer l'item dans DUN_ITEM
            $sql = "DELETE FROM DUN_ITEM WHERE ITE_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$itemId]);
    
            // Commit si tout s'est bien passé
            $this->db->commit();
        } catch (Exception $e) {
            // Rollback en cas d'erreur
            $this->db->rollBack();
            throw new Exception("Erreur lors de la suppression de l'objet: " . $e->getMessage());
        }
    } 
    
    // ==========================
    // --- UTILISATEURS (Users) ---
    // ==========================

    public function getUser() {
        $sql = "SELECT * FROM DUN_COMPTE";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($userId) {
        $db = $this->db;
        $db->beginTransaction();

        try {
            $stmt = $db->prepare("SELECT COUNT(*) FROM DUN_COMPTE WHERE COM_ID = ?");
            $stmt->execute([$userId]);
            if ($stmt->fetchColumn() == 0) {
                die('Utilisateur introuvable.');
            }

            $stmt = $db->prepare("SELECT ENT_ID FROM DUN_SAVE WHERE COM_ID = :user_id");
            $stmt->execute(['user_id' => $userId]);
            $entIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($entIds)) {
                $in = implode(',', array_fill(0, count($entIds), '?'));
                $db->prepare("DELETE FROM DUN_INVENTORY WHERE ENT_ID IN ($in)")->execute($entIds);
                $db->prepare("DELETE FROM DUN_EQUIPMENT de JOIN DUN_ENTITY di ON di.ENT_ID = de.ENT_ID WHERE di.ENT_ID IN ($in)")->execute($entIds);
                $db->prepare("DELETE FROM DUN_HERO WHERE ENT_ID IN ($in)")->execute($entIds);
                $db->prepare("DELETE FROM DUN_ENTITY WHERE ENT_ID IN ($in)")->execute($entIds);
            }

            $db->prepare("DELETE FROM DUN_SAVE WHERE COM_ID = ?")->execute([$userId]);
            $db->prepare("DELETE FROM DUN_COMPTE WHERE COM_ID = ?")->execute([$userId]);

            $db->commit();

        } catch (Exception $e) {
            $db->rollBack();
            die('Delete failed: ' . $e->getMessage());
        }
    }

    // ==========================
    // --- MONSTER  ---
    // ==========================

    public function getMonsters() {
        $sql = "SELECT 
                    ENT_ID,
                    ENT_NOM,
                    ENT_DESCRIPTION,
                    ENT_PV,
                    ENT_MANA,
                    ENT_STRENGTH,
                    ENT_INITIATIVE,
                    ENT_CAPACITY,
                    ENT_ATTACK,
                    ENT_PV_MAX,
                    ENT_MANA_MAX,
                    MON_LOOT_ID
                FROM DUN_ENTITY
                JOIN DUN_MONSTER USING(ENT_ID)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getMonsterById($id) {
        $sql = "SELECT 
                    ENT_ID,
                    ENT_NOM,
                    ENT_DESCRIPTION,
                    ENT_PV,
                    ENT_MANA,
                    ENT_STRENGTH,
                    ENT_INITIATIVE,
                    ENT_CAPACITY,
                    ENT_ATTACK,
                    ENT_PV_MAX,
                    ENT_MANA_MAX,
                    MON_LOOT_ID
                FROM DUN_ENTITY
                JOIN DUN_MONSTER USING(ENT_ID)
                WHERE ENT_ID = :ent_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['ent_id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    


    public function getMonstersLoot() {
        $sql = "SELECT 
                    m.MON_LOOT_ID,
                    m.MON_LOOT_XP,
                    m.MON_LOOT_QUANTITY,
                    i.ITE_NAME
                FROM DUN_MONSTER_LOOT m
                JOIN DUN_DROP USING(MON_LOOT_ID)
                JOIN DUN_ITEM i USING (ITE_ID)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateMonster($monsterId, $name, $description, $pv, $mana, $strength, $initiative, $capacity, $attack, $maxPv, $maxMana , $lootId) {
        // Vérification que les champs obligatoires sont remplis
        if (empty($name) || empty($description)) {
            throw new Exception("Le nom et la description du monstre sont obligatoires.");
        }
    
        try {
            // Préparation de la requête SQL pour mettre à jour les informations du monstre
            $sql = "UPDATE DUN_ENTITY
                    SET 
                        ENT_NOM = :name,
                        ENT_DESCRIPTION = :description,
                        ENT_PV = :pv,
                        ENT_MANA = :mana,
                        ENT_STRENGTH = :strength,
                        ENT_INITIATIVE = :initiative,
                        ENT_CAPACITY = :capacity,
                        ENT_ATTACK = :attack,
                        ENT_PV_MAX = :maxPv,
                        ENT_MANA_MAX = :maxMana
                    WHERE ENT_ID = :monsterId";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':pv' => $pv,
                ':mana' => $mana,
                ':strength' => $strength,
                ':initiative' => $initiative,
                ':capacity' => $capacity,
                ':attack' => $attack,
                ':maxPv' => $maxPv,
                ':maxMana' => $maxMana,
                ':monsterId' => $monsterId
            ]);
            $sql = "UPDATE DUN_MONSTER
                SET MON_LOOT_ID = :loot_id
                WHERE ENT_ID = :monsterId";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':loot_id' => $lootId,
                ':monsterId' => $monsterId
            ]);

            // Vérifier si la requête a affecté des lignes
            if ($stmt->rowCount() > 0) {
                return true; // Mise à jour réussie
            } else {
                throw new Exception("Aucune ligne affectée. Le monstre peut ne pas exister ou les données sont inchangées.");
            }
        } catch (Exception $e) {
            // Si une erreur survient, la capturer et l'afficher
            throw new Exception("Erreur lors de la mise à jour du monstre : " . $e->getMessage());
        }
    }
    
    public function insertMonster($name, $description, $pv, $mana, $strength, $initiative, $capacity, $attack, $maxPv, $maxMana) {
        // Vérification que les champs obligatoires sont remplis
        if (empty($name) || empty($description)) {
            throw new Exception("Le nom et la description du monstre sont obligatoires.");
        }
    
        try {
            // 1. Insérer l'entité dans la table DUN_ENTITY
            $sql = "INSERT INTO DUN_ENTITY (
                        ENT_NOM, 
                        ENT_DESCRIPTION, 
                        ENT_PV, 
                        ENT_MANA, 
                        ENT_STRENGTH, 
                        ENT_INITIATIVE, 
                        ENT_CAPACITY, 
                        ENT_ATTACK, 
                        ENT_PV_MAX, 
                        ENT_MANA_MAX
                    ) VALUES (
                        :name, 
                        :description, 
                        :pv, 
                        :mana, 
                        :strength, 
                        :initiative, 
                        :capacity, 
                        :attack, 
                        :maxPv, 
                        :maxMana
                    )";
    
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':pv' => $pv,
                ':mana' => $mana,
                ':strength' => $strength,
                ':initiative' => $initiative,
                ':capacity' => $capacity,
                ':attack' => $attack,
                ':maxPv' => $maxPv,
                ':maxMana' => $maxMana
            ]);
    
            // 2. Récupérer l'ID de l'entité insérée
            $entityId = $this->db->lastInsertId(); // Récupère l'ID de la dernière entité insérée.
    
            // 3. Insérer le monstre dans la table DUN_MONSTER
            $sqlMonster = "INSERT INTO DUN_MONSTER (ENT_ID,MON_LOOT_ID) VALUES (:ent_id,7)"; //12 A CHANGER
            $stmtMonster = $this->db->prepare($sqlMonster);
            $stmtMonster->execute([
                ':ent_id' => $entityId
            ]);
            
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'ajout du monstre: " . $e->getMessage());
        }
    }

    public function deleteMonster($entId) {
        try {
            // Démarrage de la transaction
            $this->db->beginTransaction();
    
            // Suppression dans DUN_INTRODUCE
            $sql = "DELETE FROM DUN_INTRODUCE WHERE ENT_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$entId]);
    
            // Suppression dans DUN_MONSTER
            $sql = "DELETE FROM DUN_MONSTER WHERE ENT_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$entId]);
    
            // Suppression dans DUN_ENTITY
            $sql = "DELETE FROM DUN_ENTITY WHERE ENT_ID = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$entId]);
    
            // Commit si tout s'est bien passé
            $this->db->commit();
        } catch (Exception $e) {
            // Rollback en cas d'erreur
            $this->db->rollBack();
            // Gestion des erreurs (log de l'erreur ou affichage d'un message d'exception)
            throw new Exception("Erreur lors de la suppression de l'objet: " . $e->getMessage());
        }
    }

    // ==========================
    // --- MONSTER IN CHAPTER ---
    // ==========================



    public function getMonsterByChapter($chapterId) {
        $sql = "SELECT DUN_ENTITY.ENT_NOM  , DUN_ENTITY.ENT_ID
                FROM DUN_CHAPTER 
                JOIN DUN_INTRODUCE ON DUN_CHAPTER.CHA_ID = DUN_INTRODUCE.CHA_ID
                JOIN DUN_ENTITY ON DUN_INTRODUCE.ENT_ID = DUN_ENTITY.ENT_ID
                JOIN DUN_MONSTER ON DUN_ENTITY.ENT_ID = DUN_MONSTER.ENT_ID
                WHERE DUN_CHAPTER.CHA_ID = :chapterId
                LIMIT 1";  
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':chapterId', $chapterId, PDO::PARAM_INT);
        $stmt->execute();
        $monster = $stmt->fetch(PDO::FETCH_ASSOC);
        return $monster ? $monster : false;
    }

    public function insertMonsterToChapter($chapterId, $monsterId) {
        // Récupérer l'ID de l'aventure associée au chapitre
        $sqlAdventure = "SELECT ADV_ID FROM DUN_CHAPTER WHERE CHA_ID = :chapterId";
        $stmtAdventure = $this->db->prepare($sqlAdventure);
        $stmtAdventure->bindParam(':chapterId', $chapterId, PDO::PARAM_INT);
        $stmtAdventure->execute();
        $adventure = $stmtAdventure->fetch(PDO::FETCH_ASSOC);
    
        if ($adventure) {
            $advId = $adventure['ADV_ID'];
    
            // Insérer le monstre dans la table DUN_INTRODUCE
            $sql = "INSERT INTO DUN_INTRODUCE(ENT_ID, ADV_ID, CHA_ID) 
                    VALUES (:monsterId, :advId, :chapterId)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':monsterId', $monsterId, PDO::PARAM_INT);
            $stmt->bindParam(':advId', $advId, PDO::PARAM_INT);
            $stmt->bindParam(':chapterId', $chapterId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            throw new Exception("Aventure non trouvée pour ce chapitre.");
        }
    }

    public function deleteMonsterFromChapter($chapterId) {
        $sql = "DELETE FROM DUN_INTRODUCE WHERE CHA_ID = :chapterId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':chapterId', $chapterId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // ==========================
    // --- ADVENTURE ---
    // ==========================
    
    public function getAdventures() {
        $sql = "SELECT ADV_ID, ADV_LIBELLE, ADV_DISCRIPTION FROM DUN_ADVENTURE";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAdventureById($advId) {
        $sql = "SELECT ADV_ID, ADV_LIBELLE, ADV_DISCRIPTION FROM DUN_ADVENTURE
                WHERE ADV_ID = :adv_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':adv_id', $advId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateAdventure($advId, $advLibelle, $advDiscription) {
        $sql = "UPDATE DUN_ADVENTURE SET 
                ADV_LIBELLE = :adv_libelle,
                ADV_DISCRIPTION = :adv_discription
                WHERE ADV_ID = :adv_id";
        
        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':adv_libelle', $advLibelle, PDO::PARAM_STR);
        $stmt->bindParam(':adv_discription', $advDiscription, PDO::PARAM_STR);
        $stmt->bindParam(':adv_id', $advId, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->rowCount();  // Retourne le nombre de lignes affectées
    }

    public function insertAdventure($advLibelle, $advDiscription) {
       
        $sql = "INSERT INTO DUN_ADVENTURE (ADV_LIBELLE, ADV_DISCRIPTION) 
                VALUES (:adv_libelle, :adv_discription)";
        
        $stmt = $this->db->prepare($sql);
       
        $stmt->bindParam(':adv_libelle', $advLibelle, PDO::PARAM_STR);
        $stmt->bindParam(':adv_discription', $advDiscription, PDO::PARAM_STR);

        $stmt->execute();
    
        return $stmt->rowCount(); // Retourne le nombre de lignes affectées (si l'insertion a réussi)
    }

    public function deleteAdventure($advId){
        $sql = "DELETE FROM DUN_ADVENTURE WHERE ADV_ID = :advId";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':advId', $advId, PDO::PARAM_INT);
        $stmt->execute();
    }

}

?>
