<?php
// Veri tabanı bağlantısı

$host       = "localhost";
$dbname     = "phpblog";
$charset    = "utf8";
$root       = "root";
$password   = "";

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset;", $root, $password);
} catch (PDOException $error) { // PDOExeption yerine PDOException
    echo $error->getMessage();
}