<?php 
session_start();
session_destroy();
setcookie("adminsLogin",json_encode($admins),strtotime("-30 day"),"/");
header("location:login");
?>