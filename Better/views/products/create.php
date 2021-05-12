<div class="flex mt-8 justify-center">
    <div class="md:w-1/2 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col">
        <h1 class="text-white font-bold text-center bg-red-300 py-2 mb-6">Create Product</h1>

        <form action="/products/create" method="post" enctype="multipart/form-data">
            <?php if (!empty($errors)):?>
                <?php foreach ($errors as $error): ?>
                    <p class="text-red-500 text-xs italic"><?= $error ?></p>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="mb-4">
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
                       name="title" placeholder="title" value="<?= $product['title'] ?>">
            </div>
            <div class="mb-4">
                <label class="capitalize block text-grey-darker text-sm font-bold mb-2" for="description">
                    description
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker"
                          name="description" placeholder="description"><?= $product['description'] ?></textarea>
            </div>
            <div class="mb-4">
                <label class="capitalize block text-grey-darker text-sm font-bold mb-2" for="price">
                    price
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" name="price"
                       type="number" step=".01" placeholder="price" value="<?= $product['price'] ?>">
            </div>
            <div class="flex items-center justify-between">
                <a href="/products" class="bg-gray-400 hover:bg-gray-500 text-white uppercase font-bold py-2 px-4 rounded"
                >
                    Cancel
                </a>
                <button class="bg-blue-400 hover:bg-blue-500 text-white uppercase font-bold py-2 px-4 rounded"
                        type="submit">
                    Create
                </button>
            </div>
        </form>
    </div>
</div>
