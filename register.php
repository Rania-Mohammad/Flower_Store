<html>
	<head>
		<title>Registration Page</title>
	</head>
	<body>
		<form method='post' action='register_process.php'>
			<table>
				<tr><td>username:</td><td><input name='user' ></td></tr>
				<tr><td>password:</td><td><input type='password' name='pass' ></td></tr>
			    <tr><td>re-enter password:</td><td><input type='password' name='repass' ></td></tr>
			    <tr><td>address:</td><td><input name='address' ></td></tr>
				<tr><td>phone:</td><td><input name='phone' ></td></tr>
				<tr><td><input type='submit' value='Register'></td></tr>
			</table>
			<input type='hidden' name='h' value='1'>
		</form>
		<a href="index.php" id="gotohome">go to home page</a>	
	</body>
</html>