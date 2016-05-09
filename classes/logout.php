<?php
ob_start();	
include_once('include_fns.php');
session_start();
if(!isset($_SESSION['email'])){
	ob_end_clean();
	header("Location: index.php");
	exit;
} else {
	unset($_SESSION['email']);
	unset($_SESSION['stuid']);
	unset($_SESSION['realname']);
	session_destroy();
	if (isset($_COOKIE['sso'])) {
		delete_cookie($_COOKIE['sso']);
	}
	setcookie("sso", "", time()-3600);
	ob_end_clean();
	header("Location: index.php");
	exit;
}
?>
