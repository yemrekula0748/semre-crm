


<!DOCTYPE html>
<html lang="tr">
    <head>

        <meta charset="utf-8" />
        <title>Anasayfa CRM | Satış Panel</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc."/>
        <meta name="author" content="Zoyothemes"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Icons -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- SemreCRM Shared Theme -->
    <link href="assets/css/semrecrm.css" rel="stylesheet" type="text/css" />

    </head>

    <!-- body start -->
    <body data-menu-color="light" data-sidebar="default"

        <!-- Begin page -->
        <div id="app-layout">


<?php
include 'tema/menu.php';
include 'fonksiyon.php';
$unprocessedOrderCount = getUnprocessedOrderCount($db);

?>
            

            <!-- ============================================================== -->
            <!-- BOŞ SAYFA BAŞLANGIÇ -->
            <!-- ============================================================== -->
         
   
            <div class="content-page">
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- Page Header -->
                        <div class="crm-page-header">
                            <div class="crm-header-left">
                                <h1>Dashboard</h1>
                                <p>Sipariş paneli genel istatistikleri</p>
                            </div>
                            <div class="crm-header-right">
                                <button id="clearOrders" class="btn btn-danger" style="display:inline-flex;align-items:center;gap:6px;">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    Siparişleri Boşalt ve Yedekle
                                </button>
                            </div>
                        </div>

                        <!-- Stat Cards -->
                        <div class="crm-stats-grid">

                            <div class="crm-stat-card">
                                <div class="stat-icon icon-indigo">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M12 4a4 4 0 0 1 4 4a4 4 0 0 1-4 4a4 4 0 0 1-4-4a4 4 0 0 1 4-4m0 10c4.42 0 8 1.79 8 4v2H4v-2c0-2.21 3.58-4 8-4"/></svg>
                                </div>
                                <div class="stat-body">
                                    <div class="stat-value"><?php echo getAllUnprocessedOrderCount($db); ?></div>
                                    <div class="stat-label">Girilen Sipariş</div>
                                    <div class="stat-sublabel">Boşaltılmayan siparişler</div>
                                </div>
                            </div>

                            <div class="crm-stat-card">
                                <div class="stat-icon icon-sky">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 640 512" fill="#fff"><path d="M96 224c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m448 0c35.3 0 64-28.7 64-64s-28.7-64-64-64s-64 28.7-64 64s28.7 64 64 64m32 32h-64c-17.6 0-33.5 7.1-45.1 18.6c40.3 22.1 68.9 62 75.1 109.4h66c17.7 0 32-14.3 32-32v-32c0-35.3-28.7-64-64-64m-256 0c61.9 0 112-50.1 112-112S381.9 32 320 32S208 82.1 208 144s50.1 112 112 112m76.8 32h-8.3c-20.8 10-43.9 16-68.5 16s-47.6-6-68.5-16h-8.3C179.6 288 128 339.6 128 403.2V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-28.8c0-63.6-51.6-115.2-115.2-115.2m-223.7-13.4C161.5 263.1 145.6 256 128 256H64c-35.3 0-64 28.7-64 64v32c0 17.7 14.3 32 32 32h65.9c6.3-47.4 34.9-87.3 75.2-109.4"/></svg>
                                </div>
                                <div class="stat-body">
                                    <div class="stat-value"><?php echo getBuAykiSiparisCount(); ?></div>
                                    <div class="stat-label">Bu Ayki Sipariş</div>
                                    <div class="stat-sublabel">Aylık toplam</div>
                                </div>
                            </div>

                            <div class="crm-stat-card">
                                <div class="stat-icon icon-emerald">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M7 15h2c0 1.08 1.37 2 3 2s3-.92 3-2c0-1.1-1.04-1.5-3.24-2.03C9.64 12.44 7 11.78 7 9c0-1.79 1.47-3.31 3.5-3.82V3h3v2.18C15.53 5.69 17 7.21 17 9h-2c0-1.08-1.37-2-3-2s-3 .92-3 2c0 1.1 1.04 1.5 3.24 2.03C14.36 11.56 17 12.22 17 15c0 1.79-1.47 3.31-3.5 3.82V21h-3v-2.18C8.47 18.31 7 16.79 7 15"/></svg>
                                </div>
                                <div class="stat-body">
                                    <div class="stat-value"><?php echo getOfficialOrderCount($db); ?> <span style="font-size:1rem;font-weight:600">adet</span></div>
                                    <div class="stat-label">Resmileşen</div>
                                    <div class="stat-sublabel">Fatura emri verilen</div>
                                </div>
                            </div>

                            <div class="crm-stat-card">
                                <div class="stat-icon icon-amber">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M5.574 4.691c-.833.692-1.052 1.862-1.491 4.203l-.75 4c-.617 3.292-.926 4.938-.026 6.022C4.207 20 5.88 20 9.23 20h5.54c3.35 0 5.025 0 5.924-1.084c.9-1.084.591-2.73-.026-6.022l-.75-4c-.439-2.34-.658-3.511-1.491-4.203C17.593 4 16.403 4 14.02 4H9.98c-2.382 0-3.572 0-4.406.691"/></svg>
                                </div>
                                <div class="stat-body">
                                    <div class="stat-value"><?php echo getUnofficialOrderCount($db); ?></div>
                                    <div class="stat-label">Resmileşmeyen</div>
                                    <div class="stat-sublabel">Bekleyen siparişler</div>
                                </div>
                            </div>

                            <div class="crm-stat-card">
                                <div class="stat-icon icon-violet">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><path d="M5 19L19 5"/><circle cx="7" cy="7" r="3"/><circle cx="17" cy="17" r="3"/></svg>
                                </div>
                                <div class="stat-body">
                                    <div class="stat-value"><?php echo getUnprocessedOrderCount($db); ?> <span style="font-size:1rem;font-weight:600">adet</span></div>
                                    <div class="stat-label">İkas Siparişleri</div>
                                    <div class="stat-sublabel">iKas sipariş sayısı</div>
                                </div>
                            </div>

                            <div class="crm-stat-card">
                                <div class="stat-icon icon-slate">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"><path d="M19 9H6.659c-1.006 0-1.51 0-1.634-.309c-.125-.308.23-.672.941-1.398L8.211 5M5 15h12.341c1.006 0 1.51 0 1.634.309c.125.308-.23.672-.941 1.398L15.789 19"/></svg>
                                </div>
                                <div class="stat-body">
                                    <div class="stat-value"><?php echo bekleyenKargoSayisi(); ?> <span style="font-size:1rem;font-weight:600">adet</span></div>
                                    <div class="stat-label">Kalan PTT Barkod</div>
                                    <div class="stat-sublabel">Toplam kalan KP kodları</div>
                                </div>
                            </div>

                        </div>

                    </div> <!-- container-fluid -->
                </div> <!-- content -->

           <?php include 'tema/footer.php'; ?>

            </div>
            <!-- ============================================================== -->
            <!-- BOŞ SAYFA BİTİŞ -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->

        <!-- Vendor -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>

        <!-- App js-->
        <script src="assets/js/app.js"></script>
		 <!-- Apexcharts JS -->
        <!-- for basic area chart -->
  

        <!-- Widgets Init Js -->
        <script src="assets/js/pages/crm-dashboard.init.js"></script>
        <!-- Apexcharts JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="assets/js/pages/dashboard.init.js"></script>

        <script>
            document.getElementById('clearOrders').addEventListener('click', function () {
                Swal.fire({
                    title: 'Şifre Girin',
                    input: 'password',
                    inputLabel: 'Lütfen işlemi tamamlamak için şifrenizi girin',
                    inputPlaceholder: 'Şifre',
                    showCancelButton: true,
                    confirmButtonText: 'Devam Et',
                    cancelButtonText: 'İptal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (result.value === "130519") {
                            // Şifre doğruysa işlemi başlat
                            $.post('bosalt_yedekle.php', function (response) {
                                Swal.fire({
                                    title: response.status === "success" ? "Başarılı" : "Hata",
                                    text: response.message,
                                    icon: response.status === "success" ? "success" : "error"
                                }).then(() => {
                                    if (response.status === "success") {
                                        location.reload(); // Sayfayı yeniden yükle
                                    }
                                });
                            }, "json");
                        } else {
                            Swal.fire({
                                title: 'Hatalı Şifre',
                                text: 'Girdiğiniz şifre yanlış. Lütfen tekrar deneyin.',
                                icon: 'error'
                            });
                        }
                    }
                });
            });
        </script>

        
 


        
    </body>
</html>