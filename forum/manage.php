<?php
	include_once('include_fns.php');
	session_start();
	if ($_SESSION['isadmin']!='Y'){
		middlepage('index.php', "权限不足");
	}
	do_html_header('Manage');
	display_menu_bar();
	show_users(get_all_user());
	do_html_footer();
?>
