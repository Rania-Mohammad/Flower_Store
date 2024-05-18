<?php
$server='localhost';	
$username='root';
$password='root';
$con=mysql_connect($server,$username,$password);	
if(!$con)					
	die("Can Not Connect To The Server $server");
$q=mysql_query('CREATE DATABASE IF NOT EXISTS flowers',$con);	
if(!$q)
	die("Failed To Create The Database");	
mysql_select_db('flowers');

$sql="
CREATE TABLE IF NOT EXISTS customers (
cust_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(100) NOT NULL,
password VARCHAR(100) NOT NULL,
phone varchar(11),
address varchar(100),
last_visit_date VARCHAR(100)
)
";
$q=mysql_query($sql);	
if(!$q)
	echo mysql_error();	

$sql="
CREATE TABLE IF NOT EXISTS categories (
cat_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL
)
";
mysql_query($sql);	

mysql_query("insert into categories values('','Next Day Flowers'),('','Bset Sellers'),('','Birthday Flowers'),('','Sympathy Flowers')");

$sql="
CREATE TABLE IF NOT EXISTS products (
prod_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
cat_id INT NOT NULL,
name VARCHAR(100) NOT NULL,
img VARCHAR(100) NOT NULL,
price DECIMAL(4,2) NOT NULL,
offer_price DECIMAL(4,2),
sales INT DEFAULT 0,
description TEXT NOT NULL,
origin VARCHAR(50) NOT NULL,
foreign key products(cat_id) references categories(cat_id)
)
";
mysql_query($sql);
//---initial insert here---
mysql_query("insert into products values('',1,'flower1','images/12-red-roses-bouquet.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',1,'flower2','images/40-roses_1.jpg',50.35,28.45,3,'this is a flower description','England')
,('',1,'flower3','images/DD090516-free-plant.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',1,'flower4','images/DD021115.jpg',44.50,24.70,3,'this is a flower description','England')
,('',2,'flower5','images/BF1603.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',2,'flower6','images/BF1604.jpg',50.35,28.45,3,'this is a flower description','England')
,('',2,'flower7','images/BF1605.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',2,'flower8','images/blue-flowers.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',3,'flower9','images/cadburys-bouqet.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',3,'flower10','images/CP1013.jpg',50.35,28.45,3,'this is a flower description','England')
,('',3,'flower11','images/CP1014.jpg',50.35,28.45,7,'this is a flower description','paris')
,('',4,'flower12','images/LR1010.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',4,'flower13','images/LR1012.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',2,'flower14','images/milky-way-bouquet.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',3,'flower15','images/SP1603.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',3,'flower16','images/SP1604.jpg',50.35,28.45,3,'this is a flower description','England')
,('',3,'flower17','images/SP1605.jpg',44.50,24.70,3,'this is a flower description','paris')
,('',2,'flower18','images/SP1606.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',1,'flower19','images/SP1607.jpg',50.35,28.45,3,'this is a flower description','paris')
,('',1,'flower20','images/sunflower-bouquet.jpg',44.50,24.70,3,'this is a flower description','England')
");

mysql_query("create table orders (
order_id int not null auto_increment primary key,
cust_id int not null,
name varchar(100) not null,
code varchar(50) not null,
company varchar(100),
street varchar(100) not null,
line2 varchar(100),
town varchar(100) not null,
country varchar(100) not null,
phone varchar(13),
date varchar(50),
total_cost decimal(6,2),
foreign key orders(cust_id) references customers(cust_id)
)");

mysql_close();
?>