<?php
include(ROOT_DIR . 'app/models/admin/adminModel.php'); 
class adminController {

    protected $db;
    protected $adminModel;

    public function __construct($db) {
        $this->db = $db;
        $this->adminModel = new adminModel($this->db);
    }

    // Vérification des droits d'administration
    private function checkAdmin() {
        if ($_SESSION['role'] != 'G') {
            die('Accès refusé.');
        }
    }

    // Gestion des actions
    public function handleAction($action, $params = []) {
        switch ($action) {
            case 'editUsers':
                $this->editUsers();
                break;
            case 'editItems':
                $this->editItems();
                break;
            case 'editChapters':
                $this->editChapters();
                break;
            case 'editMonsters':
                $this->editMonsters();
                break;
            case 'editMonster':
                $this->editMonster($params);
                break;
            case 'deleteUser':
                $this->deleteUser($params);
                break;
            case 'editChapter':
                $this->editChapter($params);
                break;
            case 'addChapter':
                $this->addChapter();
                break;
            case 'updateChapter':
                $this->updateChapter($params);
                break;
            case 'deleteChapter':
                $this->deleteChapter($params);
                break;
            case 'addLink':
                $this->addLink($params);
                break;
            case 'insertLink':
                $this->insertLink();
                break;
            case 'supLink':
                $this->supLink($params);
                break;
            case 'deleteLink':
                $this->deleteLink($params);
                break;
            case 'editItem':
                $this->editItem($params);
                break;
            case 'addItem':
                $this->addItem();
                break;
            case 'insertItem':
                $this->insertItem();
                break;
            case 'updateItem':
                $this->updateItem($params);
                break;
            case 'deleteItem':
                $this->deleteItem($params);
                break;
            case 'addMonster':
                $this->addMonster();
                break;
            case 'insertMonster':
                $this->insertMonster();
                break;
            case 'updateMonster':
                $this->updateMonster();
                break;
            case 'deleteMonster':
                $this->deleteMonster($params);
                break;
            case 'editMonsterToChapter':
                $this->editMonsterToChapter($params);
                break;
            case 'insertMonsterToChapter':
                $this->insertMonsterToChapter();
                break;
            case 'deleteMonsterFromChapter':
                $this->deleteMonsterFromChapter();
                break;
            case 'editAdventures':
                $this->editAdventures();
                break;
            case 'updateAdventure':
                $this->updateAdventure($params);
                break;
            case 'addAdventure':
                $this->addAdventure($params);
                break;
            case 'insertAdventure':
                $this->insertAdventure($params);
                break;
            case 'deleteAdventure':
                $this->deleteAdventure($params);
                break;
            default:
                $this->show();
                break;
        }
    }


    public function editUsers() {
        $this->checkAdmin();
        $users = $this->adminModel->getUser();
        include(ROOT_DIR . 'app/views/admin/editUsers.php');
    }

    public function editItems() {
        $this->checkAdmin();
        $items = $this->adminModel->getItems();
        include(ROOT_DIR . 'app/views/admin/editItems.php');
    }

    public function editChapters() {
        $this->checkAdmin();
    
        if (!isset($_SESSION['choix_adv_id'])){
            $_SESSION['choix_adv_id']=0;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adventure_id']) && !empty($_POST['adventure_id'])) {
            $_SESSION['choix_adv_id'] = $_POST['adventure_id'];
        }
        // Vérifier si une aventure est sélectionnée
        if (isset($_SESSION['choix_adv_id']) && !empty($_SESSION['choix_adv_id'])) {
            // Récupérer les chapitres de l'aventure
            $chapters = $this->adminModel->getChaptersByAdventure($_SESSION['choix_adv_id']);
        } else {
            $chapters = [];
            $message = "Veuillez sélectionner une aventure."; // Ajouter un message si aucune aventure n'est sélectionnée
        }
    
        $adventures = $this->adminModel->getAdventures();
        include(ROOT_DIR . 'app/views/admin/editChapters.php');
    }
    

    public function editMonsters() {
        $this->checkAdmin();
        $monsters = $this->adminModel->getMonsters();
        $loots = $this->adminModel->getMonstersLoot() ;
        include(ROOT_DIR . 'app/views/admin/editMonsters.php');
    }

