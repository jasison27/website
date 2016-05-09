<?php
// connect to database, return the connection object
function db_connect() {
	$result = new mysqli('localhost', 'root', '', 'forum');
	if (!$result) {
		throw new Exception('Error to Connect to DB');
	} else {
		return $result;
	}
}
// new visitor
function new_visitor($uid, $ptime) {
	$conn = db_connect();
	$query = "insert into visitor values(null,'".$uid."','".$ptime."')";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Create Visitor Error.');
	}
	return true;
}
// get all visitors
function get_all_visitor() {
	$conn = db_connect();
	$query = "select * from visitor";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Error to get visitors');
	}
	$visitor_array = array();
	for ($i = 0; $i < $result->num_rows; ++ $i) {
		$visitor_array[$i] = $result->fetch_assoc();
	}
	return $visitor_array;
}
// get all user
function get_all_user() {
	$conn = db_connect();
	$query = "select * from user";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Error to get users');
	}
	$user_array = array();
	for ($i = 0; $i < $result->num_rows; ++ $i) {
		$user_array[$i] = $result->fetch_assoc();
	}
	return $user_array;
}
// get profile of a user with uid
function get_user_profile($uid) {
	$conn = db_connect();
	$query = "select * from profile where uid='" . $uid . "'";
	$result = @$conn->query($query);
	if (!$result) {
		throw new Exception('DB Error.');
	}
	$result = @$result->fetch_assoc();
	if (!is_array($result)) {
		throw new Exception('Error to catch user profile.');
	}
	return $result;
}
// update profile of a user
function update_user_profile($uid, $realname, $contact, $signature) {
	$conn = db_connect();
	$query = "update profile set realname='".$realname."', contact='".$contact."', signature='".$signature."' where uid='".$uid."'";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('update profile error.');
	}
	return true;
}
// get all articles, whoever post it
function get_all_article() {
	$conn = db_connect();
	$result = $conn->query("select * from article");
	if ($result) {
		$article_array = array();
		for ($i = 0; $i < $result->num_rows; ++ $i) {
			$row = $result->fetch_assoc();
			$article_array[$i] = $row;
		}
		return $article_array;
	} else {
		throw new Exception('Error to catch articles.');
	}
}
// get articles posted by certain person(uid)
function get_articles_with_uid($uid) {
	$conn = db_connect();
	$result = $conn->query("select * from article where uid='".$uid."'");
	if ($result) {
		$article_array = array();
		for ($i = 0; $i < $result->num_rows; ++ $i) {
			$row = $result->fetch_assoc();
			$article_array[$i] = $row;
		}
		return $article_array;
	} else {
		throw new Exception('Error to catch articles.');
	}
}
// post article with uid, title, content, ptime. pid auto increased
function post_article($uid, $title, $content, $ptime) {
	$conn = db_connect();
	$result = $conn->query("insert into article values (null,'".$uid."','".$ptime."','".$title."','".$content."')");
	if (!$result) {
		throw new Exception('The title is too long.');
	} else {
		return true;
	}
}
// get article details with pid
function get_article_details($pid) {
	if (!$pid || $pid=='') {
		throw new Exception('Error to view this article.');
	}
	$conn = db_connect();
	$query = "select * from article where pid='" . $pid . "'";
	$result = @$conn->query($query);
	if (!$result) {
		throw new Exception('Error to view this article.');
	}
	$result = @$result->fetch_assoc();
	if (!is_array($result)) {
		throw new Exception('Error to view this article.');
	}
	return $result;
}
// get article title with pid
function get_article_title($pid) {
	$article = get_article_details($pid);
	return $article['title'];
}
// get server time
function get_server_time() {
	$conn = db_connect();
	$result = $conn->query("select now()");
	if ($result) {
		$row = $result->fetch_assoc();
		foreach($row as $date) {
		}
	}
	return $date;
}
// post comment with pid, uid, ptime, content. cid auto increased
function post_comment($pid, $uid, $ptime, $content) {
	$conn = db_connect();
	$result = @$conn->query("insert into comment values (null, '".$pid."','".$uid."','".$ptime."','".$content."')");
	if (!$result) {
		throw new Exception('Error to Post comment.');
	} else {
		return true;
	}
}
// get comments that's follow a certain article(pid to get)
function get_all_comments($pid) {
	$conn = db_connect();
	$result = @$conn->query("select * from comment where pid='" . $pid . "'");
	if (!$result) {
		throw new Exception('Error to get comments');
	}
	$comment_array = array();
	for ($i = 0; $i < $result->num_rows; ++ $i) {
		$row = $result->fetch_assoc();
		$comment_array[$i] = $row;
	}
	return $comment_array;
}
// post a notice with uid, pid, time, isread. cnid auto increased.
// N-reply NP-praise
function post_notice($uid, $pid, $ptime, $isread) {
	$conn = db_connect();
	$result = @$conn->query("insert into cnotice values (null, '".$uid."','".$pid."','".$ptime."','".$isread."')");
	if (!$result) {
		throw new Exception('Error to Post notice.');
	} else {
		return true;
	}
}
// get unread notice number with uid.
function get_unread_notice_number_with_uid($uid) {
	$conn = db_connect();
	// select * from cnotice where isread = 'N' and pid in ( select pid from article where uid = '江山' )
	$result = @$conn->query("select count(*) from cnotice where (isread='N' or isread='NP') and pid in ( select pid from article where uid='".$uid."')");
	if (!$result) {
		throw new Exception('Error to count notices.');
	}
	$row = $result->fetch_assoc();
	foreach($row as $number) {
	}
	return $number;
}
// get unread notices with uid
function get_all_unread_notice_with_uid($uid) {
	$conn = db_connect();
	$result = @$conn->query("select * from cnotice where (isread='N' or isread='NP') and pid in ( select pid from article where uid='".$uid."')");
	if (!$result) {
		throw new Exception('Error to get notices.');
	}
	$notice_array = array();
	for ($i = 0; $i < $result->num_rows; ++ $i) {
		$row = $result->fetch_assoc();
		$notice_array[$i] = $row;
	}
	return $notice_array;
}
// get uid with pid
function get_uid_with_pid($pid) {
	$article = get_article_details($pid);
	return $article['uid'];
}
// set notice with pid isread='Y'
function read_notice_with_pid($pid) {
	$conn = db_connect();
	$result = $conn->query("update cnotice set isread='Y' where pid='".$pid."'");
	if (!$result) {
		throw new Exception('Error to set notice readed.');
	} else {
		return true;
	}
}
// return if user with uid has praised article with pid
function praise_uid_pid($uid, $pid) {
	$conn = db_connect();
	$query = "select * from praise where uid='".$uid."' and pid='".$pid."'";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Error to Praise.');
	}
	if ($result->num_rows == 0) {
		return false;
	} else if ($result->num_rows == 1) {
		return true;
	} else {
		throw new Exception('Praise Database Error.');
	}
}
function praise_create_uid_pid($uid, $pid) {
	$conn = db_connect();
	$query = "insert into praise values('".$uid."', '".$pid."')";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Error to praise');
	} else {
		return true;
	}
}
function praise_delete_uid_pid($uid, $pid) {
	$conn = db_connect();
	$query = "delete from praise where uid='".$uid."' and pid='".$pid."'";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Error to cancel praise.');
	} else {
		return true;
	}
}
function delete_article($pid) {
	$conn = db_connect();
	$query = "delete from article where pid='".$pid."'";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Error to delete article.');
	} else {
		return true;
	}
}
function delete_comment($cid) {
	$conn = db_connect();
	$query = "delete from comment where cid='".$cid."'";
	$result = $conn->query($query);
	if (!$result) {
		throw new Exception('Error to delete comment.');
	} else {
		return true;
	}
}
function delete_user_all_things($uid) {
	$conn = db_connect();
		// delete from user
		$query = "delete from user where uid='".$uid."'";
		$result = $conn->query($query);
		if (!$result) {
			throw new Exception('Error to delete user.');
		}
		// delete from profile
		$query = "delete from profile where uid='".$uid."'";
		$result = $conn->query($query);
		if (!$result) {
			throw new Exception('Error to delete user.');
		}
		// delete from article
		$query = "delete from article where uid='".$uid."'";
		$result = $conn->query($query);
		if (!$result) {
			throw new Exception('Error to delete user.');
		}
		// delete from comment
		$query = "delete from comment where uid='".$uid."'";
		$result = $conn->query($query);
		if (!$result) {
			throw new Exception('Error to delete user.');
		}
		// delete from praise
		$query = "delete from praise where uid='".$uid."'";
		$result = $conn->query($query);
		if (!$result) {
			throw new Exception('Error to delete user.');
		}
		// delete from visitor
		$query = "delete from visitor where uid='".$uid."'";
		$result = $conn->query($query);
		if (!$result) {
			throw new Exception('Error to delete user.');
		}
	return true;
}
function get_praise_with_pid($pid) {
	$conn = db_connect();
	$query = "select * from praise where pid='".$pid."'";
	$result = $conn->query($query);
	$praise_array = array();
	for ($i = 0; $i < $result->num_rows; ++ $i) {
		$row = $result->fetch_assoc();
		$praise_array[$i] = $row;
	}
	return $praise_array;
}
function get_praise_with_uid($uid) {
	$conn = db_connect();
	$query = "select * from praise where uid='".$uid."'";
	$result = $conn->query($query);
	$praise_array = array();
	for ($i = 0; $i < $result->num_rows; ++ $i) {
		$row = $result->fetch_assoc();
		$praise_array[$i] = $row;
	}
	return $praise_array;
}
// get all message with toid
function get_message_with_toid($toid) {
	$conn = db_connect();
	$query = "select * from message where toid='".$toid;
	if ($toid == $_SESSION['uid']) {
		$query = $query."'";
	} else {
		$query = $query."' and isprivate = 'N'";
	}
	$result = $conn->query($query);
	$message_array = array();
	for ($i = 0; $i < $result->num_rows; ++ $i) {
		$message_array[$i] =  $result->fetch_assoc();
	}
	return $message_array;
}
// post a message with toid, isprivate, content, ptime
?>
