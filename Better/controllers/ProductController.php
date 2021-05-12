<?php


namespace app\controllers;


use app\models\Product;
use app\Router;

class ProductController
{
    public function index(Router $router)
    {
        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);

        $router->renderView('/products/index', [
            'products' => $products
        ]);
    }


    public function create(Router $router)
    {
        $errors = [];
        $productData = [
            'title' => '',
            'description' => '',
            'price' => '',
            'imageFile' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'];
            $productData['price'] = $_POST['price'];
            $productData['imageFile'] = $_FILES['image'];

            $product = new Product();
            $product->load($productData);
            $errors = $product->save();
            if (empty($errors)) {
                header('Location: /products');
                exit();
            }
        }

        $router->renderView('/products/create', [
            'product' => $productData,
            'errors' => $errors
        ]);
    }


    public function update()
    {
        echo 'Update method';
    }


    public function delete()
    {
        echo 'delete method';
    }
}