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
		header('Location:staff_ng.php');
		exit();
	}
	$staff_id = $_POST['id'];
	header('Location:staff_disp.php?id='.$staff_id);
	exit();
}


if(isset($_POST['add'])==true)
{
	header('Location:staff_add.php');
	exit();
}


if(isset($_POST['edit'])==true)
{	
	if(isset($_POST['id'])==false)
	{
		header('Location:staff_ng.php');
		exit();
	}

	$staff_id = $_POST['id'];
	header('Location:staff_edit.php?id='.$staff_id);
	exit();
}


if(isset($_POST['delete'])==true)
{	
	if(isset($_POST['id'])==false)
	{
		header('Location:staff_ng.php');
		exit();
	}

	$staff_id = $_POST['id'];
	header('Location:staff_delete.php?id='.$staff_id);
	exit();
}
?>
