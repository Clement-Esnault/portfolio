<?php
    $host = 'localhost';
    $db_username = "dx08";
    $db_password = "ohtataLib2iophee";
    $dbname = "dx08_bd";
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
        //echo "Connexion réussie !";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
?>