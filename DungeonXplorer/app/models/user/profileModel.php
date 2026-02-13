<?php

class profileModel {

    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getProfileHeroes(int $userId): array {
        $sql = "SELECT ENT_ID, CLA_ID, HER_MONNAIE, HER_BIOGRAPHY, HER_XP, HER_LEVEL, ENT_NOM, CLA_LIBELLE
                FROM DUN_HERO 
                JOIN DUN_SAVE USING(ENT_ID)
                JOIN DUN_ENTITY USING(ENT_ID)
                JOIN DUN_CLASS USING(CLA_ID)
                WHERE COM_ID = :user_id
                ORDER BY ENT_ID ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateHero($heroId, $nom, $bio) {
        try {
            // Mise à jour du nom dans la table DUN_ENTITY
            $sql = "UPDATE DUN_ENTITY SET 
                    ENT_NOM = :ent_nom
                    WHERE ENT_ID = :ent_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ent_nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':ent_id', $heroId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Mise à jour de la biographie dans la table DUN_HERO
            $sql = "UPDATE DUN_HERO SET 
                    HER_BIOGRAPHY = :her_biography
                    WHERE ENT_ID = :ent_id";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':her_biography', $bio, PDO::PARAM_STR);
            $stmt->bindParam(':ent_id', $heroId, PDO::PARAM_INT);
            $stmt->execute();
    
            // Retourner le nombre de lignes affectées
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // En cas d'erreur, retourne un message d'erreur ou log l'exception
            echo "Erreur lors de la mise à jour du héros : " . $e->getMessage();
            return false;
        }
    }
    
    public function deleteHero($entId) {
        // Démarrer une transaction pour garantir la cohérence
        $this->db->beginTransaction();
        $com_id = $_SESSION['user_id'];
        try {
            $stmt = $this->db->prepare("DELETE FROM DUN_SAVE WHERE ENT_ID = :ent_id");
            $stmt->execute([':ent_id' => $entId]);

            // Supprimer l'es objets dans l'inventaire du héros
            $stmt = $this->db->prepare("DELETE FROM DUN_COMPOSE WHERE ENT_ID = :ent_id");
            $stmt->execute([':ent_id' => $entId]);

            // Supprimer l'invetnaire du héros
            $stmt = $this->db->prepare("DELETE FROM DUN_INVENTORY WHERE ENT_ID = :ent_id");
            $stmt->execute([':ent_id' => $entId]);
        
            // Supprimer les équipements du héros dans DUN_EQUIPMENT
            $stmt = $this->db->prepare("DELETE FROM DUN_EQUIPMENT WHERE ENT_ID = :ent_id");
            $stmt->execute([':ent_id' => $entId]);
        
            // Supprimer le héros de DUN_HERO
            $stmt = $this->db->prepare("DELETE FROM DUN_HERO WHERE ENT_ID = :ent_id");
            $stmt->execute([':ent_id' => $entId]);
        
            // Supprimer l'entité du héros de DUN_ENTITY
            $stmt = $this->db->prepare("DELETE FROM DUN_ENTITY WHERE ENT_ID = :ent_id");
            $stmt->execute([':ent_id' => $entId]);
        

    
            // Commit des modifications
            $this->db->commit();
    
            return true; // Suppression réussie
        } catch (Exception $e) {
            // En cas d'erreur, rollback des modifications
            $this->db->rollBack();
            throw $e; // Rethrow l'exception pour la gestion des erreurs
        }
    }

    public function deleteAccount($comId) {
        // Démarrer une transaction pour garantir la cohérence
        $this->db->beginTransaction();
        try {
            // Supprimer les saves du compte
            $stmt = $this->db->prepare("DELETE FROM DUN_SAVE WHERE COM_ID = :comId");
            $stmt->execute([':comId' => $comId]);

            // Supprimer le compte
            $stmt = $this->db->prepare("DELETE FROM DUN_COMPTE WHERE COM_ID = :comId");
            $stmt->execute([':comId' => $comId]);
        
            // Commit des modifications
            $this->db->commit();
            return true; // Suppression réussie
        } catch (Exception $e) {
            // En cas d'erreur, rollback des modifications
            $this->db->rollBack();
            throw $e;
        }
    }

}
?>