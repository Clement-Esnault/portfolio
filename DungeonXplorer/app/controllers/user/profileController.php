<?php
include_once(ROOT_DIR . 'app/models/user/profileModel.php');
class profileController {

    protected $db;
    protected $profileModel;

    public function __construct($db) {
        $this->db = $db;
        $this->profileModel = new profileModel($this->db);
    }

    function handler($action,$params){
        switch ($action) {
        case 'updateHero':
            $this->updateHero($params);
            break;
        case 'deleteHero':
            $this->deleteHero($params);
            break;
        case 'deleteAccount':
            $this->deleteAccount();
            break;
        default:
            $this->show();
        }
    }

    function updateHero($params){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $heroId = $_POST['ent_id'];  // ID du héros à mettre à jour
            $libelle = $_POST['libelle'];  // Nouveau nom du héros
            $description = $_POST['description'];
            $this->profileModel->updateHero($heroId, $libelle, $description);
            $this->show();
        }
    }

    public function deleteHero() {
        if (isset($_POST['ent_id'])) {
            $entId = (int)$_POST['ent_id'];
            if ($entId > 0) {
                // Appelle la méthode du modèle pour supprimer le héros et ses données associées
                $this->profileModel->deleteHero($entId);

                // Redirige l'utilisateur ou affiche un message de succès
                $_SESSION['message'] = "Héros supprimé avec succès.";
                header('Location: index.php?url=profile');
                exit();
            } else {
                die("ID du héros invalide.");
            }
        } else {
            die("ID du héros manquant.");
        }
    }

    public function deleteAccount(){
        $comId = $_SESSION['user_id'];
        $this->profileModel->deleteAccount($comId);
        header('Location: logoff');
    }


    function show(){
        $heroes = $this->profileModel->getProfileHeroes($_SESSION['user_id']);
        include(ROOT_DIR . 'app/views/user/profile.php');
    }


    public function saveGame() {
        // Vérifier que le joueur a un héros en session
        if (!isset($_SESSION['hero_id'])) {
            die("Aucun héros trouvé en session.");
        }

        // Charger les informations de l'aventure et du chapitre actuel
        $advId = $_SESSION['adv_id'];
        $chaId = $_SESSION['chapter_id'];
        $heroId = $_SESSION['hero_id'];

        // Effectuer la sauvegarde du jeu
        $stmt = $this->db->prepare("
            INSERT INTO DUN_SAVE (ADV_ID, CHA_ID, COM_ID, ENT_ID)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$advId, $chaId, $_SESSION['user_id'], $heroId]);

        // Confirmer la sauvegarde et rediriger (ou afficher un message)
        echo "Jeu sauvegardé avec succès!";
        header("Location: index.php?url=chapter&chapter_id=" . $chaId); // Rediriger vers le chapitre actuel
        exit;
    }

}

?>