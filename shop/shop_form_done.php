<?php

session_start();
session_regenerate_id(true);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>農園</title>
	</head>
	<body>

	<?php

	try {
	require_once '/Applications/MAMP/db_config.php';
	require_once('../common/common.php');

	$post = sanitize($_POST);

	$name = $post['name'];
	$email = $post['email'];
	$postal1 = $post['postal1'];
	$postal2 = $post['postal2'];
	$address = $post['address'];
	$tel = $post['tel'];
	$chumon = $post['chumon'];
	$user_pass = $post['pass'];
	$danjo = $post['danjo'];
	$birth = $post['birth'];

	print "{$name}様<br>";
	print "ご注文ありがとうございました。<br>";
	print "{$email}にメールを送りましたのでご確認ください<br><br>";
	print '商品は以下の住所に発送させていただきます。<br>';
	print "{$postal1}-{$postal2}<br>";
	print "{$address}<br>";
	print "{$tel}<br>";

	$honbun = '';
	$honbun .= "{$name}様\nこの度はご購入ありがとうございます。\n";
	$honbun .= "\n";
	$honbun .= "ご注文商品\n";
	$honbun .= "------------\n";
	
	$cart = $_SESSION['cart'];
	$kazu = $_SESSION['kazu'];
	$max = count($cart);

	
	for($i=0;$i<$max;$i++)
	{
		$dbh=new PDO('mysql:dbname=shop;host=localhost;port=3306;charset=utf8',$user,$pass);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$sql='SELECT name,price FROM mst_product WHERE id=?';
		$stmt=$dbh->prepare($sql);
		$data[0]=$cart[$i];
		$stmt->execute($data);

		$result = $stmt->fetch(PDO::FETCH_ASSOC);

		$name = $result['name'];
		$price = $result['price'];
		$kakaku[] = $price;
		$suryo = $kazu[$i];
		$syokei = $price * $suryo;

		$honbun .= $name.'';
		$honbun .= $price.'円×';
		$honbun .= $suryo.'個=';
		$honbun .= $syokei."円\n";

		$name=$result['name'];
		$price = $result['price'];
		$kakaku[] = $price;
		
		/*$sql = 'LOCK TABLES dat_sales WRITE, dat_sales_product WRITE,dat_member WRITE';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();*/

		$lastmemberid = 0;
		if($chumon=='chumontouroku')
		{
			$sql='INSERT INTO dat_member(password,name,email,postal1,postal2,address,tel,danjo,born) VALUES(?,?,?,?,?,?,?,?,?)';
			$stmt = $dbh->prepare($sql);
			$data = array();
			$data[] = md5($user_pass);
			$data[]=$name;
			$data[]=$email;
			$data[]=$postal1;
			$data[]=$postal2;
			$data[]=$address;
			$data[]=$tel;
			if($danjo=='dan')
			{
				$data[]=1;
			}else{
				$data[]=2;
			}
			$data[]=$birth;

			$stmt->execute($data);

			$sql = 'SELECT LAST_INSERT_ID()';
			$stmt=$dbh->prepare($sql);
			$stmt->execute();
			$rec=$stmt->fetch(PDO::FETCH_ASSOC);
			$lastmemberid=$rec['LAST_INSERT_ID()'];


		}

		$sql='INSERT INTO dat_sales (id_member,name,email,postal1,postal2,address,tel) VALUES (?,?,?,?,?,?,?)';
		$stmt=$dbh->prepare($sql);
		$data=array();
		$data[]=$lastmemberid;
		$data[]=$name;
		$data[]=$email;
		$data[]=$postal1;
		$data[]=$postal2;
		$data[]=$address;
		$data[]=$tel;
		$stmt->execute($data);

		$sql='SELECT LAST_INSERT_ID()';
		$stmt=$dbh->prepare($sql);
		$stmt->execute();
		$rec=$stmt->fetch(PDO::FETCH_ASSOC);
		$lastid=$rec['LAST_INSERT_ID()'];

		for($i=0;$i<$max;$i++)
		{
			$sql='INSERT INTO dat_sales_product (id_sales,id_product,price,quantity) VALUES (?,?,?,?)';
			$stmt=$dbh->prepare($sql);
			$data=array();
			$data[]=$lastid;
			$data[]=$cart[$i];
			$data[]=$kakaku[$i];
			$data[]=$kazu[$i];
			$stmt->execute($data);
		}
	}

		/*$sql = 'UNLOCK TABLES';
		$stmt = $dbh->prepare($sql);
		$stmt->execute();*/


		$dbh = null;


		if($chumon=='chumontouroku')
		{
			print '会員登録が完了いたしました。<br />';
			print '次回からメールアドレスとパスワードでログインしてください。<br />';
			print 'ご注文が簡単にできるようになります。<br />';
			print '<br />';
		}

		$honbun .= "送料は無料です\n";
		$honbun .= "-------------\n";
		$honbun .= "\n";
		$honbun .= "代金は以下の口座にお振り込みください\n";
		$honbun .= "ロクマル銀行　野菜支店　普通口座　発送させていただきます。\n";
		$honbun .= "入金確認が取れ次第、発送させていただきます。\n";
		$honbun .= "\n";
		$honbun .= "□□□□□□□□□□□□□□□□\n";
		$honbun .= "~安心野菜のロクマル農園~\n";
		$honbun .= "\n";
		$honbun .= "〇〇県〇〇市\n";
		$honbun .= "電話番号 〇〇\n";
		$honbun .= "メール 〇〇\n";
		$honbun .= "□□□□□□□□□□□□□□□□\n";

		if($chumon=='chumontouroku')
		{
			$honbun.="会員登録が完了いたしました。\n";
			$honbun.="次回からメールアドレスとパスワードでログインしてください。\n";
			$honbun.="ご注文が簡単にできるようになります。\n";
			$honbun.="\n";
		}
		//print '<br>';
		//print nl2br($honbun);

		$title ='ご注文ありがとうございます';
		$header = 'FROM: info@rokumarunouen.co.jp';
		$honbun = html_entity_decode($honbun, ENT_QUOTES, 'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail($email,$title,$honbun,$header);

		$title = "あ客様からご注文がありました";
		$header = 'FROM:' .$email;
		$honbun = html_entity_decode($honbun,ENT_QUOTES,'UTF-8');
		mb_language('Japanese');
		mb_internal_encoding('UTF-8');
		mb_send_mail('info@rokumarunouen.co.jp', $title,$honbun,$header);


	} catch (EXCEPTION $e) {
		
		print 'エラー'. $e->getMessage();
	}

	?>

	<br>
	<a href="shop_list.php">商品画面へ</a>
	</body>
</html>