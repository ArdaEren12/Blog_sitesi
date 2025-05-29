<?php
include("ayar.php"); // Veritabanı bağlantısı
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <title>Arda Eren Blog Sayfası</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Blog Template">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">

    <!-- FontAwesome JS (sadece bir tanesini kullan)-->
    <script defer src="https://use.fontawesome.com/releases/v5.7.1/js/all.js" integrity="sha384-eVEQC9zshBn0rFj4+TU78eNA19HMNigMviK/PU/FFjLXqa/GKPgX58rvt5Z8PLs7" crossorigin="anonymous"></script>

    <!-- Theme CSS -->
    <link id="theme-style" rel="stylesheet" href="assets/css/theme-1.css">
  <style>
    a {
      text-decoration: none !important;
    }
  </style>
    <style>
        .main-wrapper {
            background-color: #f9f9f9;
            padding: 2rem 1rem;
            font-family: 'Georgia', serif;
        }

        .container {
            max-width: 750px;
            margin: 0 auto;
        }

        .blog-post {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            margin-bottom: 2rem;
            transition: transform 0.2s ease;
        }

        .blog-post:hover {
            transform: scale(1.01);
        }

        .post-header {
            margin-bottom: 1rem;
        }

        .post-title {
            font-size: 1.8rem;
            color: #222;
            margin-bottom: 0.3rem;
        }

        .post-date {
            font-size: 0.85rem;
            color: #999;
        }

        .post-content p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #333;
        }

        .read-more {
            display: inline-block;
            margin-top: 1rem;
            font-size: 0.95rem;
            color: #007BFF;
            text-decoration: none;
            border-bottom: 1px solid transparent;
            transition: all 0.2s ease-in-out;
        }

        .read-more:hover {
            border-color: #007BFF;
        }

        /* CTA bölümü rengi sadeleştirildi */
        .cta-section.theme-bg-light {
            background-color: #f5f5f5;
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .post-content p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: #333;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            /* maksimum 3 satır */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

      
    </style>

</head>

<body>

    <header class="header text-center bg-info">
        <h1 class="blog-name pt-lg-4 mb-0"><a href="index.html">Arda'nın Blog Sayfası</a></h1>

        <nav class="navbar navbar-expand-lg navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div id="navigation" class="collapse navbar-collapse flex-column">
                <div class="profile-section pt-3 pt-lg-0">
                    <img class="profile-image mb-3 mx-auto" src="assets/images/arda.jpg" alt="image" style="border-radius: 150px; height: 250px;">

                    <div class="bio mb-3">
                        Merhaba! Ben Arda, yazılım dünyasını keşfetmeyi seven bir geliştiriciyim. Bu blogda yazılım, kodlama ve teknolojiyi yakından ilgilendiren konuları paylaşıyorum.
                        <hr>
                    </div>
                    <ul class="navbar-nav flex-column text-left">
                        <li class="nav-item active">
                            <a class="nav-link" href="index.php"><i class="fas fa-home fa-fw mr-2"></i>Anasayfa <span class="sr-only">(current)</span></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link text-decoration-none" href="about.html"><i class="fas fa-user fa-fw mr-2"></i>Hakkımda</a>
                        </li>
                        <div class="my-2 my-md-3 text-decoration-none">
                            <a class="btn btn-primary" href="admin.php">Admin Paneli</a>
                        </div>
                    </ul>
                    <ul class="social-list list-inline py-3 mx-auto">
                        <li class="list-inline-item"><a href="https://www.linkedin.com/in/arda-eren51/"><i class="fab fa-linkedin fa-fw"></i></a></li>
                        <li class="list-inline-item"><a href="https://github.com/ArdaEren12"><i class="fab fa-github fa-fw"></i></a></li>
                    </ul>
                    <hr>
                </div>
            </div>
        </nav>
    </header>

    <div class="main-wrapper text-decoration-none">
        <section class="cta-section theme-bg-light text-decoration-none">
            <div class="container text-decoration-none">

                <?php


                $dataList = $db->prepare("SELECT * FROM yazilar ORDER BY yazi_id DESC");
                $dataList->execute();
                $rows = $dataList->fetchAll(PDO::FETCH_ASSOC);

                foreach ($rows as $row) {
                    $baslik = isset($row["yazi_baslik"]) ? htmlspecialchars($row["yazi_baslik"]) : "Başlık yok";
                    $icerik = isset($row["yazi_aciklama"]) ? nl2br(htmlspecialchars($row["yazi_aciklama"])) : "İçerik yok";
                    $tarih = isset($row["yazi_tarih"]) ? htmlspecialchars($row["yazi_tarih"]) : "Tarih yok";

                    echo '<div class="blog-post">
                    <div class="post-header">
                        <h2 class="post-title">' . $baslik . '</h2>
                        <small class="post-date">' . $tarih . '</small>
                    </div>
                    <div class="post-content">
                        <p>' . $icerik . '</p>
                    </div>
                    <a href="blog-post.php?yazi_id=' . $row['yazi_id'] . '" class="read-more">Devamını Oku...</a>
                </div>';
                }
                ?>

            </div>
        </section>
    </div>

    <!-- JS -->
    <script src="assets/plugins/jquery-3.3.1.min.js"></script>
    <script src="assets/plugins/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>