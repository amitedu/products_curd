<?php

$pdo = new PDO("mysql:host=localhost;dbname=dbName;charset=utf8mb4", "username", "password");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);