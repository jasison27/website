<?php
	include_once('include_fns.php');
	session_start();
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin']) || $_SESSION['isadmin']!='Y') {
		middlepage('index.php', "权限不足");
	}
	if (isset($_GET['pid']) && isset($_GET['cid'])) {
		delete_comment($_GET['cid']);
		middlepage("viewarticle.php?pid=".$_GET['pid'], "删除评论成功");
	} else {
		middlepage('index.php', "你穿越了吧");
	}
?>
