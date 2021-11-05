<?php
$title='Tolga Bektaş | Haberler';
$simdikiSayfa='Haberler';
require_once 'header.php'; ?>
<!-- TEKLI HABER RESMI SILME START -->
<?php if (isset($_GET['haberImgDelete'])) {
	//THUMNAIL 1 SILME START
	if ($_GET['haberImgDelete']=="th1") {
		$id=$_GET['haber_id'];
		$dosya=$_GET['haber_resim1_th'];
		$sonuc=$db->qSql("UPDATE haberler SET haber_resim1_th=''  WHERE haber_id=$id");
		unlink($dosya);
		if ($sonuc['status']) {?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
				<?php echo $id; ?>. id'ye ait thumbnail 1 silindi.
			</div>
		<?php }else{ ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
				<?php echo $id; ?>. id'ye ait thumbnail 1 silinemedi. <?php echo $sonuc['error']; ?>
			</div>
		<?php }
		//THUMNAIL 1 SILME END

		//HABER RESIM 2 SILME START
	}else if ($_GET['haberImgDelete']=="hr2") {
		$id=$_GET['haber_id'];
		$dosya=$_GET['haber_resim2'];
		$sonuc=$db->qSql("UPDATE haberler SET haber_resim2=''  WHERE haber_id=$id");
		unlink($dosya);
		
		if ($sonuc['status']) {?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
				<?php echo $id; ?>. id'ye ait resim 2 silindi.
			</div>
		<?php }else{ ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
				<?php echo $id; ?>. id'ye ait resim 2 silinemedi. <?php echo $sonuc['error']; ?>
			</div>
		<?php }
		//HABER RESIM 2 SILME END

		//THUMBNAIL 2 SILME START
	}else if ($_GET['haberImgDelete']=="th2") {
		$id=$_GET['haber_id'];
		$dosya=$_GET['haber_resim2_th'];
		$sonuc=$db->qSql("UPDATE haberler SET haber_resim2_th=''  WHERE haber_id=$id");
		unlink($dosya);
		
		if ($sonuc['status']) {?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
				<?php echo $id; ?>. id'ye ait thumbnail 2 silindi.
			</div>
		<?php }else{ ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
				<?php echo $id; ?>. id'ye ait thumbnail 2 silinemedi. <?php echo $sonuc['error']; ?>
			</div>
		<?php }
		//THUMBNAIL 2 SILME END
	}
} ?>
<!-- TEKLI HABER RESMI SILME END -->
<!-- YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC--- -->
<!-- HABER EKLEME START -->
<?php if (isset($_GET['haberInsert'])) {
	if ($_GET['haberInsert']=="true") { 
		if (isset($_POST['haber_insert'])) {
			$sonuc=$db->insert("haberler",$_POST,[
				"form_name"=>"haber_insert",
				"dir"=>'dist/images/haberler',
				"file_name1"=>"haber_resim1",
				"file_name2"=>"haber_resim2",
				"file_name1_th"=>"haber_resim1_th",
				"file_name2_th"=>"haber_resim2_th",
				"slug"=>"haber_link",
				"title"=>"haber_baslik"
			]);
			if ($sonuc['status']) { ?>
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
					Haber ekleme başarılı bir şekilde gerçekleşti.
				</div>
			<?php }else{ ?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
					Haber ekleme başarısız oldu. <?php echo $sonuc['error']; ?>
				</div>
			<?php }
		}
		?>
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-12">
						<h1 class="card-title">Haber Ekleme</h1>
						<div class="card-tools float-right">							
							<button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>			
				</div>
			</div>
			<div class="card-body">
				<form method="post" enctype="multipart/form-data">
					<div class="card-body row">
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Resim 1</label>
							<input type="file" class="form-control" id="adsoyad" required="" name="haber_resim1">
							<small>* Maks boyut : 1 MB</small>
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Resim 2</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim2">
							<small>* Maks boyut : 1 MB</small>
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Resim 1 Thumbnail</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim1_th">
							<small>* İçerik haricinde görüntülenecek resim. Sitenin hızlı yüklenebilmesi için olabilecek en ufak boyutta olması gerekmektedir.</small><br>
							<small>* Maks boyut : 0,3 MB</small>
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Resim 2 Thumbnail</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim2_th">
							<small>* İçerik haricinde görüntülenecek resim. Sitenin hızlı yüklenebilmesi için olabilecek en ufak boyutta olması gerekmektedir.</small><br>
							<small>* Maks boyut : 0,3 MB</small>
						</div>		
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Başlık</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Haber Başlığı" name="haber_baslik">
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Tarihi</label>
							<input type="date" class="form-control" id="adsoyad" required="" placeholder="Haber Tarihi" name="haber_zaman">
						</div>
						<div class="form-group col-md-12">
							<label for="adsoyad">Haber İçerik</label>
							<textarea id="summernote" name="haber_icerik" required="" class="form-control"></textarea>
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Description</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Haber Description" name="haber_description">
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Keywords</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Haber Keywords" name="haber_keywords">
						</div>
						
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Slug Link</label>
							<input type="text" class="form-control" id="adsoyad" placeholder="Haber Linki" name="haber_link">
							<small>* Bu alan boş bırakılırsa link başlık neyse o olacaktır.</small>
						</div>
						<div class="form-group col-md-6">
							<label for="kullaniciadi">Haber Durum</label>
							<select class="form-control" name="haber_durum">
								<option value="1">Aktif</option>
								<option value="0">Pasif</option>

							</select>
						</div>
					</div>
					<div class="card-footer">
						<button type="submit" class="btn bg-gradient-success float-right" name="haber_insert">Ekle</button>
					</div>
				</form>
			</div>
		</div>
	<?php }
} ?>
<!-- HABER EKLEME END -->
<!-- YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC--- -->
<!-- HABER GUNCELLEME START -->
<?php
if (isset($_GET['haberUpdate'])) {
	if ($_GET['haberUpdate']=="true") {
		if (isset($_POST['haber_update'])) {			
			$sonuc=$db->update('haberler',$_POST,[
				"form_name"=>"haber_update",
				"columns"=>"haber_id",
				"file_name1"=>"haber_resim1",
				"file_name2"=>"haber_resim2",
				"file_name1_th"=>"haber_resim1_th",
				"file_name2_th"=>"haber_resim2_th",
				"dir"=>"dist/images/haberler",
				"delete_file1"=>"delete_file1",
				"delete_file2"=>"delete_file2",
				"delete_file1_th"=>"delete_file1_th",
				"delete_file2_th"=>"delete_file2_th",
				"slug"=>"haber_link",
				"title"=>"haber_baslik"
			]);			
			if ($sonuc['status']) {?>
				<div class="alert alert-success alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
					Haber güncelleme başarılı bir şekilde gerçekleşti.
				</div>
			<?php }else{ ?>
				<div class="alert alert-danger alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
					Haber güncelleme başarısız oldu. <?php echo $sonuc['error']; ?>
				</div>
			<?php }
		}
		
		$sql=$db->wread("haberler","haber_id",$_GET['haber_id']);
		$row=$sql->fetch(PDO::FETCH_ASSOC);
		?>
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-12">
						<h1 class="card-title">Haber Güncelleme</h1>
						<div class="card-tools float-right">							
							<button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
								<i class="fas fa-times"></i>
							</button>
						</div>
					</div>			
				</div>
			</div>
			
			<form method="post" enctype="multipart/form-data">
				<div class="card-body">
					<div class="card-group">
						<div class="card">
							<img width="200" src="<?php echo $row['haber_resim1'];?>">
							<div class="card-body">
								<h5 class="card-title">Yüklü resim 1</h5>										
							</div>
						</div>
						<?php if (!empty($row["haber_resim1_th"])): ?>									
							<div class="card">
								<img width="200" src="<?php echo $row['haber_resim1_th'];?>">
								<div class="card-body">
									<h5 class="card-title">Yüklü resim 1 Thumbnail</h5>
									<p class="card-text"><a href="?haberImgDelete=th1&haber_id=<?php echo $row['haber_id'] ?>&haber_resim1_th=<?php echo $row['haber_resim1_th'] ?>" class="btn  bg-gradient-danger"><i class="fas fa-trash"></i></a></p>
								</div>
							</div>
						<?php endif ?>
						<?php if (!empty($row["haber_resim2"])): ?>
							<div class="card">
								<img width="200" src="<?php echo $row['haber_resim2'];?>">
								<div class="card-body">
									<h5 class="card-title">Yüklü resim 2</h5>
									<p class="card-text"><a href="?haberImgDelete=hr2&haber_id=<?php echo $row['haber_id'] ?>&haber_resim2=<?php echo $row['haber_resim2'] ?>" class="btn  bg-gradient-danger"><i class="fas fa-trash"></i></a></p>
								</div>
							</div>
						<?php endif ?>
						<?php if (!empty($row["haber_resim2_th"])): ?>
							<div class="card">
								<img width="200" src="<?php echo $row['haber_resim2_th'];?>">
								<div class="card-body">
									<h5 class="card-title">Yüklü resim 2 Thumbnail</h5>
									<p class="card-text"><a href="?haberImgDelete=th2&haber_id=<?php echo $row['haber_id'] ?>&haber_resim2_th=<?php echo $row['haber_resim2_th'] ?>" class="btn  bg-gradient-danger"><i class="fas fa-trash"></i></a></p>
								</div>
							</div>
						<?php endif ?>
					</div>
				</div>
				<div class="card-body">
					<div class="form-group row">
						<div class="form-group col-md-6">
							<label for="adsoyad">Yeni Resim 1</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim1">
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Yeni Resim 1 Thumbnail</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim1_th">
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Yeni Resim 2</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim2">
						</div>						
						<div class="form-group col-md-6">
							<label for="adsoyad">Yeni Resim 2 Thumbnail</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim2_th">
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Başlık</label>
							<input type="text" class="form-control" id="adsoyad" name="haber_baslik" required="" value="<?php echo $row['haber_baslik']; ?>">
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Tarihi</label>
							<input type="date" class="form-control" id="adsoyad" required="" placeholder="Haber Tarihi" name="haber_zaman" value="<?php echo $row['haber_zaman'] ?>">
						</div>
						<div class="form-group col-md-12">
							<label for="adsoyad">Haber İçerik</label>
							<textarea id="summernote" name="haber_icerik" required="" class="form-control"><?php echo $row['haber_icerik']; ?></textarea>
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Description</label>
							<input type="text" class="form-control" id="adsoyad" required="" name="haber_description" value="<?php echo $row['haber_description']; ?>">
						</div>
						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Keywords</label>
							<input type="text" class="form-control" id="adsoyad" required="" name="haber_keywords" value="<?php echo $row['haber_keywords']; ?>">
						</div>

						<div class="form-group col-md-6">
							<label for="adsoyad">Haber Slug Link</label>
							<input type="text" class="form-control" id="adsoyad" name="haber_link" value="<?php echo $row['haber_link']; ?>">
							<small>* Bu alan boş bırakılırsa link başlık neyse o olacaktır.</small>
						</div>

						<div class="form-group col-md-6">
							<label for="kullaniciadi">Haber Durum</label>
							<select class="form-control" name="haber_durum">

								<option <?php if ($row['haber_durum']==1) { echo "selected"; } ?> value="1">Aktif</option>

								<option <?php if ($row['haber_durum']==0) { echo "selected"; } ?> value="0">Pasif</option>
							</select>
						</div>
					</div>
				</div>
				<div class="card-footer">

					<input type="hidden" name="haber_id" value="<?php echo $row['haber_id']; ?>">
					<input type="hidden" name="delete_file1" value="<?php echo $row['haber_resim1']; ?>">
					<input type="hidden" name="delete_file2" value="<?php echo $row['haber_resim2']; ?>">
					<input type="hidden" name="delete_file1_th" value="<?php echo $row['haber_resim1_th']; ?>">
					<input type="hidden" name="delete_file2_th" value="<?php echo $row['haber_resim2_th']; ?>">

					<button type="submit" class="btn bg-gradient-success float-right" name="haber_update">Güncelle</button>
				</div>
			</form>
		</div>

		<?php 
	}
} ?>
<!-- HABER GUNCELLEME END -->
<!-- YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC--- -->
<!-- HABER SILME START -->
<?php
if (isset($_GET['haberDelete'])) {
	$sonuc=$db->delete("haberler","haber_id",$_GET['haber_id'],(isset($_GET['delete_file1']) ? $_GET['delete_file1'] : false),(isset($_GET['delete_file1_th']) ? $_GET['delete_file1_th'] : false),(isset($_GET['delete_file2']) ? $_GET['delete_file2'] : false),(isset($_GET['delete_file2_th']) ? $_GET['delete_file2_th'] : false));


	if ($sonuc['status']) {?>
		<div class="alert alert-success alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
			Haber silme başarılı bir şekilde gerçekleşti.
		</div>
	<?php }else{ ?>
		<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
			Haber silme başarısız oldu. <?php echo $sonuc['error']; ?>
		</div>
		<?php 
	}
} ?>
<!-- HABER SILME END -->
<!-- YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC--- -->
<!-- HABER LISTELEME START -->
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-11">
				<h3 class="card-title">Haberler</h3>
			</div>
			<div class="col-md-1 float-right">
				<a href="?haberInsert=true" width="30" type="button" class="btn bg-gradient-success">Haber Ekle</a>
			</div>
		</div>
	</div>

	<div class="card-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Haber Başlık</th>
					<th>Haber Resim 1</th>
					<th>Haber Resim 2</th>
					<th>Haber Resim 1 Thumbnail</th>
					<th>Haber Resim 2 Thumbnail</th>
					<th>Haber Link</th>
					<th>Durum</th>
					<th>Düzenle</th>
					<th>Sil</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$sql=$db->read("haberler");					
				while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
					?>
					<tr>
						<td><?php echo $row['haber_id'] ?></td>
						<td><?php echo $row['haber_baslik'] ?></td>
						<td><img width="200" src="<?php echo $row['haber_resim1'] ?>"></td>
						<td><img width="200" src="<?php echo $row['haber_resim2'] ?>"></td>
						<td><img width="200" src="<?php echo $row['haber_resim1_th'] ?>"></td>
						<td><img width="200" src="<?php echo $row['haber_resim2_th'] ?>"></td>
						<td><?php echo $row['haber_link'] ?></td>

						<td>
							<?php
							if($row['haber_durum']==0){
								echo "Pasif";
							}else{
								echo "Aktif";
							}
							?>

						</td>
						<td width="50" class="text-right">
							<a href="?haberUpdate=true&haber_id=<?php echo $row['haber_id'] ?>" class="btn btn-block bg-gradient-info"><i class="fa fa-pencil-alt"></i></a>
						</td>
						<td width="50" class="text-right">
							<a href="?haberDelete=true&haber_id=<?php echo $row['haber_id'] ?>&delete_file1=<?php echo $row['haber_resim1'] ?>&delete_file1_th=<?php echo $row['haber_resim1_th'] ?>&delete_file2=<?php echo $row['haber_resim2'] ?>&delete_file2_th=<?php echo $row['haber_resim2_th'] ?>" class="btn btn-block bg-gradient-danger"><i class="fas fa-trash"></i></a>

						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>			
</div>
<!-- HABER LISTELEME END -->
<!-- YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC---YENI BIR BASLANGIC--- -->
<!-- DATA TABLE ZORUNLU JS START -->
<script>
	$(function () {
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
		});
		$('#example2').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});
	});
</script>
<!-- DATA TABLE ZORUNLU JS END -->
<?php require_once 'footer.php'; ?>
