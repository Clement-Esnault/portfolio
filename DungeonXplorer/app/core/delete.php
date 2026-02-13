<?php

require_once 'config.php';

$userId = $_SESSION['user_id'];

$db->beginTransaction();

try {

 
    $stmt = $db->prepare("
        SELECT ENT_ID FROM DUN_SAVE WHERE COM_ID = :user_id
    ");
    $stmt->execute(['user_id' => $userId]);
    $entIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $db->prepare("DELETE FROM DUN_INVENTORY WHERE ENT_ID IN ($in)")
            ->execute($entIds);

            $db->prepare("
                DELETE de
                FROM DUN_EQUIPMENT de
                JOIN DUN_ENTITY di ON di.ENT_ID = de.ENT_ID
                WHERE di.ENT_ID IN ($in)
            ")->execute($entIds);


    
    $db->prepare("DELETE FROM DUN_SAVE WHERE COM_ID = ?")
    ->execute([$userId]);

    if (!empty($entIds)) {
        $in = implode(',', array_fill(0, count($entIds), '?'));

       
        $db->prepare("DELETE FROM DUN_HERO WHERE ENT_ID IN ($in)")
        ->execute($entIds);

       
        $db->prepare("DELETE FROM DUN_ENTITY WHERE ENT_ID IN ($in)")
        ->execute($entIds);
    }

   
    $db->prepare("DELETE FROM DUN_COMPTE WHERE COM_ID = ?")
    ->execute([$userId]);

    $db->commit();

} catch (Exception $e) {
    $db->rollBack();
    die('Delete failed: ' . $e->getMessage());
}

session_unset();
session_destroy();
header('Location: home');
exit;
