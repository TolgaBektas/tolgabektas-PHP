<?php
$title='Tolga Bektaş | Loglar';
$simdikiSayfa='Loglar / Tüm Girişler';
require_once 'header.php'; 
?>


<!-- LOG LISTELEME START -->
<div class="card">
	<div class="card-header">
		<div class="row">
			<div class="col-md-12">
				<h3 class="card-title">Girişler</h3>
			</div>		
		</div>
	</div>
	<div class="card-header">
		<form method="POST">
			<div class="row">			
				<div class="form-group col-md-6">
					<label for="adsoyad">Yıl</label>
					<input class="form-control" type="number" required placeholder="Yılı yazınız." min="2020" max="2100" name="ay">
				</div>
				<div class="form-group col-md-6">
				</div>
				<div class="form-group col-md-6">
					<button type="submit" class="btn bg-gradient-success float-right" name="ay_goster">Listele</button>
				</div>			
			</div>
		</form>
	</div>
	<div class="card-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>					
					<th>Kullanıcı IP</th>
					<th>Girilen Sayfa</th>
					<th>Ülke</th>
					<th>Şehir</th>
					<th>Posta Kodu</th>
					<th>Giriş Zamanı</th>
				</tr>
			</thead>
			<tbody>
				<?php if (isset($_POST['ay_goster'])): ?>			
					<?php 
					$ay=$_POST['ay'];
					$sql=$db->qSql("SELECT * FROM logs WHERE logs_time LIKE '$ay%' ORDER BY logs_time DESC");
					$say=0;
					while ($row=$sql['stmt']->fetch(PDO::FETCH_ASSOC)) {
						?>
						<tr>
							<?php $say++; ?>
							<td><?php echo $row['logs_ip'] ?></td>
							<td><?php echo $row['logs_sayfa'] ?></td>
							<td><?php echo $row['logs_ulke'] ?></td>
							<td><?php echo $row['logs_sehir'] ?></td>
							<td><?php echo $row['logs_postaKodu'] ?></td>
							<td><?php echo $row['logs_time'] ?></td>
						</tr>

					<?php } ?>
					<h5>Toplam Giriş <?php echo $say; ?></h5>

				<?php endif ?>
			</tbody>
		</table>
	</div>			
</div>
<!-- LOG LISTELEME END -->
<!-- DATA TABLE ZORUNLU JS START -->
<script>
	$(function () {
		$("#example1").DataTable({
			"responsive": true,
			"autoWidth": false,
		});
		
	});
</script>
<!-- DATA TABLE ZORUNLU JS END -->



<?php require_once 'footer.php'; ?>
