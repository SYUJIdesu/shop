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

	try {
		require_once '/Applications/MAMP/db_config.php';
		$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


		$sql = 'SELECT id, name FROM mst_staff WHERE 1';//1は全部
		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		$dbh = null;

		print 'スタッフ一覧<br><br>';

		print '<form method="post" action="staff_branch.php">';
		while(true) {
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if($result==false) {
				break;
			}
			print '<input type="radio" name="id" value="'.$result['id'].'">';
			print $result['name'];
			print '<br>';
		}
		print '<input type="submit" name="disp" value="参照">';
		print '<input type="submit" name="add" value="追加">';
		print	'<input type="submit" name="edit" value="修正">';
		print '<input type="submit" name="delete" value="削除">';
		print '</form>';
	} catch(Exception $e) {
		print 'エラー発生' . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
		exit();
	}
	?>

	<br>
	<a href="../login/staff_top.php">トップメニューへ</a>
	</body>
</html>