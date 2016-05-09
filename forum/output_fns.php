<?php
function middlepage($address, $info) {
	?>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="refresh" content="<?php echo 1; ?>; url=<?php echo $address; ?>" />
		<title>Forum - 中间页面</title>
	</head>
	<body>
		<p><?php echo $info; ?>, 自动跳转中...</a></p>
	</body>
	<?php
	exit;
}

function do_html_header($title) {
	// print an HTML header
?>
<html lang="zh-cn">
	<head>
		<title><?php echo $title; ?></title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="base.css" type="text/css" />
	</head>
	<body>
<?php
}

function do_html_footer() {
	// print an HTML footer
?>
	</body>
</html>
<?php
}

function display_menu_bar() {
	// display menu bar
?>
	<div class='menu'>
		<span id='menu-left'>
			<a href='index.php'>Home</a>
			<?php if (isset($_SESSION['uid'])) { ?>
				| <a href="myarticles.php">My Post</a>
				| <a href="newarticle.php">New Post</a>
				| <a href="uploads.php">My Disk</a>
				| <a href='upload.php'>Upload</a>
			<?php } ?>
		</span>
		<span id='menu-right'>
			<?php if (isset($_SESSION['uid'])) {
				echo "[" . $_SESSION['uid'] . "]";
				if ($_SESSION['isadmin']=='Y') { ?>
| <a href='manage.php'>Manage</a>
				<?php } else { ?>
| <a href='notice.php'>Notice(<?php echo get_unread_notice_number_with_uid($_SESSION['uid']) ?>)</a>
| <a href='profile.php'>Profile</a>
				<?php } ?>
| <a href="logout.php">Logout</a>
			<?php
			} else {
			?>
<a href='login.php'>Sign in</a> | <a href='register.php'>Sign up</a>
			<?php } ?>
		</span>
	</div>
<?php
}

function do_html_h2($msg) {
?>
	<div class="content"><h2><?php echo $msg ?></h2></div>
<?php
}

function do_html_link($name, $link) {
	echo "<a href=".$link.">".$name."</a>";
}
function do_html_link_profile($uid) {
	do_html_link($uid, "profile.php?uid=".$uid);
}

function show_articles($article_array) {
?>
	<div class="content">
	<table>
<?php
	if (is_array($article_array) && count($article_array) > 0 ) {
		foreach(array_reverse($article_array) as $article) {
?>
	<tr>
	<?php echo "<td><a href=viewarticle.php?pid=" .$article['pid'].">". $article['title'] . "</a></td>"?>
	<td><?php echo "评论[".count(get_all_comments($article['pid']))."]" ?> </td>
	<td><?php echo "赞[".count(get_praise_with_pid($article['pid']))."]&nbsp;&nbsp;" ?></td>
	<td><?php do_html_link_profile($article['uid']) ?> </td>
	<td><?php echo $article['ptime'] ?> </td>
	<?php if (isset($_SESSION['isadmin']) && $_SESSION['isadmin']=='Y') {
		echo "<td><a href=delete_article?pid=".$article['pid'].">删除"."</a></td>";
	} ?>
	</tr>
<?php
		}
	} else {
		echo "No such article found.";
	}
?>
	</table>
	</div>
<?php
}

function show_visitors($visitor_array) {
?>
	<div class="content">
<?php
$max_number = 10;
if (count($visitor_array) < $max_number) {
	$max_number = count($visitor_array);
}
echo "<p>Recently ".$max_number." visitors:</p>";
if (is_array($visitor_array)) {
	echo "<table>";
	foreach (array_reverse($visitor_array) as $visitor) {
		echo "<tr><td>".$visitor['vtime']."</td>";
		echo "<td><a href='profile.php?uid=".$visitor['uid']."'>".$visitor['uid']."</a></td><tr>";
		$max_number --;
		if ($max_number == 0) {
			break;
		}
	}
	echo "</table>";
}
echo "<p align='right'>Totally ".count($visitor_array)." visitors.</p>";
?>
	</div>
<?php
}

