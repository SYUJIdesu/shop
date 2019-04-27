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
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<title>農園</title>
	</head>
	<body>
		ショップ管理トップメニュー<br>
		<br>
		<a href="../staff/staff_list.php">スタッフ管理</a>
		<br>
		<a href="../pro/pro_list.php">商品管理</a>
		<br>
		<a href="logout.php">ログアウト</a>
	</body>
</html>