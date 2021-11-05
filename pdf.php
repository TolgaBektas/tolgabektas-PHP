<?php
$title = 'Tolga Bektaş | Pdf Oluşturucu';
$simdikiSayfa = 'Pdf Oluşturucu';

//pdf maker

if (isset($_POST['fatura_olustur'])) {


  $fatura_numarasi = $_POST['fatura_numarasi'];
  $musteri_ad = $_POST['musteri_ad'];
  $musteri_soyad = $_POST['musteri_soyad'];
  $musteri_mail = $_POST['musteri_mail'];
  $odeme_tipi = $_POST['odeme_tipi'];
  $urun_aciklama = $_POST['urun_aciklama'];
  $urun_adet = $_POST['urun_adet'];
  $urun_adet_fiyat = $_POST['urun_adet_fiyat'];
  $toplam = $urun_adet * $urun_adet_fiyat;
  $fatura = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
  <html>
  
  <head>
      <title>Fatura: '.$fatura_numarasi.'</title>
      <style type="text/css">
          <!--
          body {
              font-family: Tahoma;
          }
  
          img {
              border: 0;
          }
  
          #page {
              width: 800px;
              margin: 0 auto;
              padding: 15px;
  
          }
  
          #logo {
              float: left;
              margin: 0;
          }
  
          #address {
              height: 181px;
              margin-left: 250px;
          }
  
          table {
              width: 100%;
          }
  
          td {
              padding: 5px;
          }
  
          tr.odd {
              background: #e1ffe1;
          }
          -->
      </style>
  </head>
  
  <body>
      <div id="page">
          <div id="logo">
              <a href="http://www.danifer.com/"><img src="http://www.danifer.com/images/invoice_logo.jpg"></a>
          </div>
          <div id="address">
              <p>Tolga Bektaş<br>
                  <a href="tolgabektas00@gmail.com">tolgabektas00@gmail.com</a>
                  <br><br>
                  Fatura Numarası:' . $fatura_numarasi . ' <br>
                  Oluşturulma Tarihi:' . date("d.m.Y") . ' <br>
              </p>
          </div>
          <div id="content">
              <p>
                  <strong>Müşteri Detayları</strong><br>
                  İsim:' . $musteri_ad . ' <br>
                  Soyisim: ' . $musteri_soyad . ' <br>
                  Mail: ' . $musteri_mail . ' <br>
                  Ödeme Tipi: ' . $odeme_tipi . '
              </p>
              <hr>
              <table>
                  <tr>
                      <td><strong>Açıklama</strong></td>
                      <td><strong>Adet</strong></td>
                      <td><strong>Adet Fiyatı</strong></td>
                      <td><strong>Toplam</strong></td>
                  </tr>
                  <tr class="odd">
                      <td>' . $urun_aciklama . '</td>
                      <td>' . $urun_adet . ' </td>
                      <td>' . $urun_adet_fiyat . '</td>
                      <td>' . $toplam . '</td>
                  </tr>              
                  <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td><strong>Toplam Tutar</strong></td>
                      <td><strong>' . $toplam . '</strong></td>
                  </tr>
              </table>
              <hr>
              <p>
                  Thank you for your order! This transaction will appear on your billing statement as "Your
                  Company".<br>
                  If you have any questions, please feel free to contact us at <a href="mailto:tolgabektas00@gmail.com">tolgabektas00@gmail.com</a>.
              </p>
              <hr>
              <p>
                  <center><small>This communication is for the exclusive use of the addressee and may contain proprietary,
                          confidential or privileged information. If you are not the intended recipient any use, copying,
                          disclosure, dissemination or distribution is strictly prohibited.
                          <br><br>
                          &copy; Tolga Bektaş All Rights Reserved
                      </small></center>
              </p>
          </div>
      </div>
  </body>
  </html>';

  require_once 'plugins/vendor/autoload.php';
  try {
    $mpdf = new \Mpdf\Mpdf(['debug' => true]);
    $mpdf->WriteHTML($fatura);
    $mpdf->Output('Fatura '.$fatura_numarasi.'.pdf', 'I');
  } catch (Exception $e) {
    echo $e->getMessage();
  }
}
require_once 'header.php';
?>

<div class="card">
  <div class="card-header">
    <div class="row">
      <div class="col-md-12">
        <h1 class="card-title">Fatura Oluşturma</h1>
        <div class="card-tools float-right">
          <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <form method="post" target="_blank">
    <div class="card-body">
      <div class="form-group row">
        <div class="form-group col-md-12">
          <label for="adsoyad">Fatura Numarası</label>
          <input type="text" class="form-control" id="adsoyad" name="fatura_numarasi" required="">
        </div>
        <div class="form-group col-md-6">
          <label for="adsoyad">Müşteri Adı</label>
          <input type="text" class="form-control" id="adsoyad" name="musteri_ad" required="">
        </div>
        <div class="form-group col-md-6">
          <label for="adsoyad">Müşteri Soyadı</label>
          <input type="text" class="form-control" id="adsoyad" name="musteri_soyad" required="">
        </div>
        <div class="form-group col-md-6">
          <label for="adsoyad">Müşteri Maili</label>
          <input type="mail" class="form-control" id="adsoyad" name="musteri_mail" required="">
        </div>
        <div class="form-group col-md-6">
          <label for="kullaniciadi">Ödeme Tipi</label>
          <select class="form-control" name="odeme_tipi">
            <option value="Kredi Kartı">Kredi Kartı</option>
            <option value="Havale">Havale</option>
            <option value="EFT">EFT</option>
          </select>
        </div>
        <div class="form-group col-md-12">
          <label for="adsoyad">Ürün Açıklaması</label>
          <input type="mail" class="form-control" id="adsoyad" name="urun_aciklama" required="">
        </div>
        <div class="form-group col-md-6">
          <label for="adsoyad">Ürün Adeti</label>
          <input type="number" min="1" class="form-control" id="adsoyad" name="urun_adet" required="">
        </div>
        <div class="form-group col-md-6">
          <label for="adsoyad">Ürün Adet Fiyatı</label>
          <input type="number" min="1" class="form-control" id="adsoyad" name="urun_adet_fiyat" required="">
        </div>

      </div>
    </div>
    <div class="card-footer">

      <button type="submit" class="btn bg-gradient-success float-right" name="fatura_olustur">Fatura Oluştur</button>
    </div>
  </form>
</div>


<?php require_once 'footer.php' ?>