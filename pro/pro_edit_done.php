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

		$pro_id = $_POST['id'];
		$pro_name = $_POST['name'];
		$pro_price = $_POST['price'];
		$pro_name_gazou_old = $_POST['gazou_name_old'];
		$pro_gazoun_name = $_POST['gazou_name'];


		$pro_id = htmlspecialchars($pro_id, ENT_QUOTES,'UTF-8');
		$pro_name = htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
		$pro_price = htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

		$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql = 'UPDATE mst_product SET name = ?, price = ?, gazou = ? WHERE id = ?';
		$stmt = $dbh->prepare($sql);
		$data[] = $pro_name;
		$data[] = $pro_price;
		$data[] = $pro_gazoun_name;
		$data[] = $pro_id;
		$stmt->execute($data);

		$dbh = null;

		if($pro_name_gazou_old!=$pro_gazoun_name)
		{
			if($pro_name_gazou_old!='')
			{

				unlink('./gazou/'.$pro_name_gazou_old);

			}
		}
		
		echo "修正しました<br>";
	} catch(Exception $e) {
		echo "エラー発生" . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
		exit();
	}	
	
	?>

	<br>
	<a href="pro_list.php">戻る</a>

	</body>
</html>