<?php
$title='Tolga Bektaş | Loglar';
$simdikiSayfa='Loglar / İki Tarih Arası Sorgulama';
require_once 'header.php'; 
?>
<!-- LOG IKI TARIH ARASI LISTELEME START -->
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-12">
				<h3 class="card-title">İki Tarih Arası Girişler</h3>
			</div>		
		</div>
	</div>
	<div class="card-header">
		<form method="POST">
			<div class="row">			
				<div class="form-group col-md-6">
					<label for="adsoyad">Başlangıç Tarihi</label>
					<input type="date" class="form-control" id="adsoyad" required="" name="ay_start">
				</div>
				<div class="form-group col-md-6">
					<label for="adsoyad">Bitiş Tarihi</label>
					<input type="date" class="form-control" id="adsoyad" required="" name="ay_finish">
				</div>
				<div class="form-group col-md-12 float-right">
					<button type="submit" class="btn bg-gradient-success float-right" name="aylik_goster">Listele</button>
				</div>			
			</div>
		</form>
	</div>

	<div class="card-body">
		<table id="example2" class="table table-bordered table-striped">
			<thead>
				<tr>					
					<th>Kullanıcı IP</th>
					<th>Girilen Sayfa</th>
					<th>Giriş Zamanı</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($_POST['aylik_goster'])): ?>			
					<?php 
					$ay_start=$_POST['ay_start']. " 00:00:00";
					$ay_finish=$_POST['ay_finish']." 23:59:59";
					
					$sql=$db->qSql("SELECT * FROM logs WHERE logs_time >='$ay_start' AND logs_time<='$ay_finish' ORDER BY logs_time DESC");
					$say=0;
					while ($row=$sql['stmt']->fetch(PDO::FETCH_ASSOC)) {
						?>
						<tr>
							<?php $say++; ?>
							<td><?php echo $row['logs_ip'] ?></td>
							<td><?php echo $row['logs_sayfa'] ?></td>
							<td><?php echo $row['logs_time'] ?></td>
						</tr>

					<?php } ?>
					<h5>Toplam Giriş <?php echo $say; ?></h5>

				<?php endif ?>
			</tbody>
		</table>
	</div>			
</div>
<!-- LOG IKI TARIH ARASI LISTELEME END -->


<!-- DATA TABLE ZORUNLU JS START -->
<script>
	$(function () {	
		$("#example2").DataTable({
			"responsive": true,
			"autoWidth": false,
		});		
	});
</script>
<!-- DATA TABLE ZORUNLU JS END -->



<?php require_once 'footer.php'; ?>
