<?php

session_start();

include "../connection.php";

$conn = OuvrirConnexionPDO($db,$db_username,$db_password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    $tab = [];
    $sql = "select * from rap_client where cli_courriel = '".$email."'";
    LireDonneesPDO1($conn, $sql,  $tab);

    $id_db = $tab[0]['CLI_NUM'];
    $email_db = $tab[0]['CLI_COURRIEL'];
    $nom_db = $tab[0]['CLI_PRENOM'];
    $mdp_db = $tab[0]['CLI_MOTDEPASSE'];
    $admin = $tab[0]['EST_GERANT'];
    if($email === $email_db && $password === $mdp_db){
        $_SESSION['user_id'] = $id_db;
        $_SESSION['email'] = $email_db;
        $_SESSION['nom'] = $nom_db;
        $_SESSION['gerant'] = $admin;
        $_SESSION['is_logged_in'] = true;
        $_SESSION['wallet'] = [];
        header('Location: ../menu.php');
        exit();
    }
    else{
        echo "Erreur de connexion";
    }

} else {
    echo "Méthode de requête non autorisée.";
}
?>
