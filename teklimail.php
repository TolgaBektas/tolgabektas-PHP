<?php
$title = 'Tolga Bektaş | Tekli Mail';
$simdikiSayfa = 'Tekli Mail';
require_once 'header.php'; ?>
<?php
ini_set("display_errors", 1);

if (isset($_POST['mailgonder'])) {

    $kime = $_POST['kime'];
    $konu=isset($_POST['konu']) ? $_POST['konu'] : null;
    $icerik = $_POST['icerik'];
    $ek=isset($_FILES['ek']) ? $_FILES['ek'] : null;
    
   $sonuc=$db->teklimail('mailtoplu00@gmail.com','Tolga Bektaş','','mailtoplu00@gmail.com','Tolga Bektaş',$kime,$konu,$icerik,$ek);
}

?>



<div class="col-md-12">
    <?php
    if (isset($sonuc)) {
        if ($sonuc['status']==true) { ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Başarılı!</h5>
                Mail gönderim başarıyla gerçekleşti.
            </div>
        <?php } else if ($sonuc['status']==false) { ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-check"></i> Başarısız!</h5>
                Mail gönderim başarısız oldu. <?php echo $sonuc['error']; ?>
            </div>
    <?php }
    }
    ?>
    <div class="card card-primary card-outline">
        <form method="POST" enctype="multipart/form-data">
            <div class="card-header">
                <h3 class="card-title">Yeni Mail</h3>
            </div>
            <div class="card-body">

                <div class="form-group">
                    <input type="email" class="form-control" name="kime" required placeholder="Kime:" autocomplete="off">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="konu" placeholder="Konu:" autocomplete="off">
                </div>
                <div class="form-group">
                    <textarea id="compose-textarea" class="form-control" name="icerik" required></textarea>
                </div>
                <div class="form-group">
                    <div class="btn btn-default btn-file">
                        <i class="fas fa-paperclip"></i> Ek
                        <input type="file" name="ek">
                    </div>
                    <p class="help-block">Max. 25MB</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="submit" class="btn btn-primary" name="mailgonder"><i class="far fa-envelope"></i> Gönder</button>
                </div>
            </div>
        </form>
    </div>

</div>

<?php include_once 'footer.php' ?>