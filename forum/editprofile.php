<?php
	include_once('include_fns.php');
	session_start();
try {
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin'])) {
		throw new Exception('Please Login First');
	} else {
		do_html_header('Profile');
		display_menu_bar();
		$profile = get_user_profile($_SESSION['uid']);
?>
<div class='content'>
	<form action="profile.php" method="post"><table>
		<tr>
			<td>Uid:</td>
			<td> <?php echo $profile['uid'] ?> </td>
		</tr>
		<tr>
			<td>Real Name:</td>
			<td><input type="text" name='realname' value=<?php echo $profile['realname'] ?> ></td>
		</tr>
		<tr>
			<td>Contact:</td>
			<td><input type="text" name='contact' value=<?php echo $profile['contact'] ?> ></td>
		</tr>
		<tr>
			<td>Signature:</td>
			<td><textarea name="signature" cols="30" rows="10"><?php echo $profile['signature'] ?></textarea></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="submit" value='Update'></td>
		</tr>
	</table></form>
</div>
<?php
	}
} catch (Exception $e) {
	do_html_header('Error');
	display_menu_bar();
	do_html_h2($e->getMessage());
}
	do_html_footer();
?>
