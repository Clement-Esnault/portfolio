<?php

// Inclure la connexion à la base de données
include "../connection.php";
$conn = OuvrirConnexionPDO($db, $db_username, $db_password);

if (isset($_POST['id'])) {
    $id = $_POST['id']; 

        try {
            $sql = "Delete from rap_client where cli_num = '".$id."'";
            majDonneesPDO($conn,$sql) ;

            echo "<script>alert('Suppression réussie !');
            window.location.href = 'dashboard-cli.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Suppression échoué !');
            window.location.href = 'dashboard-cli.php';</script>";
        }
    

} else {
    echo "<script>alert('Echec !');
    window.location.href = 'dashboard-cli.php';</script>";
}

?>
