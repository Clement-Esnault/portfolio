<?php

include_once(ROOT_DIR . 'app/models/adventure/adventureModel.php');

class AdventureController {
    protected $db;
    protected $adventureModel;  

    public function __construct($db) {
        $this->db = $db;
        $this->adventureModel = new AdventureModel($db);  
    }

    // Afficher toutes les aventures disponibles
    public function discover() {
        $adventures = $this->adventureModel->getAllAdventures(); 

        if (isset($_POST['adv_id'])) {
            $advId = $_POST['adv_id'];
            $adventure = $this->adventureModel->getFirstChapter($advId); 

            if ($adventure) {
                $_SESSION['adv_id'] = $advId;
                $_SESSION['chapter_id'] = $adventure['CHA_ID'];  
                $_SESSION['new_adventure'] = true;
                $_SESSION['class_selected'] = false;
                $_SESSION['hero_name'] = null;
            } else {
                echo "Aventure non trouvée.";
            }
        }

        include ROOT_DIR . 'app/views/adventure/discover.php';
    }

    // Afficher les aventures sauvegardées
    public function savedAdventures() {
        if (!isset($_SESSION['user_id'])) {
            echo "Vous devez être connecté pour voir vos sauvegardes.";
            exit;
        }
    
        $adventureModel = new AdventureModel($this->db);
        $savedAdventures = $adventureModel->getSavedAdventures($_SESSION['user_id']);
       
        if (isset($_GET['sav_id'])) {
            $savId = $_GET['sav_id'];
            $heroId = $adventureModel->getHeroIdFromSave($savId);
            $chaId  = $adventureModel->getChapterIdFromSave($savId);
            $advId  = $adventureModel->getAdvIdFromSave($savId);
    
            $_SESSION['hero_id']    = $heroId;
            $_SESSION['chapter_id'] = $chaId;
            $_SESSION['adv_id']     = $advId;
        }
    
        include(ROOT_DIR . 'app/views/chapitre/continue.php');
    }
}
?>
