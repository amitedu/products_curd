<?php

/** @var $pdo \PDO */
require_once "../database.php";

$pageName = 'create';
$errors = [];
$title = '';
$description = '';
$imagePath = '';
$price = '';
$date = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once "validate_product.php";

    if (empty($errors)) {
        $statement = $pdo->prepare("INSERT INTO products (title, description, image, price, create_date) 
            VALUE (:title, :description, :image, :price, :date)"
        );
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->bindValue(':image', $imagePath);
        $statement->bindValue(':price', $price);
        $statement->bindValue(':date', $date);

        $statement->execute();

        header('Location: index.php');
    }
}
?>

<?php include_once "views/partials/header.php"; ?>

<?php include_once "views/products/form.php" ?>

<?php include_once "views/partials/footer.php" ?>
