<?php
$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');

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
}