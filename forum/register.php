<?php
	include_once('include_fns.php');
	session_start();
if (!isset($_POST['uid']) || !isset($_POST['passwd'])) {
	do_html_header('Register');
	display_menu_bar();
?>
	<div class="content">
	<font color='red'>
		1.You can register with Chinese username.<br/>
		2.You can only characters and digits as user name.<br/>
		3.Better not to use passwd that's critical to you.<br/>
		4.The first one to register will be the administrator.<br/>
	</font>
	<form method="post" action="register.php">
		<table>
			<tr>
				<td align='left' valign='top'>Username:</td>
				<td align='right' valign='top'><input type='text' name='uid' maxlength='16'></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type='password' name='passwd'></td>
			</tr>
			<tr>
				<td></td>
				<td align='right'><input type='submit' value='Register'></td>
			</tr>
		</table>
	</form>
	</div>
<?php
} else {
	try {
		$_SESSION['isadmin'] = register($_POST['uid'], $_POST['passwd']);
		$_SESSION['uid'] = $_POST['uid'];
		if (!is_dir('./upload/'.$_SESSION['uid'])) {
			mkdir('./upload/'.$_SESSION['uid'], 0777);
		}
		do_html_header('Register');
		display_menu_bar();
		do_html_h2('Register Success');
	} catch (Exception $e) {
		do_html_header('Error');
		display_menu_bar();
		do_html_h2($e->getMessage());
	}
}
	do_html_footer();
?>
