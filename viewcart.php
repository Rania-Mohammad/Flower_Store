<?php
session_start();
require 'connection.php';//connect to database
if(isset($_SESSION['cart_start']) && time()>$_SESSION['cart_start']+60*60*1000)	//The cart information should be deleted after 1 hour.
	unset($_SESSION['cart']);

if(!array_key_exists('user_id', $_SESSION))		//not logged in
{

	echo "<h2><a href='register.php'>Register</a> or <a href='login.php'>log in</a><h2>";	
}
else
{
	if(isset($_SESSION['cart']))
	{
		echo "<table border=3><tr><th>name</th><th>img</th><th>price</th><th>quantity</th><th>total</th></tr>
				";
		$total=0;		
		foreach($_SESSION['cart'] as $k=>$v)
		{	
			$q=mysql_query("select * from products where prod_id=$k");
			$r=mysql_fetch_assoc($q);
			$tot_cost_single_prod=$r['price']*$v;
			$total+=$tot_cost_single_prod=$r['price']*$v;
			echo "<tr><td>$r[name]</td><td><img src=$r[img] width=100px height=100px></td>
			<td>$r[price] \$</td><td>$v</td><td>$tot_cost_single_prod \$</td></tr>";
		}
		echo "</table>";
		$shipping=5.80;	
		$total+=$shipping;
		echo "<h2>total cost: $total\$</h2>";
		
		echo "<a href='detail.php?prod_id=$k' style='padding:4 20px;border-radius:8px;
	text-decoration:none;background-color:cyan;color:blue;text-align:center;'>Go to Checkout</a><br><br>";	
	}
	else
		echo "Empty Cart <br><br>";
		
	echo "<a href='index.php' style='padding:4 20px;border-radius:8px;
	text-decoration:none;background-color:#ad58b8;color:white;text-align:center;'>Continue Shopping</a>";	
}					
?>
