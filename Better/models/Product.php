<?php

namespace app\models;

use app\Database;

class Product
{
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?float $price = null;
    public ?array $imageFile = null;
    public ?string $imagePath = null;

    public function load($product): void
    {
        $this->id = $product['id'] ?? null;
        $this->title = $product['title'];
        $this->description = $product['description'];
        $this->price = (float)$product['price'];
        $this->imageFile = $product['imageFile'] ?? null;
        $this->imagePath = $product['image'] ?? null;
    }

    public function save(): array
    {
        $errors = [];
        if (!$this->title) {
            $errors['title'] = 'Title field can not be empty';
        }
        if (!$this->description) {
            $errors['description'] = 'Description field can not be empty';
        }
        if (!$this->price) {
            $errors['price'] = 'Price field can not be empty';
        }

        if (!is_dir(__DIR__ . '/../public/images')) {
            if (!mkdir(__DIR__ . '/../public/images')) {
                echo 'Images Directory can not be created!';
                exit;
            }
        }

        if (empty($errors)) {
            if ($this->imageFile && $this->imageFile['tmp_name']) {

                if ($this->imagePath) {
                    unlink(__DIR__ . '/../public/' . $this->imagePath);
                }

                $imageFolder = 'images/' . bin2hex(random_bytes(5));
                if (!mkdir(__DIR__ . '/../public/' . $imageFolder)) {
                    echo 'Directory can not be created!';
                    exit;
                }
                $this->imagePath = $imageFolder . '/' . $this->imageFile['name'];

                if (!move_uploaded_file($this->imageFile['tmp_name'], $this->imagePath)) {
                    echo 'Move file to disk unsuccessful';
                    exit;
                }
            }

            $db = Database::$db;
            if (!$db->createProduct($this)) {
                echo 'Product save on database unsuccessful';
                exit();
            }

            header('Location: /products');
            exit();
        }

        return $errors;
    }
}