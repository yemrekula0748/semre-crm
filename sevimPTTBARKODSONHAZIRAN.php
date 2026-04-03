<?php

$bedelsizUrl = "https://semrepanel.com.tr/sevimaydinpttbedelsizodeme.php";
$sartliUrl   = "https://semrepanel.com.tr/sevimaydinpttsartliodeme.php";

for ($i = 0; $i < 20; $i++) {
    // Bedelsiz Ödeme URL'sine istek gönder
    file_get_contents($bedelsizUrl);
    sleep(1); // 1 saniye bekle

    // Şartlı Ödeme URL'sine istek gönder
    file_get_contents($sartliUrl);
    sleep(1); // 1 saniye bekle
}

?>
