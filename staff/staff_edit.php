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
	<?php

	require_once '/Applications/MAMP/db_config.php';

	try {

		$staff_id = (int) $_GET['id'];

		$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT name FROM mst_staff where id = ?';
		$stmt = $dbh->prepare($sql);
		$data[] = $staff_id;
		$stmt->execute($data);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$staff_name = $result['name'];

		$dbh = null;
		} catch(Exception $e){
			print 'エラー発生' . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
			exit();
		}
	?>

	スタッフ修正<br>
	<br>
	スタッフID<br>
	<?php print $staff_id; ?>
	<br>
	<br>
	<form method="post" action="staff_edit_check.php">
		<input type="hidden" name="id" value="<?php print $staff_id; ?>">
		スタッフ名<br>
		<input type="text" name="name" value="<?php print $staff_name; ?>" style=width:200px><br>
		パスワードを入力してください<br>
		<input type="password" name="pass" style="width:100px" required><br>
		パスワードをもう一度入力してください<br>
		<input type="password" name="pass2" style="width:100px" required><br>
		<input type="button" onclick="history.back()" value="戻る">
		<input type="submit" value="送信">
	</form>
	</body>
</html>