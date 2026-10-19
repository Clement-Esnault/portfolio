<?php
    $host = 'localhost';
    $db_username = getenv("DB_USERNAME") ?: "";
    $db_password = getenv("DB_PASSWORD") ?: "";
    $dbname = "dx08_bd";
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $db_username, $db_password);
        //echo "Connexion réussie !";
    } catch (PDOException $e) {
        die("Erreur : " . $e->getMessage());
    }
?>