<?php
$title = 'Tolga Bektaş | Seo';
$simdikiSayfa = 'Seo';
require_once 'header.php'; ?>

<?php
if (isset($_POST['keybul'])) {
    $icerik = isset($_POST['icerik']) ? $_POST['icerik'] : null;
    $icerik = htmlspecialchars($icerik);
    if ($icerik == null) {
        echo "boşluk bırakmayınız!";
    } else {
        $dizi = str_replace(',', '', $icerik); //yazıda ki virgülleri çıkardık
        $dizi = str_replace('.', '', $dizi); //yazıdaki noktaları çıkardık
        $dizi = str_replace('"', '', $dizi); //yazıdaki tırnak işaretlerini çıkardık
        $dizi = str_replace('“', '', $dizi); //yazıdaki “ işaretlerini çıkardık
        $dizi = strtolower($dizi); //yazıyı küçük harflere getirdik

        $dizi = array_count_values(explode(' ', $dizi));
        arsort($dizi);
        $yeniDizi = array();
        foreach ($dizi as $key => $value) {
            if (empty($key)) {
                continue;
            }
            $yeniDizi[] = array($value, $key);
        }
    }
}

?>


<div class="card card-primary card-outline">
    <div class="row">
        <div class="col-md-10">
            <form method="POST">
                <div class="card-header">
                    <h3 class="card-title">Keyword Bulucu</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control" name="icerik" rows="25"><?php echo isset($_POST['icerik']) ? $_POST['icerik'] : null; ?></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary" name="keybul">Kelime Bul</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-2">
            <div class="card-header">
                <h3 class="card-title">Bulunan Kelimeler</h3>
            </div>
            <div class="form-group">
                <div class="card-body">
                    <ul class="nav flex-column">
                        <?php
                        foreach ($yeniDizi as $value) { ?>
                            <?php if ($value['0'] >= 2) { ?>
                                <li class="nav-item"><?php echo $value['1']; ?>
                                    <span class="float-right badge bg-primary"><?php echo $value['0']; ?></span>
                                </li>
                        <?php
                            }
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>