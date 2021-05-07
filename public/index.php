<?php

    $pdo = new PDO("mysql:host=localhost;dbname=products_curd;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC;');
    $statement->execute();
    $products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Products CRUD</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- component -->
<div class="md:px-32 py-8 w-full">
    <h1 class="text-white font-bold text-center bg-red-200 py-2 mb-6">Products CRUD</h1>
    <a class="bg-green-500 mb-6 px-4 py-2 text-white rounded inline-block font-bold align-left" href="create.php">Create</a>
    <div class="shadow overflow-hidden rounded border-b border-gray-200">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">#</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">image</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">title</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">price</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">create on</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">action</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
            <?php foreach ($products as $i => $product): ?>
                <tr>
                    <td class="text-left py-3 px-4"><?= $i + 1 ?></td>
                    <td class="text-left py-3 px-4"></td>
                    <td class="text-left py-3 px-4"><?= $product['title'] ?></td>
                    <td class="text-left py-3 px-4"><?= $product['price'] ?></td>
                    <td class="text-left py-3 px-4"><?= $product['create_date'] ?></td>
                    <td class="text-left py-3 px-4">
                        <button class="text-blue-500 bg-transparent border border-solid border-blue-500 hover:bg-blue-500 hover:text-white active:bg-blue-600 font-bold uppercase text-xs px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button"
                        >
                            Edit
                        </button>
                        <button class="text-pink-500 bg-transparent border border-solid border-pink-500 hover:bg-pink-500 hover:text-white active:bg-pink-600 font-bold uppercase text-xs px-4 py-2 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>