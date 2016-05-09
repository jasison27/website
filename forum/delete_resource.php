<?php
	include_once('include_fns.php');
	session_start();
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin']) || !isset($_GET['uid']) || !isset($_GET['resource'])) {
		middlepage('index.php', "你穿越了吧");
	}
	if ($_GET['uid'] != $_SESSION['uid'] && $_SESSION['isadmin'] != 'Y') {
		middlepage('index.php', "权限不足");
	}
	$uid = $_GET['uid'];
	$file = $_GET['resource'];
	$ext = "./upload/$uid/$file";
	unlink($ext);
	middlepage("uploads.php?uid=$uid", "删除资源成功");
?>
