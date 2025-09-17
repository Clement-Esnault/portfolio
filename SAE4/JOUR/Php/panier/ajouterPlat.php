<?php
session_start();

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {

    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];

    if (isset($_SESSION['wallet'])) {

        $_SESSION['wallet'][$product_id] = $quantity;

    }

}

?>