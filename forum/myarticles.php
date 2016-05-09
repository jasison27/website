<?php
	include_once('include_fns.php');
	session_start();
	do_html_header('My Articles');
	display_menu_bar();
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin'])) {
		do_html_h2('Login to View.');
	} else {
		try {
			show_articles(get_articles_with_uid($_SESSION['uid']));
		} catch (Exception $e) {
			do_html_h2($e->getMessage());
		} 
	}
	do_html_footer();
?>
