<?php

$productId = $_GET['id'];
if (!$productId) {
    header('Location: index.php');
    exit();
}

/** @var $pdo \PDO */
require_once "../database.php";

$statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$statement->bindValue(':id', $productId);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);

$pageName = 'update';
$errors = [];
$title = $product['title'];
$description = $product['description'];
$price = $product['price'];
$imagePath = $product['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "validate_product.php";

    if (empty($errors)) {
        $statement = $pdo->prepare("UPDATE products SET title = :title, description = :description, 
                  image = :image, price = :price WHERE id = :id"
        );
        $statement->bindValue('id', $productId);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);

        $statement->execute();

        header('Location: index.php');
    }
}
?>

<?php include_once "views/partials/header.php"; ?>

<?php include_once "views/products/form.php" ?>

<?php include_once "views/partials/footer.php"?>