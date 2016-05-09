<?php
	include_once('include_fns.php');
	session_start();
	try {
		if (!isset($_SESSION['uid'])) {
			throw new Exception('Please Login First');
		} else if (!isset($_GET['pid'])) {
			throw new Exception('No Article To View');
		} else {
			$pid = $_GET['pid'];
			if (isset($_POST['reply'])) {
				if (!isset($_SESSION['reply']) || $_SESSION['reply']!=$_POST['reply']) {
					$ptime = get_server_time(); 
					post_comment($pid, $_SESSION['uid'], $ptime, trim($_POST['reply']));
					post_notice($_SESSION['uid'], $pid, $ptime, "N");
					$_SESSION['reply'] = $_POST['reply'];
				}
			}
			// get article by pid
			$article = get_article_details($pid);
			if (get_uid_with_pid($pid) == $_SESSION['uid']) {
				read_notice_with_pid($pid);
			}
			do_html_header($article['title']);
			display_menu_bar();
			display_article_detail($article);
			$cid = -1;
			if (isset($_GET['cid'])) {
				$cid = $_GET['cid'];
			}
			if ($cid == 0) {
				display_reply_form(0, $pid);
			}
			display_all_reply($cid, $pid, get_all_comments($pid));
		}
	} catch (Exception $e) {
		do_html_header('Error');
		display_menu_bar();
		do_html_h2($e->getMessage());
	}
	do_html_footer();
?>
