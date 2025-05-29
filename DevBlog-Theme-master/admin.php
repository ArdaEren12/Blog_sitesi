<?php
session_start();
include("ayar.php");

// Giriş kontrolü
if (!isset($_SESSION["admin_giris"]) || $_SESSION["admin_giris"] !== true) {
    header("Location: giris.php");
    exit;
}

$kullaniciAdi = $_SESSION["kullanici_adi"] ?? "Kullanıcı";
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetici Paneli</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #4facfe, #00f2fe);
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 90%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding: 15px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        header .logo {
            font-size: 28px;
            font-weight: bold;
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
        }
        header .menu {
            margin-left: 15px;
            color: #00f2fe;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }
        header .menu:hover {
            color: #4facfe;
        }
        h1 {
            text-align: center;
            color: #444;
            margin: 30px 0;
        }
        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .table th,
        .table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #444;
            color: #fff;
            text-transform: uppercase;
        }
        .table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            background: #4facfe;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        .btn:hover {
            background: #00f2fe;
        }
        .actions {
            text-align: center;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header class="container">
        <div class="row">
            <div class="col-lg-6">
                <a href="#" class="logo"><strong>Yönetici Paneli</strong></a>
            </div>
            <div class="col-lg-6 text-right">
                <a href="index.php" class="menu">Siteyi Görüntüle</a>
                <a href="admin.php" class="menu">Yazılar</a>
                <a href="yaziekle.php" class="menu">Yazı Ekle</a>
            </div>
        </div>
    </header>

    <div class="container">
        <h1>Admin Paneline Hoş Geldiniz, <?php echo htmlspecialchars($kullaniciAdi); ?>!</h1>

        <table class="table">
            <tr>
                <th>Başlık</th>
                <th>Tarih</th>
                <th>İşlemler</th>
            </tr>
            <?php
            $dataList = $db->prepare("SELECT * FROM yazilar ORDER BY yazi_id DESC");
            $dataList->execute();
            $rows = $dataList->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rows as $row) {
                echo '<tr>
                        <td><a href="yazi.php?link=' . urlencode($row["yazi_link"]) . '" target="_blank">' . htmlspecialchars($row["yazi_baslik"], ENT_QUOTES, 'UTF-8') . '</a></td>
                        <td>' . htmlspecialchars($row["yazi_tarih"], ENT_QUOTES, 'UTF-8') . '</td>
                        <td class="actions">
                            <a class="btn" href="duzenle.php?id=' . $row["yazi_id"] . '">Düzenle</a>
                            <a class="btn" href="sil.php?id=' . $row["yazi_id"] . '" onclick="return confirm(\'Silmek istediğinize emin misiniz?\')">Sil</a>
                        </td>
                    </tr>';
            }
            ?>
        </table>

        <div class="logout">
            <a class="btn" href="cikis.php">Çıkış Yap</a>
        </div>
    </div>
</body>
</html>
