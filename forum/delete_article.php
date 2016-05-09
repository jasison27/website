<?php
	include_once('include_fns.php');
	session_start();
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin']) || $_SESSION['isadmin']!='Y') {
		middlepage('index.php', "权限不足");
	}
	if (isset($_GET['pid'])) {
		delete_article($_GET['pid']);
		middlepage('index.php', "删除文章成功");
	} else {
		middlepage('index.php', "你穿越了吧");
	}
?>
