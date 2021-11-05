<?php 
if (!isset($_SESSION['admins']) && isset($_COOKIE['adminsLogin'])) {
	$adminlog=json_decode($_COOKIE['adminsLogin']);
	$sonuc=$db->adminsLogin($adminlog->admins_username,$adminlog->admins_password,TRUE);
}
if (!isset($_SESSION['admins']) && !isset($_COOKIE['adminsLogin'])) {
	header("Location:login");
	exit;
}

?>