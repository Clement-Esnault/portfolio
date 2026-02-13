<?php
session_start();

// On recupere l'url
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$url = explode('/', $url);
/*echo("<br>Url:</b><br>");
var_dump($url);
echo("<br><br>");*/

//var_dump($url); // Affiche l'URL capturée

define('ROOT_DIR', __DIR__ . DIRECTORY_SEPARATOR);

require __DIR__ . '/app/core/config.php';
/*echo("<br>Connexion:</b><br>");
var_dump($db);
echo("<br><br>");

echo("<br>Session Data:</b><br>");
var_dump($_SESSION);
echo("<br><br>");*/



switch (true) {
    //---------------PAGES PRINCIPALES--------------------//
         //---------------HOME--------------------//
    case ($url == ''):
        require ROOT_DIR . 'app/views/home/home.php';
        exit;
    case ($url[0] === 'home'):
        require ROOT_DIR . 'app/views/home/home.php';
        exit;
    case ($url[0] === 'about'):
        require ROOT_DIR . 'app/views/home/about.php';
        exit;
    case ($url[0] === 'decouvrir'):
        require ROOT_DIR . 'app/controllers/adventure/adventureController.php';
        $AdventureController = new AdventureController($db);
        $AdventureController->discover();
        exit;
    case ($url[0] === 'continue'):
        require ROOT_DIR . 'app/controllers/adventure/adventureController.php';
        $AdventureController = new AdventureController($db);
        $AdventureController->savedAdventures();
        exit;
        //---------------USER--------------------//
    case ($url[0] === 'login'):
        require ROOT_DIR . 'app/views/user/login.php';
        exit;
    case ($url[0] === 'signup'):
        require ROOT_DIR . 'app/views/user/signup.php';
        exit;
    case ($url[0] === 'profile'):
        require ROOT_DIR . 'app/controllers/user/profileController.php';
        $profileController = new profileController($db);
        
        $action = $url[1] ?? null;
        $params = array_slice($url, 2); 
       
        $profileController->handler($action, $params);
        exit;
            
    case ($url[0] === 'admin'):
        require ROOT_DIR . 'app/controllers/admin/adminController.php';
        $adminController = new adminController($db);
        
        $action = $url[1] ?? null;
        $params = array_slice($url, 2); 
       
        $adminController->handleAction($action, $params);
        exit;
    
        $action = $url[1] ?? null;
        $params = array_slice($url, 2); 
       
        $profileController->handler($action, $params);
        exit;
             
    case ($url[0] === 'admin'):
        require ROOT_DIR . 'app/controllers/admin/adminController.php';
        $adminController = new adminController($db);
        
        $action = $url[1] ?? null;
        $params = array_slice($url, 2); 
       
        $adminController->handleAction($action, $params);
        exit;

    //---------------CONNEXION ET CORE PHP--------------------//

    case ($url[0] === 'config'):
        require ROOT_DIR . 'app/core/config.php';
        exit;
    case ($url[0] === 'confirmLogin'):
        require ROOT_DIR . 'app/core/confirmLogin.php';
        exit;
    case ($url[0] === 'logoff'):
        require ROOT_DIR . 'app/core/logoff.php';
        exit;
    case ($url[0] === 'register'):
        require ROOT_DIR . 'app/core/register.php';
        exit;
    case ($url[0] === 'delete'):
        require ROOT_DIR . 'app/core/delete.php';
        exit;
    
    //---------------CHAPITRE--------------------//

    case ($url[0] === 'chapterController'):
        require ROOT_DIR . 'app/controllers/chapter/chapterController.php';
        $controller = new ChapterController($db);
        $controller->handleRequest();
        exit;
    case ($url[0]== 'saveGame') :
        require ROOT_DIR . 'app/controllers/chapter/chapterController.php';
        $controller = new ChapterController($db);
        $controller->saveGame( $_SESSION['adv_id'], $_SESSION['chapter_id']);
        $controller->handleRequest();
        exit;

    //---------------HERO--------------------//
    case ($url[0] === 'choixHero'):
        include('app/controllers/hero/HeroController.php');
        $controller = new HeroController($db);
        $controller->chooseHero();
        exit;

    case ($url[0] === 'showInventory'):
        include('app/controllers/hero/InventoryController.php');
        $controller = new InventoryController($db);
        $controller->handleRequest();
        exit;
            

    //---------------COMBAT--------------------//

    case ($url[0] === 'combat'):
        require ROOT_DIR . 'app/controllers/combat/combatController.php';
        $controller = new CombatController($db);
        $controller->lancerCombat();
        exit;

    //---------------ADVENTURE--------------------//    

     case ($url[0] === 'adventure'):
        require ROOT_DIR . 'app/controllers/adventure/adventureController.php';
        $adventureController = new AdventureController($db);
        $adventureController->index();
        exit;   

    //---------------ERREURS ET EXCEPTIONS--------------------//

    default:
        http_response_code(404);
        require ROOT_DIR . 'app/views/home/404.php';
        exit;

}
