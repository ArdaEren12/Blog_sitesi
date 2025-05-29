<?php
try {
    $db = new PDO("mysql:host=localhost;dbname=veritabani_adi;charset=utf8", "kullanici", "şifre");
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
