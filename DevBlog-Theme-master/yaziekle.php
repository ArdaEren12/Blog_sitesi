<?php
include("ayar.php");
include("func.php");
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yazı Ekle</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff7e5f, #feb47b);
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }

        header .logo {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            text-decoration: none;
        }

        header .menu {
            margin-left: 15px;
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        header .menu:hover {
            text-decoration: underline;
        }

        h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        textarea {
            resize: none;
        }

        input[type="submit"] {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }

        .message {
            text-align: center;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .message.success {
            color: green;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <header class="container">
        <div class="row">
            <div class="col-lg-6">
                <a href="" class="logo"><strong>Yazı Ekle </strong></a>
            </div>
            <div class="col-lg-6 text-right">
                <a href="index.php" class="menu">Siteyi Görüntüle</a>
                <a href="admin.php" class="menu">Yazılar</a>
                <a href="yaziekle.php" class="menu">Yazı Ekle</a>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>Yeni Blog Yazısı Ekle   (resim eklerken pikselleri ayralayıp ekle)  </h1>

        <?php 
        if ($_POST) {
            $baslik = htmlspecialchars($_POST['baslik']);
            $icerik = $_POST['icerik']; // HTML etiketleri için htmlspecialchars uygulanmazsa resim koyabilirsin
            $link = permalink($baslik);

            // Resim işlemleri
            $resimAdi = null;

            if ($_FILES['resim']['error'] == 0) {
                $dosyaAdi = $_FILES['resim']['name'];
                $geciciYol = $_FILES['resim']['tmp_name'];
                $uzanti = pathinfo($dosyaAdi, PATHINFO_EXTENSION);
                $yeniDosyaAdi = uniqid() . '.' . $uzanti;

                if (!is_dir('uploads')) {
                    mkdir('uploads');
                }

                if (move_uploaded_file($geciciYol, "uploads/" . $yeniDosyaAdi)) {
                    $resimAdi = $yeniDosyaAdi;
                } else {
                    echo '<p class="message error">Resim yüklenemedi!</p>';
                }
            }

            if (empty($baslik) || empty($icerik)) {
                echo '<p class="message error">Başlık ve içerik boş olamaz!</p>';
            } else {
                try {
                    $ekle = $db->prepare("INSERT INTO yazilar (yazi_baslik, yazi_aciklama, yazi_link, yazi_resim) VALUES (?, ?, ?, ?)");
                    $sonuc = $ekle->execute([$baslik, $icerik, $link, $resimAdi]);

                    if ($sonuc) {
                        echo '<p class="message success">Yazı başarıyla eklendi!</p>';
                        header("Refresh:2; url=yaziekle.php");
                    } else {
                        echo '<p class="message error">Yazı eklenirken bir hata oluştu!</p>';
                    }
                } catch (PDOException $e) {
                    echo '<p class="message error">Hata: ' . $e->getMessage() . '</p>';
                }
            }
        }
        ?>

        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="baslik" placeholder="Başlık" required>
            <textarea name="icerik" cols="30" rows="10" placeholder="İçerik" required></textarea>
            <input type="file" name="resim" accept="image/*">
            <input type="submit" value="Yayınla/Paylaş">
        </form>
    </div>
</body>
</html>
