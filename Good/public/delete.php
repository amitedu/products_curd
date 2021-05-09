<?php

$productId = $_POST['id'];
if (!$productId) {
    header('Location: index.php');
    exit();
}

/** @var $pdo \PDO */
require_once "../database.php";

$statement = $pdo->prepare("DELETE FROM products WHERE id = :id");
$statement->bindValue(':id', $productId);
$statement->execute();

header('Location: index.php');
