<?php
$con=mysql_connect("localhost","root","root","flowers");
if(!$con)
	die('Can Not Connect To The Database');
mysql_select_db('flowers');
?>