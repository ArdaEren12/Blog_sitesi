<?php
include("ayar.php");

// Form gönderildiğinde veritabanını güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $baslik = trim($_POST['baslik']);   
    $aciklama = isset($_POST['aciklama']) ? trim($_POST['aciklama']) : ''; 
    $link = trim($_POST['link']);
    $kategori = trim($_POST['kategori']); // Kategori verisi alınıyor

    if ($baslik && $aciklama && $link && $kategori) {
        $guncelle = $db->prepare("UPDATE yazilar SET yazi_baslik = ?, yazi_aciklama = ?, yazi_link = ?, kategori = ? WHERE yazi_id = ?");
        $guncelle->execute([$baslik, $aciklama, $link, $kategori, $id]);
        header("Location: admin.php?durum=guncellendi");
        exit;
    } else {
        $hata = "Lütfen tüm alanları doldurun.";
    }
}

// ID varsa, düzenlenecek yazıyı çek
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];
    $veri = $db->prepare("SELECT * FROM yazilar WHERE yazi_id = ?");
    $veri->execute([$id]);
    $yazi = $veri->fetch(PDO::FETCH_ASSOC);

    if (!$yazi) {
        die("Yazı bulunamadı. ID: $id");
    }
} else {
    die("Geçersiz ID.");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Yazı Düzenle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #43cea2, #185a9d);
            color: #fff;
            padding: 30px;
        }

        .form-container {
            background: #fff;
            color: #333;
            padding: 30px;
            border-radius: 10px;
            max-width: 600px;
            margin: auto;
        }

        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            height: 200px;
            resize: vertical;
        }

        .btn {
            background-color: #43cea2;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #2bc0a3;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Yazı Düzenle</h2>

    <?php if (isset($hata)) echo "<p class='error'>$hata</p>"; ?>

    <form action="duzenle.php" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($yazi['yazi_id']) ?>">
        
        <label for="baslik">Başlık</label>
        <input type="text" name="baslik" id="baslik" value="<?= htmlspecialchars($yazi['yazi_baslik']) ?>" required>

        <label for="aciklama">İçerik</label>
        <textarea name="aciklama" id="aciklama" required><?= htmlspecialchars($yazi['yazi_aciklama']) ?></textarea>

        <label for="link">Link</label>
        <input type="text" name="link" id="link" value="<?= htmlspecialchars($yazi['yazi_link']) ?>" required>

        <label for="kategori">Kategori</label>
        <select name="kategori" id="kategori" required>
            <option value="Yazılım" <?= $yazi['kategori'] == 'Yazılım' ? 'selected' : '' ?>>Yazılım</option>
            <option value="Algoritma" <?= $yazi['kategori'] == 'Algoritma' ? 'selected' : '' ?>>Algoritma</option>
            <option value="3D Modelleme" <?= $yazi['kategori'] == '3D Modelleme' ? 'selected' : '' ?>>3D Modelleme</option>
            <option value="Diğer" <?= $yazi['kategori'] == 'Diğer' ? 'selected' : '' ?>>Diğer</option>
        </select>

        <button class="btn" type="submit">Kaydet</button>
    </form>
</div>
</body>
</html>
