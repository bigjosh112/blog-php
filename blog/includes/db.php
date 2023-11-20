<?php

$dsn = "mysql:host=localhost;dbname=blog-php";

try {
    $pdo = new PDO($dsn, 'root', '');
} catch (PDOException $e) {
    $e->getMessage();
}