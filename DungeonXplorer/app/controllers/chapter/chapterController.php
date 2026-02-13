<?php

require_once ROOT_DIR . 'app/models/chapter/chapterModel.php';
require_once ROOT_DIR . 'app/models/combat/combatModel.php';
require_once ROOT_DIR . 'app/models/adventure/adventureModel.php';

class ChapterController
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function show($id, $advId)
    {
        if(!isset($_SESSION['combat_ended'])){
            $_SESSION['combat_ended'] = false;
        }

        // Récupérer le chapitre depuis le modèle
        $chapterModel = new ChapterModel($this->db);
        $chapter = $chapterModel->getChapter($id, $advId);

        if (!$chapter) {
            exit("Chapitre introuvable");
        }

        // Vérifier la présence d'un monstre pour démarrer un combat
        $combatModel = new CombatModel($this->db);
        $monster = $combatModel->getMonsterInChapter($_SESSION['adv_id'], $id);

        if ($monster) {
            $_SESSION['have_fight'] = true;
            $_SESSION['monster_id'] = $monster['ENT_ID'];
            $_SESSION['monster_name'] = $monster['ENT_NOM'];

            include ROOT_DIR . 'app/views/chapitre/chapter.php';
            return;
        } else {
            $_SESSION['have_fight'] = false;
        }

        include ROOT_DIR . 'app/views/chapitre/chapter.php';
    }

    private function ensureGameSession(): void
    {
        // Vérifie que les trois clés nécessaires sont présentes dans la session
        if (
            !isset($_SESSION['adv_id']) ||
            !isset($_SESSION['hero_id']) ||
            !isset($_SESSION['chapter_id'])
        ) {
            throw new Exception("Session de jeu non initialisée");
        }
    }

    public function handleRequest(): void
    {
        if (isset($_GET['adv_id'], $_GET['cha_id'], $_GET['ent_id'])) {
            // Récupérer les valeurs passées dans l'URL
            $_SESSION['adv_id'] = (int)$_GET['adv_id'];
            $_SESSION['chapter_id'] = (int)$_GET['cha_id'];
            $_SESSION['hero_id'] = (int)$_GET['ent_id'];
        }

        if (isset($_POST['cha'])) {
            $_SESSION['chapter_id'] = (int)$_POST['cha'];
        }

        $this->ensureGameSession();

        $this->show($_SESSION['chapter_id'], $_SESSION['adv_id']);
    }

    public function saveGame(int $advId, int $chaId)
    {
        $chapterModel = new ChapterModel($this->db);
        $chapterModel->saveGame($advId, $chaId);
    }
}
