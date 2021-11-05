<?php
$title = 'İnfina | Ayarlar';
$simdikiSayfa = 'Ayarlar';
require_once 'header.php';
?>


<!-- setting GUNCELLEME START -->
<?php

if (isset($_GET['settingsUpdate'])) {
	if (isset($_POST['setting_update'])) {
		$sonuc = $db->update(
			"settings",
			$_POST,
			[
				"form_name" => "setting_update",
				"columns" => "settings_id",
				"file_name" => "settings_value",
				"dir" => 'dist/images/site',
				"delete_file" => "delete_file"
			]
		);
		if ($sonuc['status']) { ?>
			<div class="alert alert-success alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarılı!</h5>
				Ayar güncelleme başarılı bir şekilde gerçekleşti.
			</div>
		<?php } else { ?>
			<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<h5><i class="icon fas fa-check"></i> Başarısız!</h5>
				Ayar güncelleme başarısız oldu. <?php echo $sonuc['error']; ?>
			</div>
	<?php }
	}
	?>

	<?php
	$sql = $db->wread("settings", "settings_id", $_GET['settings_id']);
	$row = $sql->fetch(PDO::FETCH_ASSOC);
	?>
	<div class="card">
		<div class="card-header">
			<div class="row">
				<div class="col-md-12">
					<h1 class="card-title">Ayar Güncelleme -> <?php echo $row['settings_description']; ?></h1>
					<div class="card-tools float-right">
						<button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
							<i class="fas fa-times"></i>
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="card-body">
			<form method="POST" enctype="multipart/form-data">
				<div class="card-body">

					<?php if ($row['settings_type'] == "file") : ?>
						<div class="form-group">
							<label for="adsoyad">Yeni Resim</label>
							<input type="file" class="form-control" id="adsoyad" name="settings_value">
							<input type="hidden" name="delete_file" value="<?php echo $row['settings_value']; ?>">
						</div>
					<?php endif ?>
					<?php if ($row['settings_type'] == "text") : ?>
						<div class="form-group">
							<label for="adsoyad"><?php echo $row['settings_description']; ?></label>
							<input type="text" class="form-control" id="adsoyad" value="<?php echo $row['settings_value'] ?>" name="settings_value">
						</div>
					<?php endif ?>
					<?php if ($row['settings_type'] == "textarea") : ?>
						<div class="form-group">
							<label for="adsoyad"><?php echo $row['settings_description']; ?></label>
							<textarea class="form-control" name="settings_value"><?php echo $row['settings_value']; ?></textarea>
						</div>
					<?php endif ?>

					<div class="form-group">
						<label for="kullaniciadi">Ayar Durum</label>
						<select class="form-control" name="settings_status">

							<option <?php if ($row['settings_status'] == 1) {
										echo "selected";
									} ?> value="1">Aktif</option>

							<option <?php if ($row['settings_status'] == 0) {
										echo "selected";
									} ?> value="0">Pasif</option>
						</select>
					</div>
				</div>
				<div class="card-footer">
					<input type="hidden" name="settings_id" value="<?php echo $row['settings_id']; ?>">
					<button type="submit" class="btn bg-gradient-success float-right" name="setting_update">Güncelle</button>
				</div>
			</form>
		</div>
	</div>
<?php
}

?>
<!-- setting GUNCELLEME END -->

<!-- setting LISTELEME START -->
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-12">
				<h3 class="card-title">Ayarlar</h3>
			</div>

		</div>
	</div>
	<div class="card-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Ayar Açıklaması</th>
					<th>Ayar İçeriği</th>
					<th>Ayar Aktif/Pasif</th>
					<th>Düzenle</th>

				</tr>
			</thead>
			<tbody>
				<?php
				$sql = $db->read("settings", ["columns_name" => "settings_id", "columns_sort" => "ASC"]);
				while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
				?>
					<tr>

						<td><?php echo $row['settings_description'] ?></td>
						<?php if ($row['settings_type'] == "file") : ?>
							<td><img width="200" src="<?php echo $row['settings_value'] ?>"></td>
						<?php else : ?>
							<td><?php echo $row['settings_value'] ?></td>
						<?php endif ?>
						<td>
							<?php
							if ($row['settings_status'] == 0) {
								echo "Pasif";
							} else {
								echo "Aktif";
							}
							?>

						</td>
						<td width="50" class="text-right">
							<a href="?settingsUpdate=true&settings_id=<?php echo $row['settings_id'] ?>" class="btn btn-block bg-gradient-info"><i class="fa fa-pencil-alt"></i></a>
						</td>

					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script>
	$(function() {
		
		$('#example1').DataTable({
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
<!-- setting LISTELEME END -->
<?php require_once 'footer.php'; ?>