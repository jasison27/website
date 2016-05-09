<?php
	include_once('include_fns.php');
	session_start();
try {
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin'])) {
		throw new Exception('Login First.');
	}
	if (!isset($_GET['pid']) || !isset($_GET['action'])) {
		throw new Exception('No Get catched.');
	}
	if ($_GET['action'] == 'create') {
		if (praise_uid_pid($_SESSION['uid'], $_GET['pid'])) {
			throw new Exception('Already Praised');
		} else {
			post_notice($_SESSION['uid'], $_GET['pid'], get_server_time(), "NP");
			praise_create_uid_pid($_SESSION['uid'], $_GET['pid']);
		}
	} else {
		if (praise_uid_pid($_SESSION['uid'], $_GET['pid'])) {
			praise_delete_uid_pid($_SESSION['uid'], $_GET['pid']);
		} else {
			throw new Exception('Already Unpraised');
		}
	}
} catch (Exception $e) {
	do_html_header('Error');
	display_menu_bar();
	do_html_h2($e->getMessage());
	exit;
}
?>
<html lang="zh-cn">
	<head>
		<title>Praise</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="base.css" type="text/css" />
		<meta http-equiv="refresh" content="1;url=viewarticle.php?pid=<?php echo $_GET['pid']?>"/>
	</head>
	<body>
		<div class="content">
			<h2>
				<?php echo $_GET['action']=='create'?'Praise Success':'Unpraise Success'; ?>
			</h2>
		</div>
	</body>
</html>
