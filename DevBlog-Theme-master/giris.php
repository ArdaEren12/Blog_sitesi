<?php
session_start();
include("ayar.php");

// Eğer zaten giriş yapıldıysa admin paneline yönlendir
if (isset($_SESSION["admin_giris"]) && $_SESSION["admin_giris"] === true) {
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici_adi = $_POST["kullanici_adi"];
    $sifre = $_POST["sifre"];

    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
    $sorgu->execute([$kullanici_adi]);
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($kullanici && $sifre === $kullanici['sifre']) {
        $_SESSION["admin_giris"] = true;
        $_SESSION["kullanici_adi"] = $kullanici['kullanici_adi'];
        header("Location: admin.php");
        exit;
    } else {
        $hata = "Kullanıcı adı veya şifre yanlış!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f2f2f2;
        }

        .giris-kutusu {
            width: 300px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .hata {
            color: red;
            margin-top: 10px;
            text-align: center;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="giris-kutusu">
    <h2>Admin Girişi</h2>
    <form method="POST">
        <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" required>
        <input type="password" name="sifre" placeholder="Şifre" required>
        <input type="submit" value="Giriş Yap">
    </form>
    <?php if (isset($hata)) { echo "<div class='hata'>$hata</div>"; } ?>
</div>

</body>
</html>
