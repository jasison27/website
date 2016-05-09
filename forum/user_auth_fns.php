<?php
function register($uid, $passwd) {
	// register new person with db
	// return true or error message
	// connect to db
	$conn = db_connect();
	$result = $conn->query("select * from user");
	if (!$result) {
		throw new Exception('Error to Query');
	}
	$isadmin = 'N';
	if ($result->num_rows == 0) {
		$isadmin = 'Y';
	}
	// check if username is unique
	$result = $conn->query("select * from user where uid = '" . $uid . "'");
	if (!$result) {
		throw new Exception('Error to Query');
	}
	check_username_valid($uid);
	check_passwd_valid($passwd);
	if ($result->num_rows > 0) {
		throw new Exception('Username already used');
	}
	// if okay, put in db
	$query = "insert into user values ('".$uid."', sha1('".$passwd."'),'".$isadmin."')";
	$reslut = $conn->query($query);
	if (!$result) {
		throw new Exeception('Error to Register');
	}
	$result = $conn->query("insert into profile values('".$uid."', null, null, null)");
	return 'N';
}

function login($uid, $passwd) {
	// check email and password with db
	// return true if yes, throw exception otherwise

	// connect to db
	$conn = db_connect();
	// check if email is unique
	$result = $conn->query("select * from user
		where uid = '".$uid."' and passwd = sha1('".$passwd."')");
	if ($result && $result->num_rows > 0) {
		return $result->fetch_object()->isadmin;
	} else {
		throw new Exception('Login Failed');
	}
}

function filled_out($form_vars) {
	// test that each variables has a value
	foreach ($form_vars as $key => $value) {
		if (!isset($key) || ($value == '')) {
			return false;
		}
	}
	return true;
}

function valid_email($address) {
	// check an email address is possibly valid
	if (preg_match("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$^", $address)) {
		return true;
	} else {
		return false;
	}
}

function check_username_valid($uid) {
	if ($uid == '' || !$uid) {
		throw new Exception("username empty");
	}
	$len = strlen($uid);
	for ( $i = 0; $i < $len; $i ++ ) {
		$c = $uid[$i];
		if ( (!($c>='a'&&$c<='z')) && (!($c>='A'&&$c<='Z')) && (!($c>='0'&&$c<='9')) ) {
			throw new Exception("You can only characters and digits as user name");
		}
	}
}
function check_passwd_valid($passwd) {
	if ($passwd == '' || !$passwd) {
		throw new Exception("password empty.");
	}
}
function deldir($dir) {
  $dh=opendir($dir);
  while ($file=readdir($dh)) {
    if($file!="." && $file!="..") {
      $fullpath=$dir."/".$file;
      if(!is_dir($fullpath)) {
          unlink($fullpath);
      } else {
          deldir($fullpath);
      }
    }
  }
 
  closedir($dh);
  if(rmdir($dir)) {
    return true;
  } else {
    return false;
  }
}
?>
