<?php

$productId = $_GET['id'];
if (!$productId) {
    header('Location: index.php');
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=products_curd;charset=utf8mb4", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$statement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$statement->bindValue(':id', $productId);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);


$errors = [];
$title = $product['title'];
$description = $product['description'];
$price = $product['price'];
$imagePath = $product['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if (!$title) {
        $errors['title'] = 'Title field can not be empty';
    }
    if (!$description) {
        $errors['description'] = 'Description field can not be empty';
    }
    if (!$price) {
        $errors['price'] = 'Price field can not be empty';
    }

    if (!is_dir('images')) {
        if (!mkdir('images')) {
            echo 'Images Directory can not be created!';
            exit;
        }
    }

    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;

        if ($image && $image['tmp_name']) {
            unlink($product['image']);

            $imageFolder = 'images/' . bin2hex(random_bytes(5));
            if (!mkdir($imageFolder)) {
                echo 'Directory can not be created!';
                exit;
            }
            $imagePath = $imageFolder . '/' . $image['name'];

            if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
                echo 'Move file to disk unsuccessful';
                exit;
            }
        }

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

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Product</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- component -->
<div class="flex mt-8 justify-center">
    <div class="md:w-1/2 lg:w-1/3 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <h1 class="text-white font-bold text-center bg-red-300 py-2 mb-6">Update Product</h1>
        <?php if (!empty($errors)):?>
            <?php foreach ($errors as $error): ?>
                <p class="text-red-500 text-xs italic"><?= $error ?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-4">
                <img src="<?php echo $product['image'] ?>" alt="Product image" class="w-14 h-14">
                <label class="block text-grey-darker text-sm font-bold capitalize mb-2" for="username">
                    image
                </label>
                <input type="file" name="image">
            </div>
            <div class="mb-4">
                <label class="block text-grey-darker text-sm capitalize font-bold mb-2" for="title">
                    title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" type="text"
                       name="title" placeholder="title" value="<?= $title ?>">
            </div>
            <div class="mb-4">
                <label class="capitalize block text-grey-darker text-sm font-bold mb-2" for="description">
                    description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                          name="description" placeholder="description"><?= $description ?></textarea>
            </div>
            <div class="mb-4">
                <label class="capitalize block text-grey-darker text-sm font-bold mb-2" for="price">
                    price
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" name="price"
                       type="number" step=".01" placeholder="price" value="<?= $price ?>">
            </div>
            <div class="flex items-center justify-between">
                <button class="bg-blue-400 hover:bg-blue-500 text-white uppercase font-bold py-2 px-4 rounded"
                        type="submit">
                    Update
                </button>
                <a href="index.php" class="bg-gray-400 hover:bg-gray-500 text-white uppercase font-bold py-2 px-4 rounded"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
</body>
</html>