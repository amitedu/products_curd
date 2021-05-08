<?php

$productId = $_POST['id'];
if (!$productId) {
    header('Location: index.php');
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=products_curd;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare("DELETE FROM products WHERE id = :id");
$statement->bindValue(':id', $productId);
$statement->execute();

header('Location: index.php');
