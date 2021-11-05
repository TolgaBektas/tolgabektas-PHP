<?php
$title='Tolga Bektaş | Anasayfa';
$simdikiSayfa='Anasayfa';
require_once 'header.php'; 

$sql=$db->read("haberler");
$haberler=0;	
while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
	$haberler++;
}
$sql=$db->read("bloglar");
$bloglar=0;	
while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
	$bloglar++;
}
$sql=$db->read("referanslar");
$referanslar=0;	
while ($row=$sql->fetch(PDO::FETCH_ASSOC)) {
	$referanslar++;
}

?>

<!-- ANASAYFA ICERIK START -->

<div class="row">
	<div class="col-md-3">				
		<div class="small-box bg-info">
			<div class="inner">
				<h3><?php echo $haberler; ?></h3>
				<p>Haber</p>
			</div>
			<div class="icon">
				<i class="far fa-newspaper"></i>
			</div>
			<a href="haberler" class="small-box-footer">Haberle Git <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>

	<div class="col-md-3">				
		<div class="small-box bg-success">
			<div class="inner">
				<h3><?php echo $bloglar; ?></h3>
				<p>Blog</p>
			</div>
			<div class="icon">
				<i class="fas fa-blog"></i>
			</div>
			<a href="bloglar" class="small-box-footer">Bloglara Git <i class="fas fa-arrow-circle-right"></i></a>
		</div>
	</div>

	<div class="col-md-3">
		<div class="small-box bg-warning">
			<div class="inner">
				<h3>44</h3>
				<p>Referanslar</p>
			</div>
			<div class="icon">
				<i class="fas fa-hands-helping"></i>
			</div>
			<a href="referanslar" class="small-box-footer">Referanslara Git <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>

	<div class="col-md-3">
		<div class="small-box bg-danger">
			<div class="inner">
				<h3><?php echo $toplam_ziyaretci; ?></h3>
				<p>Bu Ay Toplam Ziyaretçi</p>
			</div>
			<div class="icon">
				<i class="fas fa-users"></i>
			</div>
			<a href="logs" class="small-box-footer">Ziyaretçi Detaylarına Git <i class="fas fa-arrow-circle-right"></i>
			</a>
		</div>
	</div>

