<?php

/** @var $pdo \PDO */
require_once "../database.php";

$search = $_GET['search'] ?? '';
if ($search) {
    $statement = $pdo->prepare("SELECT * FROM products WHERE title LIKE :title");
    $statement->bindValue(':title', "%$search%");
} else {
    $statement = $pdo->prepare('SELECT * FROM products ORDER BY create_date DESC;');
}

$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<?php include_once "views/partials/header.php"; ?>

<div class="md:px-32 py-8 w-full mt-6">
    <h1 class="text-white font-bold text-center bg-red-300 py-2 mb-6">Products CRUD</h1>

<!--    Create Button -->
    <div class="flex justify-between"><a class="bg-green-500 mb-4 px-4 py-2 text-white rounded inline-block font-bold align-left"
          href="index.php">Home</a>
        <a class="bg-green-500 mb-4 px-4 py-2 text-white rounded inline-block font-bold align-left"
           href="create.php">Add Product</a>
    </div>

<!--    search-->
    <form action="" method="get" class="border border-solid rounded flex mb-4">
        <input class="w-full rounded p-2" name="search" type="text" placeholder="Search product here...">
        <button type="submit" class="bg-red-400 hover:bg-red-500 w-auto flex justify-end items-center text-white p-2 pl-4 pr-4">
            search
        </button>
    </form>

<!--    table -->
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
                    <td class="text-left py-3 px-4 h-8 w-8 "><img src="<?= $product['image'] ?>" alt="Product Image"></td>
                    <td class="text-left py-3 px-4"><?= $product['title'] ?></td>
                    <td class="text-left py-3 px-4"><?= $product['price'] ?></td>
                    <td class="text-left py-3 px-4"><?= $product['create_date'] ?></td>
                    <td class="text-left py-3 px-4">
                        <a href="update.php?id=<?php echo $product['id'] ?>" class="inline-block text-blue-500 bg-transparent border border-solid border-blue-500 hover:bg-blue-500 hover:text-white active:bg-blue-600 font-bold uppercase text-xs px-2 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                            Edit
                        </a>
                        <form action="delete.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
                            <button class="text-pink-500 bg-transparent border border-solid border-pink-500 hover:bg-pink-500 hover:text-white active:bg-pink-600 font-bold uppercase text-xs px-2 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                    type="submit"
                            >
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include_once "views/partials/footer.php"?>
