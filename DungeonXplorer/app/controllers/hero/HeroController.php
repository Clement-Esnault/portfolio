<?php

include_once(ROOT_DIR . 'app/models/hero/HeroModel.php');
include_once(ROOT_DIR . 'app/models/hero/InventoryModel.php');


class HeroController {

    protected $db;
    protected $heroModel;
   

    public function __construct($db) {
        $this->db = $db;
        $this->heroModel = new HeroModel($this->db);
        $this->inventoryModel = new InventoryModel($this->db);
    }


    public function chooseHero() {
        
        if (!isset($_SESSION['adv_id']) || empty($_SESSION['adv_id'])) {
            echo "Aucune aventure sélectionnée. Veuillez revenir à la page précédente.";
            exit();
        }
    
        $classes = $this->heroModel->getClasses();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['class_id'])) {
                $_SESSION['class_id'] = $_POST['class_id'];
                $_SESSION['class_selected'] = true;
            }
    
            if (isset($_POST['hero_name'])) {
                $_SESSION['hero_name'] = $_POST['hero_name'];
                $heroBiographie = $_POST['hero_bio'];
                
                //Recup stats de la classe
                $classId = intval($_SESSION['class_id']);
                $classStats = $this->heroModel->getClassStats($classId);
    
                // Recup les points alloués
                $strength = intval($_POST['strength']);
                $initiative = intval($_POST['initiative']);
                $attack = intval($_POST['attack']);
                $pv = intval($_POST['pv']);
                $mana = intval($_POST['mana']);
    
                // Vérif moins de 5 pts
                $totalPoints = $strength + $initiative + $attack + $pv + $mana;
                if ($totalPoints > 5) {
                    $errorMessage = "La somme des points de statistiques ne peut pas dépasser 5.";
                } else if (strlen($_SESSION['hero_name']) > 32) {
                    $errorMessage = "Le nom du hero ne doit pas dépasser 32 caractères";
                } elseif (strlen($heroBiographie) > 255) {
                    $errorMessage = "La biographie du hero ne doit pas dépasser 255 caractères";
                } else {
                    $finalStats = [
                        'strength' => $classStats['CLA_STRENGTH'] + $strength,
                        'initiative' => $classStats['CLA_INITIATIVE'] + $initiative,
                        'attack' => $classStats['CLA_STRENGTH'] + $attack,
                        'pv' => $classStats['CLA_BASE_PV'] + $pv,
                        'mana' => $classStats['CLA_BASE_MANA'] + $mana
                    ];
    
                    $entityId = $this->heroModel->insertEntity($_SESSION['hero_name'], $classStats, $finalStats);
    
                    $heroId = $this->heroModel->insertHero($classId, $heroBiographie ,$entityId);

                    $invId = $this->inventoryModel->createInventory($entityId);

                    $this->inventoryModel->insertCompose($entityId,1,4,5);
                    $this->inventoryModel->insertCompose($entityId,2,4,5);

                    $_SESSION['hero_id'] = $entityId;
    
                    $advId = $_SESSION['adv_id'];
                    $adventure = $this->heroModel->getAdventure($advId);
    
                    $_SESSION['chapter_id'] = 1;
                    $_SESSION['new_adventure'] = true;

                    echo '<a href=choixHero</a>';
                }
            }
        }
    
        // Passer les classes et l'erreur à la vue
        include(ROOT_DIR . 'app/views/chapitre/choixHero.php');
    }
    
    
}
