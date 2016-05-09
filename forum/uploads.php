<?php
	include_once('include_fns.php');
	session_start();
	if (!isset($_SESSION['uid']) || !isset($_SESSION['isadmin'])) {
		do_html_header('Error');
		display_menu_bar();
		do_html_h2('Login to View.');
	} else {
		$uid = $_SESSION['uid'];
		$candelete = true;
		if (isset($_GET['uid']) && $_GET['uid']!=$uid) {
			$uid = $_GET['uid'];
			$candelete = false;
		}
		if ($_SESSION['isadmin']=='Y') {
			$candelete = true;
		}
		do_html_header('Uploads');
		display_menu_bar();
		$dir = dir('./upload/'.$uid.'/');
		$site = '/forum/upload/'.$uid.'/';
		echo "<div class='content'>";
		echo "<p>";
		do_html_link_profile($uid);
		echo "'s Uploaded Files:</p><ul>";
		$total = 0;
		while (false !== ($file = $dir->read())) {
			if ($file != "." && $file != "..") {
				$total ++;
				echo "<li><a href='$site$file' target='_blank'>$file</a>";
				if ($candelete) {
					echo "&nbsp<a href=delete_resource.php?uid=$uid&&resource=$file>删除</a></li>";
				}
			}
		}
		if ($total == 0) {
			echo "<p>No Such File Found.</p>";
		}
		echo "</ul>";
		$dir->close();
		echo "</div>";
	}
	do_html_footer();
?>
