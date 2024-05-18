<?php
ob_start();
session_start();

$prod_id=strtr(htmlentities($_GET['prod_id']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
if(isset($_SESSION['user_id']))
{	
	if(!isset($_SESSION['cart_start']))	
		$_SESSION['cart_start']=time();	//cart is starting

	if(! is_array($_SESSION['cart']))
		$_SESSION['cart']=array();

	if(! array_key_exists($prod_id, $_SESSION['cart']))
		$_SESSION['cart'][$prod_id]=0;
	$_SESSION['cart'][$prod_id]++;

	header("Location:detail.php?prod_id=$prod_id");	

}
else
{
	echo "<h2><a href='register.php'>Register</a> or <a href='login.php'>log in</a></h2>";
}
ob_flush();
?>
