<?php
session_start();
if (isset($_SESSION['admins']) || isset($_COOKIE['adminsLogin'])) {
	header("Location:index");
	exit;
}
require_once 'netting/class.crud.php';
$db = new crud();

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tolga Bektaş | Giriş Yap</title>

	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
	<!-- icheck bootstrap -->
	<link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="dist/css/adminlte.min.css">
	<style type="text/css">
		.login-page {
			background: url(dist/images/site/bg.jpg) no-repeat center center fixed;
			background-size: cover;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
		}
	</style>
</head>

<body class="hold-transition login-page">
	<div class="login-box">
		<div class="login-logo">
			<a style="color:red;" href="http://www.tolgabektas.com/"><b>Tolga </b>Bektaş</a>
		</div>
		<!-- /.login-logo -->
		<div class="card">
			<div class="card-body login-card-body">
				<p class="login-box-msg">Giriş yapmak için formu doldurunuz</p>

				<?php
				if (isset($_COOKIE['adminsLogin'])) {
					$login = json_decode($_COOKIE['adminsLogin']);
				}


				if (isset($_POST['admins_login'])) {
					if (!isset($_POST['remember_me'])) {
						$sonuc = $db->adminsLogin(htmlspecialchars($_POST['admins_username']), htmlspecialchars($_POST['admins_password']));
					} else {
						$sonuc = $db->adminsLogin(htmlspecialchars($_POST['admins_username']), htmlspecialchars($_POST['admins_password']), $_POST['remember_me']);
					}
					if ($sonuc['status']) {
						header("Location:index");
						exit;
					} else {
				?>
						<div class="alert alert-danger alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							<h5><i class="icon fas fa-ban"></i> Uyarı!</h5>
							Lütfen bilgilerinizi kontrol ediniz.
						</div>
				<?php
					}
				}

				?>



				<form method="POST">
					<div class="input-group mb-3">
						<input type="text" class="form-control" autocomplete="off" name="admins_username" <?php
																											if (isset($_COOKIE['adminsLogin'])) {
																												echo 'value="' . $login->admins_username . '"';
																											} else {
																												echo 'placeholder="Kullanıcı adı"';
																											}
																											?>>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-envelope"></span>
							</div>
						</div>
					</div>
					<div class="input-group mb-3">
						<input type="password" class="form-control" name="admins_password" <?php
																							if (isset($_COOKIE['adminsLogin'])) {
																								echo 'value="' . $login->admins_password . '"';
																							} else {
																								echo 'placeholder="Şifre"';
																							}
																							?>>
						<div class="input-group-append">
							<div class="input-group-text">
								<span class="fas fa-lock"></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-8">
							<div class="icheck-primary">
								<input type="radio" <?php
													if (isset($_COOKIE['adminsLogin'])) {
														echo "checked";
													}
													?> id="remember" name="remember_me">
								<label for="remember">
									Oturumu Açık Tut
								</label>
							</div>
						</div>
						<div class="col-4">
							<button type="submit" class="btn btn-primary btn-block" name="admins_login">Giriş Yap</button>
						</div>
					</div>
				</form>



			</div>
			<!-- /.login-card-body -->
		</div>
	</div>
	<!-- /.login-box -->

	<!-- jQuery -->
	<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
	<!-- Bootstrap 4 -->
	<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<!-- AdminLTE App -->
	<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>

</html>