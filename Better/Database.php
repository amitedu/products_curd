<?php


namespace app;

use app\models\Product;
use PDO;

class Database
{
    public \PDO $pdo;
    public static Database $db;
    
    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=products_curd;charset=utf8mb4", "root", "");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        self::$db = $this;
    }


    public function getProducts($search = ''): array
    {
        if ($search) {
            $statement = $this->pdo->prepare("SELECT * FROM products WHERE title LIKE :title");
            $statement->bindValue(':title', "%$search%");
        } else {
            $statement = $this->pdo->prepare('SELECT * FROM products ORDER BY create_date DESC;');
        }

        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }


    public function createProduct(Product $product): bool
    {
        $statement = $this->pdo->prepare("INSERT INTO products (title, description, image, price, create_date) 
            VALUE (:title, :description, :image, :price, :date)"
        );
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

        return $statement->execute();
    }
}