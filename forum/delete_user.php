<?php
	include_once('include_fns.php');
	session_start();
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin']) || $_SESSION['isadmin']!='Y') {
		middlepage('index.php', "权限不足");
	}
	if (!isset($_GET['uid'])) {
		middlepage('index.php', "你穿越了吧");
	}
	$duid = $_GET['uid'];
	delete_user_all_things($duid);
	$dir = "./upload/$duid/";
	deldir($dir);
	middlepage('manage.php', "彻底删除用户'".$duid."'成功");
?>
