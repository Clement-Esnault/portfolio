<?php

include "../connection.php";

$conn = OuvrirConnexionPDO($db, $db_username, $db_password);


    $id = $_POST['e-id'];
    $nom= $_POST['edit-nom'];
    $prenom = $_POST['edit-prenom'];
    $tel = $_POST['edit-tel'];
    $mail = $_POST['edit-email'];


    try{
        $sql = " Update rap_client set cli_nom ='".$nom."',cli_prenom='".$prenom."' , cli_tel = '".$tel."',cli_courriel = '".$mail."' where cli_num = '".$id."'";

        majDonneesPDO($conn,$sql);

        echo "<script>alert('Modification réussie !');
            window.location.href = 'dashboard-cli.php';</script>";
    }catch(PDOException $e){

        echo "
        <br>Erreur PDO : " . $e->getMessage()."
        <script>alert('Modification échoué !'); window.location.href = 'dashboard-cli.php';</script>
        ";
        

    }
















?>