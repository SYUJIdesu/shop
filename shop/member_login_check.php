<?php
		
try {

	require_once '/Applications/MAMP/db_config.php';

	$member_email = $_POST['email'];
	$member_pass = $_POST['pass'];

	$member_id = htmlspecialchars($member_email,ENT_QUOTES,'UTF-8');
	$member_pass = htmlspecialchars($member_pass,ENT_QUOTES,'UTF-8');

	$member_pass = md5($member_pass);

	$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT id,name FROM dat_member WHERE email = ? AND password = ?';
	$stmt = $dbh->prepare($sql);
	$data = array();
	$data[] = $member_email;
	$data[] = $member_pass;
	$stmt->execute($data);

	$dbh = null;

	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	var_dump($result);
	var_dump($$data);

	if($result==false)
	{

		print 'アドレスかパスワードが間違ってます。';
		print '<a href="member_login.html">戻る</a>';

	} else {

		session_start();
		$_SESSION['member']=1;
		$_SESSION['member_id'] = $result['id'];
		$_SESSION['mamber_name'] = $result['name'];

		header('Location:shop_list.php');
		exit();
	}

} catch(Exception $e) {

	print 'ただいま障害が発生しております。';
	exit();
}
?>