function show_users($user_array) {
	if (is_array($user_array)) {
?>
	<div class="content">
	<p>Totally <?php echo count($user_array) ?> users:</p>
	<table>
<?php
	
	foreach ($user_array as $user) {
?>
	<tr>
	<td><?php do_html_link_profile($user['uid']) ?> </td>
	<td><?php echo "<a href=delete_user.php?uid=".$user['uid'].">删除</a>"; ?></td>
	</tr>
<?php
		}
?>
	</table>
	</div>
<?php
	}
}


function show_notices($notice_array) {
?>
	<div class="content">
<?php
if (is_array($notice_array) && count($notice_array) > 0) {
	foreach (array_reverse($notice_array) as $notice) {
		$pid = $notice['pid'];
?>
	<p>
		<?php do_html_link_profile($notice['fid']) ?>
		<?php echo $notice['isread']=='N'?"评论了你的文章":"赞了你的文章"; ?>
		<a href="viewarticle.php?pid=<?php echo $pid ?>"><?php echo get_article_title($pid) ?></a>
		<?php echo $notice['ptime'] ?>
	</p>
<?php
	}
} else {
	echo "No such Notice found.";
}
?>
	</div>
<?php
}

function display_article_detail($article) {
?>
	<div class='content'>
		<h1 align='center'>
			<?php echo nl2br($article['title']) ?>
		</h1><br/>
		<h3 align='right'>
			<?php do_html_link_profile($article['uid']); echo " ".$article['ptime']; ?>
		</h3>
		<p>
			<?php echo nl2br($article['content']); ?>
		</p><br/>
		<p align='right'>
<?php
	if (isset($_SESSION['isadmin']) && $_SESSION['isadmin']=='Y') {
		echo "<a href=delete_user.php?uid=".$article['pid'].">删除</a>&nbsp;";
	}
?>
			<a href="praisehandler.php?<?php echo 'action='; echo praise_uid_pid($_SESSION['uid'], $article['pid'])?'delete':'create'; echo '&'.'pid='.$article['pid']; ?>">
				<?php echo praise_uid_pid($_SESSION['uid'], $article['pid'])?'取消':'赞'; echo '['.count(get_praise_with_pid($article['pid'])).']'?>
			</a>
			&nbsp;
			<a href="viewarticle.php?cid=0&pid=<?php echo $article['pid']; ?>#reply">
				Reply
			</a>
		</p>
	</div>
<?php
}

function display_reply_form($floor, $pid) {
?>
	<a NAME='reply'></a>
	<div class='content'>
	<?php echo "<form method='post' action='viewarticle.php?pid=".$pid."'>" ?>
	<p>Comment:</p>
	<?php echo "<textarea name='reply' rows='3' style='width:50%'>Reply #$floor: </textarea>" ?>
	<p><input type='submit' value='Post'/></p>
	</form>
	</div>
<?php
}
function display_all_reply($cid, $pid, $comment_array) {
	$floor = 1;
	if (is_array($comment_array)) {
		foreach($comment_array as $comment) {
			echo "<div class='content'>";
			echo "<b>#".$floor." ";
			do_html_link_profile($comment['uid']);
			echo " ".$comment['ptime']."</b></br>";
			echo "<p>".nl2br($comment['content'])."</p>";
			if (isset($_SESSION['isadmin']) && $_SESSION['isadmin']=='Y') {
				echo "<p align='right'><a href=delete_comment?cid=".$comment['cid']."&&pid=$pid>删除"."</a>";
				echo "&nbsp<a href=viewarticle.php?cid=".$comment['cid']."&pid=".$pid."#reply>Reply</a></p>";
			} else {
				echo "<p align='right'><a href=viewarticle.php?cid=".$comment['cid']."&&pid=".$pid."#reply>Reply</a></p>";
			}
			echo "</div>";
			if ($comment['cid'] == $cid) {
				display_reply_form($floor, $pid);
			}
			$floor ++;
		}
	}
}
function username() {
	return "用户名";
}
function home() {
	return "Home";
}
function click_to_register() {
	return "注册";
}
?>
