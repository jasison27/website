<?php
	include_once('include_fns.php');
	session_start();
	do_html_header('Logout');
	unset($_SESSION['uid']);
	session_destroy();
	display_menu_bar();
	do_html_h2('Logout Success');
?>
