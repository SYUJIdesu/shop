<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['login'])==false)
{

	print 'ログインされてません<br>';
	print '<a href="../login/staff_login.html">ログイン画面へ</a><br>';
	exit();

} else {

	print $_SESSION['name'];
	print 'さんログイン中';
	print '<br>';
}
?>

<!DOCTYPE html>
<html>
	<head>
		<meat charset="UTF-8">
		<title>農園</title>
	</head>
	<body>
		
		スタッフ追加<br>
		<br>
		<form method="post" action="staff_add_check.php">
			スタッフ名を入力してください<br>
			<input type="text" name="name" style="width: 200px"><br>
			パスワードを入力してください<br>
			<input type="password" name="pass" style="width: 100px"><br>
			パスワードをもう一度入力してください<br>
			<input type="password" name="pass2" style="width: 100px"><br>
			<br>
			<input type="button" onclick="history.back()" value="戻る">
			<input type="submit" value="OK">
		</form>
	</body>
</html>