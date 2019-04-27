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
		$sql = 'SELECT name, price,gazou FROM mst_product where id = ?';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_id;
		$stmt->execute($data);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);
		$pro_name = $result['name'];
		$pro_price = $result['price'];
		$pro_gazou_name_old = $result['gazou'];

		$dbh = null;

		if($pro_gazou_name_old=='')
		{

			$disp_gazou = '';
		} else {

			$disp_gazou = '<img src="./gazou/'.$pro_gazou_name_old.'">';

		}

		} catch(Exception $e){
			print 'エラー発生' . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
			exit();
		}
	?>

	商品修正<br>
	<br>
	商品ID<br>
	<?php print $pro_id; ?>
	<br>
	<br>
	<form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php print $pro_id; ?>">
		<input type="hidden" name="pro_gazou_name_old" value="<?php print $pro_gazou_name_old; ?>">
		商品名<br>
		<input type="text" name="name" value="<?php print $pro_name; ?>" style=width:200px><br>
		価格<br>
		<input type="text" name="price" value="<?php print $pro_price?>" style="width:100px"><br>
		<?php print $disp_gazou; ?>
		<input type="file" name="gazou" style="width: 400px"><br>
		<input type="button" onclick="history.back()" value="戻る">
		<input type="submit" value="送信">
	</form>
	</body>
</html>