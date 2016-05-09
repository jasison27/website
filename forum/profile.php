<?php
	include_once('include_fns.php');
	session_start();
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin'])) {
		do_html_header('Error');
		display_menu_bar();
		do_html_h2('Please Login First');
	} else {
		$uid = $_SESSION['uid'];
		if (isset($_POST['realname']) && isset($_POST['contact']) && isset($_POST['signature'])) {
			update_user_profile($uid, trim($_POST['realname']), trim($_POST['contact']), trim($_POST['signature']));
		}
		$update_flag = 'Y';
		if (isset($_GET['uid']) && $_GET['uid'] != $uid) {
			$uid = $_GET['uid'];
			$update_flag = 'N';
		}
try {
		$profile = get_user_profile($uid);
		do_html_header($uid);
		display_menu_bar();
?>
<div class='content'>
	<form action='<?php if ($uid == $_SESSION['uid']) echo 'editprofile.php'; else echo "uploads.php?uid=".$uid ?>' method='post'><table>
		<tr>
			<td>Uid:</td>
			<td> <?php echo $profile['uid'] ?> </td>
		</tr>
		<tr>
			<td>Real Name:</td>
			<td> <?php echo $profile['realname'] ?> </td>
		</tr>
		<tr>
			<td>Contact:</td>
			<td> <?php echo $profile['contact'] ?> </td>
		</tr>
		<tr>
			<td>Signature:</td>
			<td> <?php echo nl2br($profile['signature']) ?> </td>
		</tr>
		<tr>
			<td>
				<?php
				if ($uid != $_SESSION['uid']) {
					echo "<a href='leavemessage.php?toid=".$uid."'>Leave a Message</a>";
				}
				?>
			</td>
			<td><input type="submit" value='<?php if ($uid == $_SESSION['uid']) echo 'Edit Profile'; else echo 'View Upload'; ?>'></td>
		</tr>
	</table></form>
</div>
<?php
} catch (Exception $e) {
	do_html_header('Error');
	display_menu_bar();
	do_html_h2($e->getMessage());
}
	}
	do_html_footer();
?>
