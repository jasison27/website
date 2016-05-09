<?php
require_once ('include_fns.php');
session_start();
ob_start();
?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="img/logo.png">
	<title>League of Class - Signin</title>
	<link href="./dist/css/bootstrap.css" rel="stylesheet">
	<link href="./dist/css/signin.css" rel="stylesheet">
	<link href="./dist/css/doc.css" rel="stylesheet">
	<link href="./dist/css/github.min.css" rel="stylesheet">
</head>
<?php
if (!isset($_POST['realname']) || !isset($_POST['password']) || !isset($_POST['stuid']) || !isset($_POST['password2']) || !isset($_POST['email'])) {
	unset($_SESSION['email']);
	unset($_SESSION['realname']);
	unset($_SESSION['stuid']);
	session_destroy();
	?>
	<body>
		<div class="container">
			<form class="form-signin" role="form" method="post" action="register.php">
				<h2 class="form-signin-heading">注册</h2>
			</br>
			<div class ="form-group">
				<label for="exampleInputName">真实姓名</label>
				<input type="text" class="form-control" id="name" name="realname" placeholder="方便管理员确认身份">
			</div>
			<div class ="form-group">
				<label for="exampleInputEmail1">学号</label>
				<input type="text" class="form-control" id="email" name="stuid" placeholder="方便管理员确认身份">
			</div>
			<div class ="form-group">
				<label for="exampleInputEmail1">邮箱</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="邮箱">
			</div>
			<div class ="form-group">
				<label for="exampleInputPassw">密码</label>
				<input type="password" name="password" class="form-control" id="passwd" placeholder="密码">
			</div>
			<div class ="form-group">
				<label for="exampleInputRePassw"> 请重复密码</label>
				<input type="password" name="password2" class="form-control" id="repasswd" placeholder="请输入确认密码">
			</div>
		</br>
		<button class="btn btn-lg btn-primary btn-block" type="submit" id="login" onClick="fun();">注册</button>
	</form>
</div><!-- /container -->
</body>
<?php
} else {
	try {
		if (safePost('password') != safePost('password2')) {
			throw new Exception('Password repeated not same!');
		}
		register(safePost('realname'), safePost('password'), safePost('email'), safePost('stuid'), get_server_date());
		send_email(safePost('email'), "班级联盟：恭喜你注册成功（无需回复）", "欢迎加入班级联盟，在这里，你可以：\n1.创建你的班级\n2.加入你的班级\n3.在班级内发通知、共享资源等！");
		$_SESSION['email'] = safePost('email');
		$_SESSION['realname'] = safePost('realname');
		$_SESSION['stuid'] = safePost('stuid');
		ob_end_clean();
		header("Location: index.php");
		exit;
	} catch (Exception $e) {
		middlepage("register.php",$e->getMessage());
		echo $e->getMessage();
	}
}
?>
</html>
