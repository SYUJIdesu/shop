<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['member_login'])==false)
{

	print 'ようこそゲスト様<br>';
	print '<a href="member_login.html">会員ログイン画面</a><br><br>';

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

		$pro_id =  $_GET['id'];

		if(isset($_SESSION['cart'])==true)
		{

		$cart = $_SESSION['cart'];
		$kazu = $_SESSION['kazu'];
			if(in_array($pro_id, $cart)==true)
			{
				print 'その商品はもう入ってます。<br>';
				print '<a href="shop_list.php">商品一覧に戻る</a>';
				exit();
			}

		}

		$cart[] = $pro_id;
		$kazu[] = 1;
		$_SESSION['cart'] = $cart;
		$_SESSION['kazu'] = $kazu;


	?>

	カートに追加しました<br><br>
	<a href="shop_list.php">商品一覧に戻る</a>
	</body>
</html>