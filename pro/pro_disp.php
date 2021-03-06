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

		$pro_id = (int) $_GET['id'];

		$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = 'SELECT name,price,gazou FROM mst_product where id = ?';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_id;
		$stmt->execute($data);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$pro_name = $result['name'];
		$pro_price = $result['price'];
		$pro_gazou_name = $result['gazou'];//カラム名

		$dbh = null;

		if($pro_gazou_name=='')
		{

			$disp_gazou = '';

		} else {

			$disp_gazou = '<img src="./gazou/'.$pro_gazou_name.'">';
		}

		} catch(Exception $e){

			print 'エラー発生' . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
			exit();

		}
	?>

	商品情報参照<br>
	<br>
	商品コード<br>
	<?php print $pro_id; ?>
	<br>
	スタッフ名<br>
	<?php print $pro_name; ?>
	<br>
	価格<br>
	<?php print $pro_price; ?>
	円<br>
	<?php print $disp_gazou; ?>
	<br>
	<form method="post">
		<input type="button" onclick="history.back()" value="戻る">
	</form>
	</body>
</html>