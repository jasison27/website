<?php
	require_once('include_fns.php');
	session_start();
	do_html_header(home());
	display_menu_bar();
	// check if we have created our session variable
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin'])) {
		//do_html_h2("<a href='love/'>Happy New Year!</a>");
		do_html_h2("<img src='upload/40355819.jpg' width='300'/>");
	} else {
		try {
			show_articles(get_all_article());
			show_visitors(get_all_visitor());
		} catch (Exception $e) {
			do_html_h2($e->getMessage());
		}
	}

	do_html_footer();
?>
