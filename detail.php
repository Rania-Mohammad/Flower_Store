<?php
ob_start();
session_start();
require 'connection.php';//connect to database
if(isset($_SESSION['cart_start']) && time()>$_SESSION['cart_start']+60*60*1000)	//The cart information should be deleted after 1 hour.
	unset($_SESSION['cart']);

$prod_id=strtr(htmlentities($_GET['prod_id']), array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));
?>
<html>
	<head>
		<title>details</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<div id="container">
			<div id="header">
				<?php
					if($_SESSION['user_id'])
						{
							echo "<a href='logout.php'>log out</a><br>";
						}
						else
						{
							echo "<a href='register.php'>Register</a> or <a href='login.php'>log in</a><br>";
						}
				?>
				<div id=cart>
					<a href="viewcart.php"><img src="images/nb-vcO.gif"></a>
					<?php
						if(isset($_SESSION['cart']))
						{
							$count=count($_SESSION['cart']);
							echo "$count item Total: ";
							$total=0;		
							foreach($_SESSION['cart'] as $k=>$v)
							{	
								$q=mysql_query("select * from products where prod_id=$k");
								$r=mysql_fetch_assoc($q);
								$tot_cost_single_prod=$r['price']*$v;
								$total+=$tot_cost_single_prod;
							}
							$shipping=5.80;	//or any calculation
							$total+=$shipping;
							echo "$total \$";
						}
						else
							echo "Total: 0.0";
							
					?>
				</div>
				
			</div>
			<br clear=both>
			<div id="content">
				<?php $q=mysql_query("select * from products where prod_id=$prod_id limit 1");
				$r=mysql_fetch_assoc($q);
				if(mysql_num_rows ($q))
					{
						$prod_id=$r['prod_id'];
						$img=$r['img'];
						$name=$r['name'];
						$price=$r['price'];
						$offer_price=$r['offer_price'];
						$description=$r['description'];
						echo "<div style='width:280px;height:300px;text-align:center;float:left;margin-left:5px;'>
							<img src='$img'><br>$name<br>$description<br>";
						if($offer_price)
						{
							echo "<span  class='surprise'>Surprise it costs $offer_price \$ instead of $price \$</span>";
						}
						else
							echo "$price \$";
						echo "</div>";	
									
					}
					
				
				echo "<div style='width:305px;height:300px;float:left;text-align:center;margin-left:30px;background-color:#ad59b9;'>	<h2>Delivery Details</h2>
					<table>
					<tr><td>Date: </td><td><input type='date' name='date'></td></tr>
					<tr><td>Delivery: </td><td>$shipping</td></tr>
					<br>
					<tr><td>Type: </td>";
					$q=mysql_query("select categories.name as cat_name,products.name as prod_name from categories,products where products.prod_id=$prod_id and categories.cat_id=products.cat_id");
					$r=mysql_fetch_assoc($q);
					echo "<td>$r[cat_name]</td></tr><tr><td>Item: </td><td>$r[prod_name]</tr>";
					echo "</table>
					<hr>
					<textarea rows=4 cols=34 style='overflow: scroll;'>
					
					</textarea>
					
					</div>";
				
				$errors=array();
					
				$validation=false;
				if(isset($_POST['h']))
				{
					$name=strtr(htmlentities($_POST['name']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"')); //security
					$code=strtr(htmlentities($_POST['code']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));	
					$company=strtr(htmlentities($_POST['company']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));	
					$street=strtr(htmlentities($_POST['street']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));	
					$line2=strtr(htmlentities($_POST['line2']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));	
					$town=strtr(htmlentities($_POST['town']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));	
					$country=strtr(htmlentities($_POST['country']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));	
					$phone=strtr(htmlentities($_POST['phone']),array("_" => "\_", "%" => "\%", "'" => "\'", '"' => '\"'));	
					
					//validation
					if(!preg_match("/[a-zA-Z\s\d]{3,}/",$code))
						$errors['code']='wrong code';
					if(!strlen($code))
						$err['code']='Postal Code Required';
					if(!preg_match('/\d\d\d-\d\d-\d\d\d\d\d\d/',$phone))
						$errors['phone']='wrong phone';
					if(!strlen($name))
						$errors['name']='the name is required feild';
					if(!strlen($street))
						$errors['street']='the street is required feild';
					if(!strlen($town))
						$errors['phone']='the name is required feild';

					if(!$errors)    //validation is correct
					{		
						if(!$_SESSION['user_id'])
						{
							echo "<br>you must <a href='register.php'>Register</a> or <a href='login.php'>log in</a><br>";
						}
						else
						{
							$date=time();
							$q=mysql_query("insert into orders values('',$_SESSION[user_id],
							'$name','$code','$company','$street','$line2','$town','$country','$phone','$date','$total')");
							if(mysql_affected_rows($con))
								{
									foreach($_SESSION['cart'] as $k=>$v)
										$q=mysql_query("update products set sales=sales+$v where prod_id=$k");
									unset($_SESSION['cart']);
									header("Location:end_order.php");
								}
						}
						$validation=true;
					}
				}
				if(!$validation)
				{
					echo"<div style='width:350px;height:300px;float:left;text-align:center;margin-left:10px;background-color:#9cd14b;'>	<h2 style='margin-top:-2'>Delivery Address</h2>
					<form method='post' action='detail.php?prod_id=$prod_id' style='margin-top:-20'>
					<table>
						<tr><td>Name:* </td><td><input name=name value='";if(isset($_POST['name'])) echo $_POST['name']; echo "' required></td>"; if(isset($errors['name'])) echo "<td class='err'>$errors[name]</td>";echo "</tr>
						<tr><td>Postal Code:* </td><td><input name=code value='";if(isset($_POST['code'])) echo $_POST['code']; echo "' size=8 required></td>"; if(isset($errors['code'])) echo "<td class='err'>$errors[code]</td>";echo "</tr>
						<tr><td>company: </td><td><input name=company value='";if(isset($_POST['company'])) echo $_POST['company']; echo "'></td></tr>
						<tr><td>street:* </td><td><input name=street value='";if(isset($_POST['street'])) echo $_POST['street']; echo "' required></td>"; if(isset($errors['street'])) echo "<td class='err'>$errors[street]</td>";echo "</tr>
						<tr><td>line2: </td><td><input name=line2 value='";if(isset($_POST['line2'])) echo $_POST['line2']; echo "'></td></tr>
						<tr><td>town:* </td><td><input name=town value='";if(isset($_POST['town'])) echo $_POST['town']; echo "' required></td>"; if(isset($errors['town'])) echo "<td class='err'>$errors[town]</td>";echo "</tr>
						<tr><td>country/state: </td><td><input name=country value='";if(isset($_POST['country'])) echo $_POST['country']; echo "'></td></tr>
						<tr><td>Telephone: </td><td><input name=phone value='";if(isset($_POST['phone'])) echo $_POST['phone']; echo "'></td>"; if(isset($errors['phone'])) echo "<td class='err'>$errors[phone]</td>";echo "</tr>
					</table>
					<input type=hidden name=h value=1>
					<button type=submit style='width:130px;height:50px;padding:4 20px;border-radius:8px;background-color:#b8e356;margin-top:4px;margin-left:10px;'>
					<img src='images/pad-lock-symbol.gif'>Secure <br>Checkout</button>
				
					</form>	
				</div>";
				}
			?>
				
				<br clear=left><br>
				<a href="index.php" style="width:160px;height:50px;padding:4 20px;border-radius:8px;text-decoration:none;background-color:#ad58b8;text-align:center;">Continue Shopping</a>	
				<a href="viewcart.php" style="width:160px;height:50px;padding:4 20px;border-radius:8px;text-decoration:none;background-color:#ad58b8;text-align:center;">View Cart</a>	
			</div>
		</div>
	</body>
</html>	
<?php ob_flush();?>