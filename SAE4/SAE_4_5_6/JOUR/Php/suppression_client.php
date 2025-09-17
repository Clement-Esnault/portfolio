<?php

// Inclure la connexion à la base de données
include "../connection.php";
$conn = OuvrirConnexionPDO($db, $db_username, $db_password);

if (isset($_POST['id'])) {
    $id = $_POST['id']; 

        try {

            $sql = "select count(*) from rap_fidelisation where cli_num = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn(); 


            if($count > 0){
                $sql = "Delete from rap_fidelisation where cli_num = '".$id."'";
                majDonneesPDO($conn,$sql) ;
                $sql = "delete from rap_appartenir where com_num in (select com_num from rap_commande where cli_num ='".$id."')";
                majDonneesPDO($conn,$sql) ;
               
                $sql = "Delete from rap_commande where cli_num = '".$id."'";
                majDonneesPDO($conn,$sql) ;
                
            }
          
            $sql = "Delete from rap_client where cli_num = '".$id."'";
            majDonneesPDO($conn,$sql) ;


            echo "<script>alert('Suppression réussie !');
            window.location.href = 'dashboard-cli.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Suppression échoué !');
           </script>";
            echo "<br>Erreur PDO : " . $e->getMessage();

        }
    

} else {
    echo "<script>alert('Echec !');
   </script>";
    echo "<br>Erreur PDO : " . $e->getMessage();
}

?>
