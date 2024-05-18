<?php
ob_start();
echo "<h2 style='text-align:center;color:green'>Thank you for your order<br>you will be redirected after 3 seconds</h2>";
header("Refresh:3;url=index.php");
ob_flush();
?>	