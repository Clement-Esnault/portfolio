<?php 

include "connection.php";

$conn = OuvrirConnexionPDO($db,$db_username,$db_password);

if (isset($_GET['categorie'])) {
    $categorie = $_GET['categorie'];

    switch ($categorie) {
        case 'Legumes':
            Legumes($conn);
            break;
        case 'Boissons':
            Boissons($conn);
            break;
        case 'Desserts':
            Desserts($conn);
            break;
        case 'Plats':
            Plats($conn);
            break;
        case 'Menus':
            Menus($conn);
            break;
        default:
            echo "Catégorie inconnue.";
    }

}
if (isset($_GET['categorieMenu'])) {
    $categorieMenu = $_GET['categorieMenu'];

    if (isset($_GET['id'])) {  // Vérification de la présence de l'ID
        $id = $_GET['id'];  // Assurez-vous que vous récupérez l'ID depuis l'URL ou le formulaire
        switch ($categorieMenu) {
            case 'Legumes':
                LegumesMenu($conn);
                break;
            case 'Boissons':
                BoissonsMenu($conn);
                break;
            case 'Desserts':
                DessertsMenu($conn);
                break;
            case 'Plats':
                PlatsMenu($conn, $id);  // Passez l'ID ici
                break;
            default:
                echo "Catégorie inconnue.";
        }
    } else {
        echo "ID manquant.";
    }
}


function Legumes($conn)
{
    $sql = "select pla_num, pla_nom,pla_prix_vente_unit_ht *1.055 from rap_plat where  trim(substr(pla_num,1,1)||'00') = trim(pla_num)";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    AfficherDonnee1($tab);
}

function Boissons($conn)
{
    $sql = "select pla_num, pla_nom,pla_prix_vente_unit_ht *1.055 from rap_plat
            
    where  trim(substr(pla_num,1,1)||'0') = trim(pla_num)";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    AfficherDonnee1($tab);
}

function Desserts($conn)
{
    $sql = "select pla_num, pla_nom,pla_prix_vente_unit_ht *1.055 from rap_plat
                    where  trim(substr(pla_num,1,1)) = trim(pla_num) and pla_num <> '0'";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    AfficherDonnee1($tab);
}

function Plats($conn)
{
    
    $sql = "select  pla_num, pla_nom,pla_prix_vente_unit_ht *1.055 from rap_plat
            where  trim(substr(pla_num,1,1)||'000') = trim(pla_num)";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    AfficherDonnee1($tab);
}


function Menus($conn)
{
    $sql = "select distinct p1.pla_nom from rap_plat p1
    join rap_plat p5 on trim(substr(p1.pla_num,4,1)) = trim(p5.pla_num)
    join rap_plat p4 on trim(substr(p1.pla_num,3,1)||'0') = trim(p4.pla_num)
    join rap_plat p3 on trim(substr(p1.pla_num,2,1)||'00') = trim(p3.pla_num)
    join rap_plat p2 on trim(substr(p1.pla_num,1,1)||'000') = trim(p2.pla_num)
    join rap_appartenir a on a.pla_num=p1.pla_num
    join rap_commande using(res_num,com_num)";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    AfficherDonnee2($tab);
}

function AfficherDonnee1($tab)
{
    foreach ($tab as $ligne) {
        $valeurs = array_values($ligne);
        if (isset($valeurs[1])) {
            echo '<div id="'.$valeurs[0].'" class="w-1/4 p-5 m-5 rounded-2xl border-5 border-solid border-white bg-black/30 p-1 text-justify text-black hover:bg-gray-300/50 hover:duration-500"><img class="rounded" src="'.trouve_image($valeurs[0]).'" alt="image de pizza"><p class="text-center mt-2 mb-2">'.$valeurs[1].'</p>
            <p>'."Prix : ".$valeurs[2]." $".' </p>
            <button onclick="add_wallet(`'.$valeurs[0].'`)" class=" w-1/1 rounded cursor-pointer p-3 text-center text-lg text-white hover:bg-green-500 hover:duration-250">Ajouter au panier</button> 
            </div>';
        }
    }
}

function AfficherDonnee2($tab)
{
    foreach ($tab as $ligne) {
        $valeurs = array_values($ligne);
        if (isset($valeurs[0])) {
            $id = trim($valeurs[0]);
            echo '<div id="'.$id.'" class="cursor-pointer w-1/4 p-5 m-5 rounded-2xl border-5 border-solid border-white bg-black/30 p-1 text-justify text-black hover:bg-gray-300/50 hover:duration-500" onClick="chargerCategorieMenu(\'Plats\');chargerCategorieMenu(\'Legumes\');chargerCategorieMenu(\'Boissons\');chargerCategorieMenu(\'Desserts\')"><img class="rounded" src="'.trouve_image($valeurs[0]).'" alt="image de pizza"><p class="text-center mt-2 mb-2">'.$valeurs[1].'</p></div>';
        }
    }
}

