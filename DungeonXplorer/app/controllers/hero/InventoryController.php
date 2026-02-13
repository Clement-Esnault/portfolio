<?php

require_once ROOT_DIR . 'app/models/hero/InventoryModel.php';

class InventoryController
{
    protected $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function show($items, $stats)
    {
        
        include ROOT_DIR . 'app/views/hero/InventoryView.php';
    }

    public function handleRequest(): void{
        
        $InventoryModel = new InventoryModel($this->db);
        $items = $InventoryModel->getInventory($_SESSION['hero_id']);
        $stats = $InventoryModel->getPlayerStats($_SESSION['hero_id']);

        $this->show($items, $stats);
    }

    
}