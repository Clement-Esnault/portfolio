<?php

include "../connection.php";
$conn = OuvrirConnexionPDO($db, $db_username, $db_password);






if(isset($_GET['id'])){
    $id = $_GET['id'];

    
try{

    $sql = "Select cli_nom,cli_prenom ,com_num, com_prix_total,
            (select sum(com_prix_total)   
            from rap_commande where cli_num = '".$id."') as total_client
            from rap_commande
            join rap_client using(cli_num)
            where cli_num !=0 
            and cli_num ='".$id."'";

    $tab =[];


    LireDonneesPDO1($conn,$sql,$tab);
    AfficherDonnee1($tab);
}catch(PDOException $e){

    echo "<br>Erreur PDO : " . $e->getMessage();


}





}








?>