</div>
<div class="row">

	<!-- HABER EKLEME START -->
	<?php if (isset($_POST['haber_insert'])) {
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
	<div class="col-md-6">
		<div class="card bg-gradient-info collapsed-card">
			<div class="card-header border-0 ui-sortable-handle">
				<h3 class="card-title">
					<i class="far fa-newspaper mr-1"></i>
					Hızlı Haber Ekleme 
				</h3>
				<div class="card-tools">
					<button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<div class="card-body">
				<form method="post" enctype="multipart/form-data">
					<div class="card-body">
						<div class="form-group">
							<label for="adsoyad">Haber Resim 1</label>
							<input type="file" class="form-control" id="adsoyad" required="" name="haber_resim1">
							<small>* Maks boyut : 1 MB</small>
						</div>
						<div class="form-group">
							<label for="adsoyad">Haber Resim 2</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim2">
							<small>* Maks boyut : 1 MB</small>
						</div>
						<div class="form-group">
							<label for="adsoyad">Haber Resim 1 Thumbnail</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim1_th">
							<small>* İçerik haricinde görüntülenecek resim. Sitenin hızlı yüklenebilmesi için olabilecek en ufak boyutta olması gerekmektedir.</small><br>
							<small>* Maks boyut : 0,3 MB</small>
						</div>
						<div class="form-group">
							<label for="adsoyad">Haber Resim 2 Thumbnail</label>
							<input type="file" class="form-control" id="adsoyad" name="haber_resim2_th">
							<small>* İçerik haricinde görüntülenecek resim. Sitenin hızlı yüklenebilmesi için olabilecek en ufak boyutta olması gerekmektedir.</small><br>
							<small>* Maks boyut : 0,3 MB</small>
						</div>		
						<div class="form-group">
							<label for="adsoyad">Haber Başlık</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Haber Başlığı" name="haber_baslik">
						</div>
						<div class="form-group">
							<label for="adsoyad">Haber Tarihi</label>
							<input type="date" class="form-control" id="adsoyad" required="" placeholder="Haber Tarihi" name="haber_zaman">
						</div>
						<div class="form-group">
							<label for="adsoyad">Haber İçerik</label>
							<textarea id="summernote" name="haber_icerik" required="" class="form-control"></textarea>
						</div>
						<div class="form-group">
							<label for="adsoyad">Haber Description</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Haber Description" name="haber_description">
						</div>
						<div class="form-group">
							<label for="adsoyad">Haber Keywords</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Haber Keywords" name="haber_keywords">
						</div>

						<div class="form-group">
							<label for="adsoyad">Haber Slug Link</label>
							<input type="text" class="form-control" id="adsoyad" placeholder="Haber Linki" name="haber_link">
							<small>* Bu alan boş bırakılırsa link başlık neyse o olacaktır.</small>
						</div>
						<div class="form-group">
							<label for="kullaniciadi">Haber Durum</label>
							<select class="form-control" name="haber_durum">
								<option value="1">Aktif</option>
								<option value="0">Pasif</option>

							</select>
						</div>
					</div>
					<div class="card-footer bg-transparent">
						<button type="submit" class="btn bg-gradient-success float-right" name="haber_insert">Ekle</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- HABER EKLEME END -->
	<!-- Blog EKLEME START -->
	<?php
	if (isset($_POST['blog_insert'])) {
		$sonuc=$db->insert("bloglar",$_POST,["form_name"=>"blog_insert","dir"=>'../images/bloglar',"file_name1"=>"blog_resim1","file_name2"=>"blog_resim2","slug"=>"blog_link","title"=>"blog_baslik"]);
		if ($sonuc['status']) {?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
				Blog ekleme başarılı bir şekilde gerçekleşti.
			</div>
		<?php }else{ ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
				Blog ekleme başarısız oldu. <?php echo $sonuc['error']; ?>
			</div>
		<?php }
	}
	?>

	<div class="col-md-6">
		<div class="card bg-gradient-success collapsed-card">
			<div class="card-header border-0 ui-sortable-handle">
				<h3 class="card-title">
					<i class="fas fa-blog mr-1"></i>
					Hızlı Blog Ekleme 
				</h3>
				<div class="card-tools">
					<button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn bg-success btn-sm" data-card-widget="remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<div class="card-body">	
				<form method="post" enctype="multipart/form-data">
					<div class="card-body">
						<div class="form-group">
							<label for="adsoyad">Blog Resim 1</label>
							<input type="file" class="form-control" id="adsoyad" required="" name="blog_resim1">
						</div>
						<div class="form-group">
							<label for="adsoyad">Blog Resim 2</label>
							<input type="file" class="form-control" id="adsoyad" name="blog_resim2">
						</div>		
						<div class="form-group">
							<label for="adsoyad">Blog Başlık</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Blog Başlığı" name="blog_baslik">
						</div>
						<div class="form-group">
							<label for="adsoyad">Blog Tarihi</label>
							<input type="date" class="form-control" id="adsoyad" required="" placeholder="Blog Tarihi" name="blog_zaman">
						</div>
						<div class="form-group">
							<label for="adsoyad">Blog İçerik</label>
							<textarea id="summernote2" name="blog_icerik" required="" class="form-control"></textarea>
						</div>

						<div class="form-group">
							<label for="adsoyad">Blog Description</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Blog Description" name="blog_description">
						</div>
						<div class="form-group">
							<label for="adsoyad">Blog Keywords</label>
							<input type="text" class="form-control" id="adsoyad" required="" placeholder="Blog Keywords" name="blog_keywords">
						</div>

						<div class="form-group">
							<label for="adsoyad">Blog Slug Link</label>
							<input type="text" class="form-control" id="adsoyad" placeholder="Blog Linki" name="blog_link">
							<small>* Bu alan boş bırakılırsa link başlık neyse o olacaktır.</small>
						</div>
						<div class="form-group">
							<label for="kullaniciadi">Blog Durum</label>
							<select class="form-control" name="blog_durum">
								<option value="1">Aktif</option>
								<option value="0">Pasif</option>

							</select>
						</div>
					</div>
					<div class="card-footer bg-transparent">
						<button type="submit" class="btn bg-gradient-info float-right" name="blog_insert">Blog Ekle</button>
					</div>
				</form>

			</div>
		</div>
	</div>
	<!-- Blog EKLEME END -->

</div>


<!-- ANASAYFA ICERIK END -->


<?php require_once 'footer.php'; ?>
