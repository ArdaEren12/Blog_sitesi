<?php
include("ayar.php");

// Blog yazısını veritabanından çek
if (isset($_GET['yazi_id'])) {
    $id = intval($_GET['yazi_id']);
    
    // Veritabanından yazıyı çek
    $sorgu = $db->prepare("SELECT * FROM yazilar WHERE yazi_id = ?");
    $sorgu->execute([$id]);
    $yazi = $sorgu->fetch(PDO::FETCH_ASSOC);

    if (!$yazi) {
        die("Bu yazı bulunamadı.");
    }
} else {
    die("Geçersiz istek.");
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8">
    <title><?php echo htmlspecialchars($yazi['yazi_baslik']); ?> - Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="theme-style" rel="stylesheet" href="assets/css/theme-1.css">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        .main-wrapper {
            display: flex;
            justify-content: space-between;
            padding: 50px 20px;
        }

        article {
            max-width: 800px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 65%;
        }

        .sidebar {
            width: 30%;
            margin-left: 20px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .blog-post-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .blog-post-header h1 {
            font-size: 36px;
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        .meta {
            font-size: 14px;
            color: #888;
            margin-top: 5px;
        }

        .blog-post-body {
            font-size: 18px;
            line-height: 1.8;
            color: #333;
        }

        .blog-post-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 20px 0;
        }

        .blog-post-footer {
            text-align: center;
            margin-top: 30px;
        }

        .blog-post-footer a {
            display: inline-block;
            padding: 12px 25px;
            background-color: #007BFF;
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .blog-post-footer a:hover {
            background-color: #0056b3;
        }

        .sidebar h3 {
            margin-bottom: 1rem;
            font-size: 1.3rem;
            color: #007bff;
            border-bottom: 2px solid #ccc;
            padding-bottom: 0.5rem;
        }

        .sidebar .other-post {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .sidebar .other-post img {
            width: 300px;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .sidebar .other-post img:hover {
            transform: scale(1.03);
        }

        .sidebar .other-post h5 {
            font-size: 1rem;
            margin-top: 0.5rem;
            color: #333;
        }

        .header {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .blog-name {
            font-size: 28px;
            font-weight: 700;
            color: #333;
        }

        .blog-name a {
            text-decoration: none;
            color: #333;
        }

        .profile-section {
            text-align: center;
        }

        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }

        .bio {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .bio a {
            color: #007BFF;
            text-decoration: none;
        }

        .bio a:hover {
            text-decoration: underline;
        }

        .social-list {
            list-style: none;
            padding: 0;
        }

        .social-list li {
            display: inline-block;
            margin: 0 10px;
        }

        .social-list a {
            color: #555;
            font-size: 18px;
        }

        .navbar-nav {
            width: 100%;
        }

        .nav-item {
            width: 100%;
        }

        .nav-link {
            color: #333;
            font-size: 16px;
            padding: 10px 0;
            text-decoration: none;
        }

        .nav-link:hover {
            color: #007BFF;
        }

        .btn-primary {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #007BFF;
            color: white;
            text-align: center;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            .blog-post-header h1 {
                font-size: 28px;
            }

            .blog-post-body {
                font-size: 16px;
            }

            .main-wrapper {
                flex-direction: column;
                align-items: center;
            }

            .sidebar {
                width: 100%;
                margin-top: 30px;
                margin-left: 0;
            }

            article {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header class="header text-center bg-info rounded ">	     
        <h1 class="blog-name pt-lg-4 mb-0"><a href="index.php">Arda'nın Blog Sayfası</a></h1>
        
        <nav class="navbar navbar-expand-lg navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navigation" class="collapse navbar-collapse flex-column ">
                <div class="profile-section pt-3 pt-lg-0">
                    <img class="profile-image mb-3 mx-auto" src="assets/images/" alt="image" style="border-radius: 50px;">			
                    
                    <div class="bio mb-3">
                        Merhaba! Ben Arda, yazılım dünyasını keşfetmeyi seven bir geliştiriciyim. Bu blogda yazılım, kodlama ve teknolojiyi yakından ilgilendiren konuları paylaşıyorum..<br>
                        <a href="about.html">link eklenebilir</a>
                    </div>
                    <ul class="social-list list-inline py-3 mx-auto">
                        <li class="list-inline-item"><a href="https://www.linkedin.com/in/arda-eren51/"><i class="fab fa-linkedin-in fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="https://github.com/ArdaEren12"><i class="fab fa-github-alt fa-fw"></i></a></li>
                    </ul>
                    <hr> 
                </div>
                
                <ul class="navbar-nav flex-column text-left">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php"><i class="fas fa-home fa-fw mr-2"></i>Anasayfa <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog-post.php"><i class="fas fa-bookmark fa-fw mr-2"></i>Blog Yazısı</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.html"><i class="fas fa-user fa-fw mr-2"></i>Hakkımda</a>
                    </li>
                </ul>
                
                <div class="my-2 my-md-3">
                    <a class="btn btn-primary" href="admin.php">Admin Paneli</a>
                </div>
            </div>
        </nav>
    </header>
    
    <div class="main-wrapper">
        <article class="blog-post px-3 py-5 p-md-5">
            <header class="blog-post-header">
                <h1><?php echo htmlspecialchars($yazi['yazi_baslik']); ?></h1>
                <div class="meta"><?php echo date("d M Y", strtotime($yazi['yazi_tarih'])); ?></div>
            </header>

            <div class="blog-post-body">
                <?php if (!empty($yazi['yazi_resim'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($yazi['yazi_resim']); ?>" alt="Yazı Resmi"  style="height: 400px; width: 100%; object-fit: cover; border-radius: 5px;">
                <?php endif; ?>

                <p><?php echo nl2br(htmlspecialchars($yazi['yazi_aciklama'])); ?></p>
            </div>

            <footer class="blog-post-footer">
                <a href="index.php">← Tüm Yazılara Dön</a>
            </footer>
        </article>

        <div class="sidebar">
            <h3>Diğer Yazılar</h3>
            <?php
            // Veritabanından diğer yazıları çek
            $sorgu = $db->prepare("SELECT * FROM yazilar WHERE yazi_id != ? ORDER BY yazi_tarih DESC LIMIT 15");
            $sorgu->execute([$id]);
            $yazilar = $sorgu->fetchAll(PDO::FETCH_ASSOC);

            foreach ($yazilar as $yazi_item): ?>
                <div class="other-post">
                    <a href="blog-post.php?yazi_id=<?= htmlspecialchars($yazi_item['yazi_id']) ?>">
                        <?php if (!empty($yazi_item['yazi_resim'])): ?>
                            <img src="uploads/<?= htmlspecialchars($yazi_item['yazi_resim']) ?>" alt="<?= htmlspecialchars($yazi_item['yazi_baslik']) ?>">
                        <?php endif; ?>
                        <h5><?= htmlspecialchars($yazi_item['yazi_baslik']) ?></h5>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>