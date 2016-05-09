<?php
	include_once('include_fns.php');
	session_start();
if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin'])) {
	do_html_header('Error');
	display_menu_bar();
	do_html_h2('Please Login First.');
} else if (!isset($_POST['title']) || !isset($_POST['content']) || $_POST['title']=='') {
	do_html_header('New Article');
	display_menu_bar();
?>
	<div class="content"><div style='width:600'>
	<form action="newarticle.php" method="post">
		<p>Title:</p>
		<input type="text" name="title" style='width:100%' />
		<p>Content:<p>
		<textarea name="content" rows="10" style='width:100%'></textarea>
		<input type="submit" value="Post" />
	</form>
	</div></div>
<?php
} else {
	try {
		post_article($_SESSION['uid'], trim($_POST['title']), trim($_POST['content']), get_server_time());
		do_html_header('New Article');
		display_menu_bar();
		do_html_h2('Post Success');
	} catch (Exception $e) {
		do_html_header('Error');
		display_menu_bar();
		do_html_h2($e->getMessage());
	}
}
	do_html_footer();
?>
