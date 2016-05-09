<?php
	include_once('include_fns.php');
	session_start();
	do_html_header('Notice');
	display_menu_bar();
	show_notices(get_all_unread_notice_with_uid($_SESSION['uid']));
	do_html_footer();
?>
