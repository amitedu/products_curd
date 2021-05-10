<?php


namespace app;

use PDO;

class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=localhost;dbname=products_curd;charset=utf8mb4", "root", "");
        $$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
}