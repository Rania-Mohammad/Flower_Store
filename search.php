<?php
session_start();
require 'connection.php';//connect to database
if(isset($_SESSION['cart_start']) && time()>$_SESSION['cart_start']+60*60*1000)	//The cart information should be deleted after 1 hour.
	unset($_SESSION['cart']);
	
$key=strtr(htmlentities($_GET['key']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
		
$q=mysql_query("select * from products where name like '%$key%'");
if(mysql_num_rows ($q))
{
	echo "<table border=3><tr><th>name</th><th>img</th><th>price</th>
	<th>offer_price</th><th>sales</th><th>description</th><th>origin</th><th></th></tr>";
	while($r=mysql_fetch_assoc($q))
	{
		echo "<tr><td>$r[name]</td><td><img src='$r[img]' style='width:150px;height:150px;'></td><td>$r[price]</td>
		<td>$r[offer_price]</td><td>$r[sales]</td><td>$r[description]</td><td>$r[origin]</td>
		<td><a href='addtocart.php?prod_id=$r[prod_id]'>add to cart</a></td></tr>";
	}
	echo "</table>";
}
else
	echo "no results found<br>";
?>
<a href="index.php" id="gotohome">go to home page</a>
	
				