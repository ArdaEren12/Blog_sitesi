<?php
include("ayar.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Veritabanında bu ID'ye sahip kayıt var mı kontrol et (opsiyonel ama güvenli)
    $sorgu = $db->prepare("SELECT * FROM yazilar WHERE yazi_id = ?");
    $sorgu->execute([$id]);
    $yazi = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($yazi) {
        // Yazı varsa sil
        $sil = $db->prepare("DELETE FROM yazilar WHERE yazi_id = ?");
        $sil->execute([$id]);

        // Başarıyla silindiğinde admin paneline yönlendir
        header("Location: admin.php?durum=silindi");
        exit;
    } else {
        // Yazı bulunamadıysa hata
        header("Location: admin.php?durum=bulunamadi");
        exit;
    }
} else {
    // ID gelmediyse yönlendir
    header("Location: admin.php?durum=gecersiz");
    exit;
}
?>
