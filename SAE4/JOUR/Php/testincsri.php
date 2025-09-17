<?php

include "connection.php";





$cli_nom =$_POST["nom"];
$cli_prenom = $_POST["prenom"];
$cli_email = $_POST["email"];
$cli_mdp = $_POST['mdp'];
$cli_tel = $_POST['tel'];


echo $cli_nom,' ',$cli_prenom,' ',$cli_email,' ', $cli_mdp, ' ', $cli_tel;

$sql = "Insert into rap_client(cli_num,cli_nom,cli_prenom,cli_courriel,cli_motdepasse,cli_tel) values ((select max(cli_num)+1 from rap_client),:nom,:prenom, :email, :mdp, :tel)";

$sql2 = "SELECT COUNT(*) FROM rap_client WHERE cli_courriel = :email";




try{
    $conn = OuvrirConnexionPDO($db,$db_username,$db_password);

    $stmt2 = $conn->prepare($sql2);
    $stmt2->bindParam(':email', $cli_email);
    $stmt2->execute();

    $count = $stmt2->fetchColumn();
    if ($count > 0) {
        echo "<script>alert('Un email est déjà utilisé pour ce compte.'); window.history.back();</script>";
    } else {

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nom', $cli_nom);
    $stmt->bindParam(':prenom', $cli_prenom);
    $stmt->bindParam(':email', $cli_email);
    $stmt->bindParam(':mdp', $cli_mdp);
    $stmt->bindParam(':tel', $cli_tel);

    $stmt->execute();
    echo "<script>alert('Inscription réussie !');
    window.location.href = 'menu.php';</script>";

    exit();
    }

    

    }catch(PDOException $e){
        echo "<br>Erreur PDO : " . $e->getMessage();

    }














?>