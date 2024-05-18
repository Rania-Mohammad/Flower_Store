<?php
ob_start();
session_start();
require 'connection.php';//connect to database
if($_POST['h'])
{
	$user=strtr(htmlentities($_POST['user']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
	$pass=strtr(htmlentities($_POST['pass']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
	$q=mysql_query("select * from customers where username='$user' and password='$pass' limit 1");
	if(mysql_num_rows($q))	
	{
		$r=mysql_fetch_assoc($q);	
		$_SESSION['user_id']=$r['cust_id'];
		echo "<h2 style='text-align:center;color:green'>Welcome $user<br>you will be redirected after 3 seconds</h2>";
		header("Refresh:3;url=index.php");
	}
	else
	{
		echo "<h2 style='text-align:center;color:red'>invalid username and password <br>you will be redirected after 3 seconds</h2>";
		header("Refresh:3;url=login.php");
	}
}
ob_flush();	
?>