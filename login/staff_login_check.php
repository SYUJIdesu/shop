<?php
		
try {

	require_once '/Applications/MAMP/db_config.php';

	$staff_id = $_POST['id'];
	$staff_pass = $_POST['pass'];

	$staff_id = htmlspecialchars($staff_id,ENT_QUOTES,'UTF-8');
	$staff_pass = htmlspecialchars($staff_pass,ENT_QUOTES,'UTF-8');

	$staff_pass = md5($staff_pass);

	$dbh = new PDO('mysql:dbname=shop;host=localhost;charset=utf8', $user, $pass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$sql = 'SELECT name FROM mst_staff WHERE id = ? AND password = ?';
	$stmt = $dbh->prepare($sql);
	$data[] = $staff_id;
	$data[] = $staff_pass;
	$stmt->execute($data);

	$dbh = null;

	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	if($result==false)
	{

		print 'IDかスタッフコードが間違ってます。';
		print '<a href="staff_login.html">戻る</a>';

	} else {

		session_start();
		$_SESSION['login']=1;
		$_SESSION['staff_id'] = $staff_id;
		$_SESSION['name'] = $result['name'];

		header('Location:staff_top.php');
		exit();
	}

} catch(Exception $e) {

	print 'ただいま障害が発生しております。';
	exit();
}
?>