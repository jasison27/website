<?php
	include_once('include_fns.php');
	session_start();
	do_html_header('Upload');
	display_menu_bar();
if (!isset($_FILES['userfile'])) {
?>
<div class='content'>
	<form action="upload.php" method='post' enctype='multipart/form-data' />
		<div>
			<label for="userfile">Upload a file:</label>
			<input type="file" name='userfile' id='userfile' />
			<input type="submit" value='Upload' />
		</div>
	</form>
</div>
<?php
} else {
	//Check to see if an error code was generated on the upload attempt
	if ($_FILES['userfile']['error'] > 0) {
		switch ($_FILES['userfile']['error']) {
			case 1:
				do_html_h2('Problem: File exceeded upload_max_filesize');
				break;
			case 2:
				do_html_h2('Problem: File exceeded max_file_size');
	  			break;
	  		case 3:
	  			do_html_h2('Problem: File only partially uploaded');
	  			break;
	  		case 4:
	  			do_html_h2('Problem: No file uploaded');
	  			break;
	  		case 6:
	  			do_html_h2('Problem: Cannot upload file: No temp directory specified.');
	  			break;
	  		case 7:
	  			do_html_h2('Problem: Upload failed: Cannot write to disk.');
	  			break;
	  	}
	} else {
		if(!is_dir("./upload")){
			mkdir("./upload");
		}
		if(!is_dir("./upload/".$_SESSION['uid'])){
			mkdir("./upload/".$_SESSION['uid']);
		}
		// put the file where we'd like it
		$upfile = './upload/'.$_SESSION['uid'].'/'.$_FILES['userfile']['name'];
		if (!is_uploaded_file($_FILES['userfile']['tmp_name'])) {
			do_html_h2('Problem: Possible file upload attack. Filename: '.$_FILES['userfile']['name']);
		} else  {
			if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $upfile)) {
				do_html_h2('Problem: Could not move file to destination directory');
			} else {
				$web = './upload/'.$_SESSION['uid'].'/'.$_FILES['userfile']['name'];
				$site = 'localhost/forum/'.$web;
?>
<div class='content'>
	<p>Uploaded Successfully.<br/></p>
	<p>You can visit in <a href=<?php echo $web ?> ><?php echo $site ?></a></p>
</div>
<?php
			}
		}
	}
}
	do_html_footer();
?>