    public function editMonster($params) {
        $entId = $params[0];
        $monster = $this->adminModel->getMonsterById($entId);
        include(ROOT_DIR . 'app/views/admin/editMonster.php');
    }

    public function deleteUser($params) {
        $userId = (int) $params[0];
        $this->adminModel->deleteUser($userId);
        $this->editUsers(); // Revenir à la liste des utilisateurs après suppression
    }

    public function editChapter($params) {
        $chaId = (int) $params[0];
        $chapter = $this->adminModel->getChapterById($chaId);
        include(ROOT_DIR . 'app/views/admin/editChapter.php');
    }

    public function addChapter() {
        $this->checkAdmin();
        $adventures = $this->adminModel->getAdventures();
        include(ROOT_DIR . 'app/views/admin/addChapter.php');
    }

    public function updateChapter($params) {
        $chapterId = (int) $params[0];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $this->adminModel->updateChapter($chapterId, $title, $content);
        $this->editChapters(); // Rediriger vers la liste des chapitres
    }

    public function deleteChapter($params) {
        $cha_id = $params[0];
        $this->adminModel->deleteChapter($cha_id);
        $this->editChapters(); // Revenir à la liste des chapitres après suppression
    }

    public function addLink($params) {
        $adv_id = $_GET['adv_id'];
        $chapters = $this->adminModel->getChaptersByAdventure($adv_id);
        include(ROOT_DIR . 'app/views/admin/addLink.php');
    }

    public function insertLink() {
        $adv_id = (int) $_POST['adv_id'];
        $cha_first = (int) $_POST['cha_first'];
        $cha_second = (int) $_POST['cha_second'];
        $description = htmlspecialchars(trim($_POST['description']));
        $this->adminModel->insertLink($adv_id, $cha_first, $cha_second, $description);
        $this->editChapters(); // Rediriger vers la liste des chapitres après ajout du lien
    }

    public function supLink($params) {
        $adv_id = $_GET['adv_id'];
        $links = $this->adminModel->getLinks();
        include(ROOT_DIR . 'app/views/admin/supLink.php');
    }

    public function deleteLink($params) {
        $adv_id = (int) $_GET['adv_id'];
        $cha_first = (int) $_GET['cha_first'];
        $cha_second = (int) $_GET['cha_second'];
        $this->adminModel->deleteLink($adv_id, $cha_first, $cha_second);
        $this->editChapters(); // Rediriger vers la liste des chapitres après suppression du lien
    }

    public function addItem() {
        $itemTypes = $this->adminModel->getItemsType();
        include(ROOT_DIR . 'app/views/admin/addItem.php');
    }

    public function editItem($params) {
        $itemId = $params[0];
        $item = $this->adminModel->getItemsById($itemId);
        $types= $this->adminModel->getItemsType();
        include(ROOT_DIR . 'app/views/admin/editItem.php');
    }


    public function insertItem() {
        $name = htmlspecialchars(trim($_POST['name']));
        $description = htmlspecialchars(trim($_POST['description']));
        $weight = (int) $_POST['weight'];
        $value = (int) $_POST['value'];
        $stackable = (bool) $_POST['stackable'];
        $price = (int) $_POST['price'];
        $typeId = (int) $_POST['type_id'];
        $xp = (int) $_POST['xp'];
        $this->adminModel->insertItem($name, $description, $weight, $value, $stackable, $price, $typeId,$xp);
        $this->editItems(); // Rediriger vers la liste des items après insertion
        header("Location: index.php?url=admin/editItems");
    }

