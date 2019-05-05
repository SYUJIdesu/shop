<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['member_login'])==false)
{

	print 'ようこそゲスト様<br>';
	print '<a href="member_login.html">会員ログイン画面</a><br>';

} else {

	print "ようこそ{$_SESSION['name']}様";
	print '<a href="member_logout.html">ログアウト</a>';
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

		if(isset($_SESSION['cart'])==true)
		{
			$cart = $_SESSION['cart'];
			$kazu = $_SESSION['kazu'];
			$max = count($cart);
		}
		else 
		{
			$max = 0;
		}
		
		if($max==0)
		{
			print 'カートに商品は入っていません<br>';
			print '<a href="shop_list.php">商品一覧に戻る</a>';
			exit();
		}


		foreach($cart as $key => $val)
		{

			$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
			$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$sql = 'SELECT id, name, price, gazou FROM mst_product WHERE id = ?';
			$stmt = $dbh->prepare($sql);
			$data[0] = $val;
			$stmt->execute($data);

			$result = $stmt->fetch(PDO::FETCH_ASSOC);

			$pro_name[] = $result['name'];
			$pro_price[] = $result['price'];

			if($result['gazou']=='')
			{
				$pro_gazou[] = '';
			}
			else
			{
				$pro_gazou[] = '<img src="../pro/gazou/'.$result['gazou'].'">';
			}

		}

		$dbh = null;

		} catch(Exception $e){

			print 'エラー発生' . htmlspecialchars($e->getMessage,ENT_QUOTES,'UTF-8');
			exit();

		}
	?>

	カートの中身<br>
	<br>
	<form method="post" action="kazu_change.php">
	<table border="1">
	<tr>
	<td>商品</td>
	<td>商品画像</td>
	<td>価格</td>
	<td>数量</td>
	<td>小計</td>
	<td>削除</td>
	</tr>
	<?php 
	 for($i=0;$i<$max;$i++)
		{
	?>
	<tr>
			<td><?php print $pro_name[$i]; ?></td>
			<td><?php print $pro_gazou[$i]; ?></td>
			<td><?php print $pro_price[$i]; ?>円<br></td>
			<td><input type="text" name="kazu<?php print $i; ?>" value="<?php print $kazu[$i]; ?>"></td>
			<td><?php print $pro_price[$i]*$kazu[$i]; ?>円</td>
			<td><input type="checkbox" name="sakujo<?php print $i; ?>" ></td>
			<br><br>
	</tr>
	<?php 
		}
	?>
	</table>
	
		<input type="hidden" name="max" value="<?php print $max; ?>">
		<input type="submit" value="数量変更"><br>
		<button><a href="shop_list.php">back</a></button>
		<br>
		<a href="shop_form.html">ご購入手続きへ進む</a>
	</form>

	<?php
		if(isset($_SESSION['member_login']))
		{
			print'<a href="shop_kantan_check.php">会員簡単注文へ進む</a><br>';
		}
	?>
	</body>
</html>