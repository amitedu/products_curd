<?php


namespace app\controllers;


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
        $router->renderView('/products/create');
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