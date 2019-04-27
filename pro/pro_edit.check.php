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

	$pro_id = $_POST['id'];
	$pro_name = $_POST['name'];
	$pro_price = $_POST['price']; 

	$pro_id = htmlspecialchars($pro_id, ENT_QUOTES,'UTF-8');
	$pro_name = htmlspecialchars($pro_name,ENT_QUOTES,'UTF-8');
	$pro_price = htmlspecialchars($pro_price,ENT_QUOTES,'UTF-8');

	if($pro_name=='')
	{
		print '商品名が入力されてません<br>';
	}
	else
	{
		print "商品名<br>{$pro_name}<br>";
	}

	if(preg_match('/[0-9]/', $pro_price)==0)
	{
		print '価格をきちんと入力してください';
	} else {
		print "価格{$pro_price}円<br>";
	}

	if($pro_name==''||preg_match('/[0-9]/', $pro_price)==0)
	{
		print '<form>';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '</form>';
	}
	else
	{
		print '上記のように変更しますか？';
		print '<form method="post" action="pro_edit_done.php">';
		print '<input type="hidden name="id" value="'.$pro_id.'">';
		print '<input type="hidden" name="name" value="'.$pro_name.'">';
		print '<input type="hidden" name="price" value="'.$pro_price.'">';
		print '<br>';
		print '<input type="button" onclick="history.back()" value="戻る">';
		print '<input type="submit" value="OK">';
		print '</form>';

	}
	?>
	</body>
</html>