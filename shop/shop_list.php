<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['member_login'])==false)
{

	print 'ようこそゲスト様<br>';
	print '<a href="member_login.html">会員ログイン</a><br>';

} else {

	print "ようこそ{$_SESSION['member_name']}様";
	print '<a href="member_logout.php">ログアウト</a>';
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


		$sql = 'SELECT id, name, price FROM mst_product WHERE 1';//1は全部
		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		$dbh = null;

		print '商品一覧<br><br>';

		while(true) 
		{
			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			if($result==false) 
			{
				break;
			}

			print '<a href="shop_product.php?id='.$result['id'].'">';
			print $result['name'].'---';
			print $result['price'].'円';
			print '</a>';
			print '<br>';

		}

		print '<br>';
		print '<a href="shop_cartlook.php">カートを見る</a>';

	} catch(Exception $e) {
		print 'エラー発生' . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
		exit();
	}
	?>

	</body>
</html>