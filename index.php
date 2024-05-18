<?php
session_start();
require 'connection.php';//connect to database
if(isset($_SESSION['cart_start']) && time()>$_SESSION['cart_start']+60*60*1000)	//The cart information should be deleted after 1 hour.
	unset($_SESSION['cart']);

?>
<html>
	<head>
		<title>flowers web site</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body><center>
		<div id="header">
			<?php
				if(isset($_SESSION['user_id']))
					{
						echo "<h2><a href='logout.php'>log out</a></h2>";
					}
					else
					{
						echo "<h2><a href='register.php'>Register</a> | <a href='login.php'>log in</a></h2>";
					}
			?>
			<div id=cart>
				<a href="viewcart.php"><img src="images/nb-vcO.gif"></a>
				<?php
					if(isset($_SESSION['cart']))
					{
						$count=count($_SESSION['cart']);
						echo "$count items Total: ";
						$total=0;		
						foreach($_SESSION['cart'] as $k=>$v)
						{	
							$q=mysql_query("select price from products where prod_id=$k limit 1");
							$r=mysql_fetch_assoc($q);
							$tot_cost_single_prod=$r['price']*$v;
							$total+=$tot_cost_single_prod;
						}
						$shipping=5.80;	
						$total+=$shipping;
						echo "$total\$";
					}
					else
						echo "Total: 0.0";
						
				?>
				<a href="index.php" style="width:160px;height:50px;padding:4 20px;border-radius:8px;text-decoration:none;background-color:#ad58b8;text-align:center;">Continue Shopping</a>	
		
			</div>
			
		</div>
		<br clear=both>
		
		<form method=get action="search.php" style='float:left;margin-left:13%;'>
			<input type="text" name="key" placeholder="Search for...">
			<input type="submit" value="Search" style="width:70px;height:24px;padding:3px 18px;background-color:green;color:white;line-height:10px;">
		</form>
		<br clear=left>
		<div id="content">
			
			<div id=con1>
				<div id="best">
					<?php
						$q=mysql_query("select * from products order by sales desc limit 1");	
						if(mysql_num_rows ($q))
						{
							$r=mysql_fetch_assoc($q);	
							$prod_id=$r['prod_id'];
							$img=$r['img'];
							$name=$r['name'];
							$price=$r['price'];
							$offer_price=$r['offer_price'];
							$description=$r['description'];
							echo "<img src='$img'><br>$name<br>";
							if($offer_price)
							{
								echo "<del><span  class='price'>$price\$</span></del><span  class='offer_price'> $offer_price\$</span>";
							}
							else
								echo "<span  class='price'>$price\$</span>";
							echo "<br>$description<br><a class='order_now' href='addtocart.php?prod_id=$prod_id'>Order Now</a>";
						}
					?>
				</div>
				<img class="c" src="images/236x304x40_roses_callout.jpg">
				<img class="c" src="images/236x304x40_roses_callout.jpg">
				
			</div>
			<?php
				$qc=mysql_query("select * from categories");
				if(mysql_num_rows ($qc))
				{
					while($rc=mysql_fetch_assoc($qc))
					{
						$cat_id=$rc['cat_id'];
						$cat_name=$rc['name'];
						$qp=mysql_query("select * from products where cat_id=$cat_id order by prod_id desc limit 1"); // The latest product of each category
						if(mysql_num_rows ($qp))
						{
							$rp=mysql_fetch_assoc($qp);	
							$img=$rp['img'];
							$name=$rp['name'];
							$price=$rp['price'];
							$offer_price=$rp['offer_price'];
							$description=$rp['description'];
							echo "<div class='product'>
								<h3>$cat_name</h3>
								<img src='$img'><br>$name<br>$description<br>";
							if($offer_price)
							{
								echo "from <del><span  class='price'>$price\$</span></del> <span  class='offer_price'>$offer_price \$</span>";
							}
							else
								echo "<span  class='price'>$price\$</span>";
							echo "<br><a class='order_now' href='addtocart.php?prod_id=$rp[prod_id]'>Order Now</a></div>";
						}
					}
				
				}
			?>
			<br clear=left>
			<?php
				$q=mysql_query("select * from products order by prod_id desc limit 12");	//latest 12 products
				if(mysql_num_rows ($q))
				{
					while($r=mysql_fetch_assoc($q))
					{
						$prod_id=$r['prod_id'];
						$img=$r['img'];
						$name=$r['name'];
						$price=$r['price'];
						$offer_price=$r['offer_price'];
						$description=$r['description'];
						echo "<div class='product2'>
							<img src='$img'><br>$name<br>$description<br>";
						if($offer_price)
						{
							echo "from <del><span  class='price'>$price\$</span></del> <span  class='offer_price'>$offer_price\$</span>";
						}
						else
							echo "<span  class='price'>$price\$</span>";
						echo "<br><a class='order_now' href='addtocart.php?prod_id=$prod_id'>Order Now</a></div>";
					}					
				}
			?>
		</div>
		<div id="footer">
		</div>
			</center>
	</body>
</html>	