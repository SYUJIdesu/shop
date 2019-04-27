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

	try{
		require_once '/Applications/MAMP/db_config.php';

		$staff_id = $_POST['id'];
		$staff_name = $_POST['name'];
		$staff_pass = $_POST['pass'];

		$staff_name = htmlspecialchars($staff_name,ENT_QUOTES,'UTF-8');
		$staff_pass = htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

		$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = 'UPDATE mst_staff SET name=?, password=? WHERE id=?';
		$stmt = $dbh->prepare($sql);
		$data[] = $staff_name;
		$data[] = $staff_pass;
		$data[] = $staff_id;
		$stmt->execute($data);

		$dbh = null;
		
	} catch(Exception $e) {
		echo "エラー発生" . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
		exit();
	}
	?>

	修正しました。<br>

	<br>
	<a href="staff_list.php">戻る</a>

	</body>
</html>