function AfficherDonnee3($tab)
{
    foreach ($tab as $ligne) {
        $valeurs = array_values($ligne);
        if (isset($valeurs[1])) {
            echo '<div id="'.$id.'" class="cursor-pointer w-1/4 p-5 m-5 rounded-2xl border-5 border-solid border-white bg-black/30 p-1 text-justify text-black hover:bg-gray-300/50 hover:duration-500"onClick="getId(this.id).chargerCategorieMenu("Plats").
            chargerCategorieMenu("Legumes").
            chargerCategorieMenu("Boissons").
            chargerCategorieMenu("Desserts")"><img class="rounded" src="'.trouve_image($valeurs[0]).'" alt="image de pizza"><p class="text-center mt-2 mb-2">'.$valeurs[1].'</p></div>';
        }
    }
}


function LegumesMenu($conn)
{
    $sql = "select pla_num, pla_nom,pla_prix_vente_unit_ht *1.055 from rap_plat where  trim(substr(pla_num,1,1)||'00') = trim(pla_num)";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    AfficherDonnee3($tab);
}

function AfficherTitre($conn){
    
}

function BoissonsMenu($conn)
{
    $sql = "select pla_num, pla_nom,pla_prix_vente_unit_ht *1.055 from rap_plat
            
    where  trim(substr(pla_num,1,1)||'0') = trim(pla_num)";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    $result = [];
    foreach ($tab as $ligne) {
        $valeurs = array_values($ligne);
        if (isset($valeurs[0])) {
            $result[] = [
                'pla_num' => $valeurs[0],
                'pla_nom' => $valeurs[1],
                'prix' => $valeurs[2]
            ];
        }
    }
    echo json_encode($result);
}

function DessertsMenu($conn,)
{
    $sql = "select pla_num, pla_nom,pla_prix_vente_unit_ht *1.055 from rap_plat
                    where  trim(substr(pla_num,1,1)) = trim(pla_num) and pla_num <> '0'";
    $tab = [];
    LireDonneesPDO1($conn, $sql, $tab);
    AfficherDonnee3($tab);
}

function PlatsMenu($conn, $id)
{
    if (!empty($id)) {
        if (preg_match("/Pizza/", $id)) {
            $sql = "SELECT DISTINCT pla_nom, pla_num
                    FROM rap_plat 
                    WHERE pla_num IN (
                        SELECT DISTINCT substr(pla_num, 1, 1) || '000'
                        FROM rap_plat
                        WHERE pla_num IN (SELECT pla_num FROM rap_pizza)
                    )
                    AND substr(pla_num, 1, 1) IN (
                        SELECT substr(pla_num, 1, 1) FROM rap_plat WHERE pla_nom = '$id'
                    );";
        } elseif (preg_match("/Kebab/", $id)) {
            $sql = "SELECT DISTINCT pla_nom, pla_num
                    FROM rap_plat 
                    WHERE pla_num IN (
                        SELECT DISTINCT substr(pla_num, 1, 1) || '000'
                        FROM rap_plat
                        WHERE pla_num IN (SELECT pla_num FROM rap_kebab)
                    )
                    AND substr(pla_num, 1, 1) IN (
                        SELECT substr(pla_num, 1, 1) FROM rap_plat WHERE pla_nom = '$id'
                    );";
        } else {
            echo "Aucun plat trouvé pour cette catégorie.";
            return;
        }
        
        $tab = [];
        LireDonneesPDO1($conn, $sql, $tab);
        AfficherDonnee3($tab);
    } else {
        echo "ID manquant.";
    }
}

function trouve_image($id) {
    $id = trim($id);
    $id = str_replace(' ', '', $id);
    $dossierImages = "images/";
    $cheminImage = $dossierImages . $id . ".png";
    if (file_exists($cheminImage)) {
        return $cheminImage;
    } else {
        $defaultImage = $dossierImages . "pizza.jpg";
        if (file_exists($defaultImage)){
            return $defaultImage;
        }
        else {
            error_log("Image par défaut non trouvée à l'emplacement : $defaultImage");
            return "";
        }
    }
}


function AfficherDonneeAvecImage($tab) {
    foreach ($tab as $ligne) {
        $valeurs = array_values($ligne);
        if (isset($valeurs[0], $valeurs[1])) {
            $imagePath = trouve_image($valeurs[0]);
            echo '<img src="'.$imagePath.'" alt="'.$valeurs[1].'"> ';
            echo htmlspecialchars($valeurs[1]) . "<br/>";
        }
    }
}


?>