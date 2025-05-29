<?php
include("ayar.php"); // veritabanı bağlantısını dahil ediyoruz

// Şifreyi hash'leyelim
$sifre = password_hash("admin123", PASSWORD_DEFAULT);

// admin kullanıcısını veritabanına ekleyelim
$sorgu = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, sifre) VALUES (?, ?)");
$sorgu->execute(['admin', $sifre]);

echo "Kullanıcı başarıyla eklendi.";
?>
