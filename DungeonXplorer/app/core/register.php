<?php

$com_pseudo =isset($_POST['pseudo']) ? trim($_POST['pseudo']) : '';
$com_email  =isset($_POST['email']) ? trim($_POST['email']) : '';
$com_mdp    =isset($_POST['password']) ? trim($_POST['password']) : '';

if (empty($com_pseudo) || empty($com_email) || empty($com_mdp) ) {
    echo "<script>alert('Veuillez remplir tous les champs obligatoires.'); window.history.back();</script>";
    exit();
}

try{
    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM DUN_COMPTE WHERE COM_EMAIL = :email");
    $stmtCheck->execute([':email' => $com_email]);
    if ($stmtCheck->fetchColumn() > 0) {
        echo "<script>alert('Cette adresse e-mail est déjà utilisée.'); window.history.back();</script>";
        exit();
    }


    $stmt = $db->prepare("INSERT INTO DUN_COMPTE (COM_PSEUDO, COM_EMAIL, COM_MDP,COM_TYPE) VALUES (:pseudo, :email, :password,'J')");
    $stmt->execute([
        ':pseudo' => $com_pseudo,
        ':email' => $com_email,
        ':password' => $com_mdp
    ]);

    $_SESSION['user_id'] = $db->lastInsertId();
    $_SESSION['pseudo'] = $com_pseudo;
    $_SESSION['email'] = $com_email;
   
    header('Location: home');
    exit;
}catch (PDOException $e) {
        die("Erreur de connexion : " . $e->getMessage());
}