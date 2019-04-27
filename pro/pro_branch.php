<?php
session_start();
session_regenerate_id(true);

if(isset($_SESSION['login'])==false)
{

	print 'ログインされてません<br>';
	print '<a href="../login/staff_login.html">ログイン画面へ</a><br>';
	exit();

}

if(isset($_POST['disp'])==true)
{
	if(isset($_POST['id'])==false)
	{
		header('Location:pro_ng.php');
		exit();
	}
	$pro_id = $_POST['id'];
	header('Location:pro_disp.php?id='.$pro_id);
	exit();
}


if(isset($_POST['add'])==true)
{
	header('Location:pro_add.php');
	exit();
}


if(isset($_POST['edit'])==true)
{	
	if(isset($_POST['id'])==false)
	{
		header('Location:pro_ng.php');
		exit();
	}

	$pro_id = $_POST['id'];
	header('Location:pro_edit.php?id='.$pro_id);
	exit();
}


if(isset($_POST['delete'])==true)
{	
	if(isset($_POST['id'])==false)
	{
		header('Location:pro_ng.php');
		exit();
	}

	$staff_id = $_POST['id'];
	header('Location:pro_delete.php?id='.$staff_id);
	exit();
}
?>
