<?php
ob_start();
session_start();
require 'connection.php';//connect to database
echo "<h2 style='text-align:center;color:brown'>Successfully Logged Out Of The web Site <br>You Will Be Redirected After 3 Seconds</h2>";
$d=date("Y/m/d h:i:s a");
mysql_query("update customers set last_visit_date='$d' where cust_id='$_SESSION[user_id]'");
session_destroy();
header("Refresh:3;url=index.php");
ob_flush();	
?>