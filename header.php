<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'netting/class.crud.php';
$db = new crud();
require_once 'setconfig.php';

///LOG KAYDI TUTMA START
$ip = $db->ipSehir($_SERVER['REMOTE_ADDR']);
$ulke = $ip['ulke'];
$sehir = $ip['sehir'];
$zip = $ip['postaKodu'];
$sql = $db->insert(
  "logs",
  [
    'logs_ip' => $_SERVER['REMOTE_ADDR'],
    'logs_sayfa' => $simdikiSayfa,
    'logs_ulke' => $ulke,
    'logs_sehir' => $sehir,
    'logs_postaKodu' => $zip
  ]
);


$today = date('Y-m');
$sql = $db->qSql("SELECT DISTINCT logs_ip from logs WHERE logs_time LIKE '$today%'");
$toplam_ziyaretci = 0;
while ($row = $sql['stmt']->fetch(PDO::FETCH_ASSOC)) {
  $toplam_ziyaretci++;
}
///LOG KAYDI TUTMA END

//google analytics verilerini çekme işlemi

//require_once __DIR__.'/vendor/autoload.php';
//$client=new Google_Client();
//$client->setAuthConfig('original-storm-240013-4219f9197cf8.json');
//$client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
//$analytics=new Google_Service_Analytics($client);
//$viewId=188653171;//analytics'ten gelen id

//$result=$analytics->data_ga->get(
//  'ga:'.$viewId,
//  '30daysAgo',//başlangıç günü
//  'today',//bitiş günü
//  'ga:sessions,ga:pageviews',
//  [
//   'dimensions'=>'ga:date'
//  ]
//);
//echo "<pre>";
//print_r($result['rows']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $title; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- FOR CROP IMG -->

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- CodeMirror -->
  <link rel="stylesheet" href="plugins/codemirror/codemirror.css">
  <link rel="stylesheet" href="plugins/codemirror/theme/monokai.css">



  <script src="plugins/jquery/jquery.min.js"></script>
  <script src="plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="plugins/croppie/croppie.js"></script>
  <link rel="stylesheet" href="plugins/croppie/croppie.css" />

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- NAVBAR START -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- NAVBAR Sol Taraf START -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-sm-inline-block">
          <a href="index" class="nav-link">Anasayfa</a>
        </li>
      </ul>
      <!-- NAVBAR Sol Taraf END -->



      <!-- NAVBAR Sag Taraf START -->
      <ul class="navbar-nav ml-auto">
        <!-- Bildirim Menu START -- >
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header">15 Bildirim</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
          </div>
        </li>
        <!-- Bildirim Menu END -->

        <!-- Cikis Yap START -->
        <li class="nav-item d-none d-sm-inline-block">
          <a href="logout" class="nav-link">Güvenli Çıkış</a>
        </li>
        <!-- Cikis Yap START -->
      </ul>
      <!-- NAVBAR Sag Taraf END -->

    </nav>
    <!-- NAVBAR END -->

    <!-- SIDEBAR START -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- LOGO START -->
      <a href="index" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Paneli</span>
      </a>
      <!-- LOGO END -->


      <div class="sidebar">
        <!-- SIDEBAR kullanici adi START -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="info">
            <h5 class="m-0 text-light">Hoşgeldin, <?php echo $_SESSION['admins']['admins_namelastname']; ?></h5>
          </div>
        </div>
        <!--SIDEBAR kullanici adi END -->
        <!-- SIDEBAR MENULER START -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
              <a href="index" class="nav-link">
                <i class="fas fa-home"></i>
                <p>Anasayfa</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="haberler" class="nav-link">
                <i class="far fa-newspaper"></i>
                <p>Haberler</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="site-ayarlari" class="nav-link">
                <i class="fas fa-cog"></i>
                <p>Site Ayarları</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="fas fa-sign-in-alt"></i>
                <p>
                  Loglar
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="display: none;">
                <li class="nav-item">
                  <a href="logs" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tüm Girişler</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="logs-single-date" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Tek Tarih Sorgulama</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="logs-couple-date" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>İki Tarih Arası Sorgulama</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="keyword" class="nav-link">
                <i class="fas fa-file-word"></i>
                <p>Keyword Bulucu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pdf" class="nav-link">
                <i class="fas fa-file-pdf"></i>
                <p>Pdf Oluşturucu</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="teklimail" class="nav-link">
                <i class="fas fa-envelope"></i>
                <p>Tekli Mail Gönderimi</p>
              </a>
            </li>
           
          </ul>
        </nav>
        <!-- SIDEBAR MENULER END -->
      </div>

    </aside>
    <!-- SIDEBAR END -->

    <!-- ANASAYFA START-->
    <div class="content-wrapper">
      <!-- ANASAYFA BASLIK START -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index">Anasayfa</a></li>
                <li class="breadcrumb-item active"><?php echo $simdikiSayfa; ?></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!-- ANASAYFA BASLIK END -->
      <div class="content">
        <div class="container-fluid">