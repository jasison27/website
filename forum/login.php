<?php
	include_once('include_fns.php');
	session_start();
if (isset($_SESSION['uid']) && isset($_SESSION['isadmin'])) {
	do_html_header('Login');
	display_menu_bar();
	do_html_h2('Already Logined.');
} else if (!isset($_POST['uid']) || !isset($_POST['passwd'])) {
	do_html_header('Login');
	display_menu_bar();
?>
	<div class="content">
	<form method="post" action="login.php">
		<table>
			<tr>
				<td>Username:</td>
				<td><input type='text' name='uid'></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type='password' name='passwd'></td>
			</tr>
			<tr>
				<td></td>
				<td align='right'><input type='submit' value='Login'></td>
			</tr>
		</table>
	</form>
	</div>
<?php
} else {
	try {
		$_SESSION['isadmin'] = login($_POST['uid'], $_POST['passwd']);
		$_SESSION['uid'] = $_POST['uid'];
		new_visitor($_SESSION['uid'], get_server_time());
		do_html_header('Login');
		display_menu_bar();
		do_html_h2('Login Success');
	} catch (Exception $e) {
		do_html_header('Error');
		display_menu_bar();
		do_html_h2($e->getMessage());
	}
}
	do_html_footer();
?>