    public function updateItem() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire
            $itemId = $_POST['itemId'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $poids = $_POST['poids'];
            $valeur = $_POST['valeur'];
            $stackable = $_POST['stackable'];
            $price = $_POST['price'];
            $typeId = $_POST['typeId']; // Récupérer l'ID du type sélectionné
    
            if (empty($typeId)) {
                // Vous pouvez ajouter un message d'erreur ou une redirection si typeId est manquant
                echo "Le type d'item est requis.";
                return;
            }
            $this->adminModel->updateItem($itemId, $name, $description, $poids, $valeur, $stackable, $price, $typeId);
            header("Location: index.php?url=admin/editItems");
        }
    }



    public function deleteItem($params) {
        $itemId = (int) $params[0];
        $this->adminModel->deleteItem($itemId);
        $this->editItems(); // Revenir à la liste des items après suppression
    }

    public function addMonster() {
        include(ROOT_DIR . 'app/views/admin/addMonster.php');
    }

    public function insertMonster() {
        $name = htmlspecialchars(trim($_POST['ent_nom']));
        $description = htmlspecialchars(trim($_POST['ent_description']));
        $pv = (int) $_POST['ent_pv'];
        $mana = (int) $_POST['ent_mana'];
        $strength = (int) $_POST['ent_strength'];
        $initiative = (int) $_POST['ent_initiative'];
        $capacity = htmlspecialchars(trim($_POST['ent_capacity']));
        $attack = (int) $_POST['ent_attack'];
        $maxPv = (int) $_POST['ent_pv_max'];
        $maxMana = (int) $_POST['ent_mana_max'];
        $this->adminModel->insertMonster($name, $description, $pv, $mana, $strength, $initiative, $capacity, $attack, $maxPv, $maxMana);
        $this->editMonsters(); // Revenir à la liste des monstres après ajout
    }

    public function updateMonster() {
        $this->checkAdmin(); // Vérification des droits d'administrateur
    
        // Vérifier si les données sont passées en POST
        if (isset($_POST['ent_id'], $_POST['ent_nom'], $_POST['ent_description'], $_POST['ent_pv'], $_POST['ent_mana'], $_POST['ent_strength'], $_POST['ent_initiative'], $_POST['ent_capacity'], $_POST['ent_attack'], $_POST['ent_pv_max'], $_POST['ent_mana_max'])) {
    
            // Récupération des valeurs depuis le formulaire
            $monsterId = (int) $_POST['ent_id'];
            $name = htmlspecialchars(trim($_POST['ent_nom']));
            $description = htmlspecialchars(trim($_POST['ent_description']));
            $pv = (int) $_POST['ent_pv'];
            $mana = (int) $_POST['ent_mana'];
            $strength = (int) $_POST['ent_strength'];
            $initiative = (int) $_POST['ent_initiative'];
            $capacity = htmlspecialchars(trim($_POST['ent_capacity']));
            $attack = (int) $_POST['ent_attack'];
            $maxPv = (int) $_POST['ent_pv_max'];
            $maxMana = (int) $_POST['ent_mana_max'];
            $lootId = (int) $_POST['ent_loot_id'];
            try {
                
                $this->adminModel->updateMonster($monsterId, $name, $description, $pv, $mana, $strength, $initiative, $capacity, $attack, $maxPv, $maxMana, $lootId);
                    header("Location: index.php?url=admin/editMonsters&success=Le monstre a été mis à jour avec succès.");
                    exit();
            } catch (Exception $e) {
                // Si une erreur survient, capturer et afficher
                header("Location: index.php?url=admin/editMonsters&error=" . urlencode($e->getMessage()));
                exit();
            }
        } else {
            // Si des données manquent, afficher un message d'erreur
            header("Location: index.php?url=admin/editMonsters&error=Des données sont manquantes.");
            exit();
        }
    }
    



    public function deleteMonster($params) {
        $entId = (int) $params[0];
        $this->adminModel->deleteMonster($entId);
        $this->editMonsters(); // Revenir à la liste des monstres après suppression
    }

    public function editMonsterToChapter($params) {
        if (isset($params[0])) {
            $chapterId = (int)$params[0]; 
        } else {
            header("Location: index.php?url=admin/editChapters&error=Chapter not specified.");
            exit();
        }
        if (isset($_SESSION['choix_adv_id'])) {
            $advId = $_SESSION['choix_adv_id'];
        } else {
            header("Location: index.php?url=admin/editChapters&error=Adventure not selected.");
            exit();
        }
        $chapter = $this->adminModel->getChapterById($chapterId);
        $monsters = $this->adminModel->getMonsters(); 
        $currentMonster = $this->adminModel->getMonsterByChapter($chapterId);
        include(ROOT_DIR . 'app/views/admin/editMonsterToChapter.php');
    }
    

    public function insertMonsterToChapter() {
        $this->checkAdmin();
    
        if (isset($_POST['chapter_id']) && isset($_POST['monster_id'])) {
            $chapterId = (int)$_POST['chapter_id'];
            $monsterId = (int)$_POST['monster_id'];

            $this->adminModel->insertMonsterToChapter($chapterId, $monsterId);

            header("Location: index.php?url=admin/editMonsterToChapter/$chapterId&message=Monstre ajouté avec succès");
            exit();
        } else {
            header("Location: index.php?url=admin/editMonsterToChapter/$chapterId&error=Erreur lors de l'ajout du monstre");
            exit();
        }
    }

    public function deleteMonsterFromChapter() {
        $this->checkAdmin();
    
        // Vérifier si un chapitre et un monstre sont définis
        if (isset($_POST['chapter_id']) && isset($_POST['monster_id'])) {
            $chapterId = (int)$_POST['chapter_id'];
            $monsterId = (int)$_POST['monster_id'];
    
            // Supprimer le monstre du chapitre
            $this->adminModel->deleteMonsterFromChapter($chapterId, $monsterId);
    
            // Message de confirmation
            header("Location: index.php?url=admin/editMonsterToChapter/$chapterId&message=Monstre supprimé avec succès");
            exit();
        } else {
            header("Location: index.php?url=admin/editMonsterToChapter/$chapterId&error=Erreur lors de la suppression du monstre");
            exit();
        }
    }

    public function editAdventures() {
        $adventures =$this->adminModel->getAdventures();
        include(ROOT_DIR . 'app/views/admin/editAdventures.php');
    }

    public function addAdventure() {
        //$adventures =$this->adminModel->getAdventures();
        include(ROOT_DIR . 'app/views/admin/addAdventure.php');
    }

    public function updateAdventure($params) {
        if (isset($params[0])) {
            $advId = (int)$params[0]; 
        } else {
            header("Location: index.php?url=admin/editAdventures&error=Adventure not found.");
            exit();
        }
        $advLibelle = $_POST['libelle']; 
        $advDiscription = $_POST['description'];
        $this->adminModel->updateAdventure($advId, $advLibelle, $advDiscription);
        header("Location: index.php?url=admin/editAdventures&message=Adventure updated successfully");
        exit();
    }

    public function insertAdventure($params) {

        if (isset($_POST['libelle'], $_POST['description'])) {
            $advLibelle = $_POST['libelle']; 
            $advDiscription = $_POST['description'];

            $this->adminModel->insertAdventure($advLibelle, $advDiscription);
            header("Location: index.php?url=admin/editAdventures&message=Adventure added successfully");
            exit();
        } else {
            header("Location: index.php?url=admin/editAdventures&error=Missing data.");
            exit();
        }
    }


    public function deleteAdventure($params) {
        // Vérifier si l'ID de l'aventure est présent dans les paramètres
        if (isset($_GET['adv_id'])) {
            $adv_id = (int)$_GET['adv_id'];
        } else {
            header("Location: index.php?url=admin/editAdventures&error=Adventure%20ID%20missing.");
            exit();
        }
    
        // Vérifier si l'aventure existe dans la base de données
        $adventure = $this->adminModel->getAdventureById($adv_id);
        if (!$adventure) {
            // Si l'aventure n'existe pas, rediriger avec une erreur
            header("Location: index.php?url=admin/editAdventures&error=Adventure%20not%20found.");
            exit();
        }
    
        // Récupérer tous les chapitres associés à l'aventure
        $chapters = $this->adminModel->getChaptersByAdventure($adv_id);
    
        // Supprimer chaque chapitre associé
        foreach ($chapters as $chapter) {
            $this->adminModel->deleteChapter([$chapter['CHA_ID']]);
        }
    
        // Une fois tous les chapitres supprimés, supprimer l'aventure elle-même
        try {
            $this->adminModel->deleteAdventure($adv_id);
            header("Location: index.php?url=admin/editAdventures&success=Adventure%20deleted.");
            exit();
        } catch (Exception $e) {
            // Log l'erreur
            error_log($e->getMessage());
            header("Location: index.php?url=admin/editAdventures&error=Error%20deleting%20adventure&details=" . urlencode($e->getMessage()));
            exit();
        }
    }
    
    
    
    // Méthode par défaut
    public function show() {
        $chapters = $this->adminModel->getChapters();
        $items = $this->adminModel->getItems();
        $users = $this->adminModel->getUser();
        $monsters = $this->adminModel->getMonsters();
        $adventures = $this->adminModel->getAdventures();
        include(ROOT_DIR . 'app/views/admin/admin.php');
    }
}
?>