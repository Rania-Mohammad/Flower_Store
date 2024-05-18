<?php
ob_start();
//session_start();
require 'connection.php';//connect to database

if($_POST['h'])
{
	$user=strtr(htmlentities($_POST['user']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
	$pass=strtr(htmlentities($_POST['pass']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
	$repass=strtr(htmlentities($_POST['repass']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
	$address=strtr(htmlentities($_POST['address']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
	$phone=strtr(htmlentities($_POST['phone']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
	
	if($err=validate())
	{
		show($err);
	}
	else
	{
		$q=mysql_query("select * from customers where username='$user'");
		if(mysql_num_rows($q)>0)	
		{
			echo "<h2>the username $user already registered <br>you will be redirected after 3 seconds</h2>";
			header("Refresh:3;url=index.php");
		}
		else
		{
			$q=mysql_query("insert into customers values('','$user','$pass','$address','$phone','')");
			if(mysql_affected_rows ($con))	
				{
					//echo "<h2 style='text-align:center;color:green'>successfully registered the username $user <br>you will be redirected after 3 seconds</h2>";
					//$_SESSION['user_id']=mysql_insert_id();
					header("Location:login.php");
					
				}
			else
				echo mysql_error();	
		}
	
	}

}
function validate()
{
	global $user,$pass,$repass;
	$err=array();
	if(strlen($pass)<=8||!preg_match('#[a-z]#',$pass)
	||!preg_match('#[A-Z]#',$pass)||!preg_match('#[\d]#',$pass))
		$err['pass']='the password should be strong longer than 8 symbols, has capital and small letters, and numbers';
	if($pass!=$repass)
		$err['repass']='the two passwords must be identical';
	return $err;
}
function show($err)
{
	global $user,$pass,$repass,$address,$phone;
	?>
	<html>
		<head>
			<title>Registration Page</title>
		</head>
		<body>
			<form action='register_process.php' method='post'>
				<table>
					<tr><td>username:</td><td><input type='text' name='user' <?php echo "value='$user' ></td>"; if(isset($err['user'])) echo"<td style='color:red;'>$err[user]</td>"; ?> </tr>
					<tr><td>password:</td><td><input type='password' name='pass' <?php echo "value='$pass' ></td>"; if($err['pass']) echo"<td style='color:red;'>$err[pass]</td>"; ?> </tr>
					<tr><td>re-enter password:</td><td><input type='password' name='repass' <?php echo "value='$repass' ></td>"; if($err['repass']) echo"<td style='color:red;'>$err[repass]</td>"; ?></tr>
					<tr><td>address:</td><td><input type='text' name='address' <?php echo "value='$address' ></td>";?></tr>
					<tr><td>phone:</td><td><input type='text' name='phone' <?php echo "value='$phone' ></td>";?></tr>
					<tr><td colspan=2><input type='submit' value='Register'></td></tr>
				</table>
				<input type='hidden' name='h' value='1'>
			</form>
		</body>
	</html>
	<?php
}
ob_flush();	
?>