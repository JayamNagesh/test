<?php
$connection=mysql_connect("erver01.example.com,"root","root123") or die("connectivity failed"); 
mysql_select_db("nagesh",$connection);       
$create="create table lfy(name varchar(50), author varchar(50))";
mysql_query($create,$connection);                   
$insert1= "insert into lfy values('Foss Bytes','LFY Team')";
$insert2= "insert into lfy values('Connection Mysql','Ankur Aggarwal')";
mysql_query($insert1,$connection);
mysql_query($insert2,$connection);
$fetch= mysql_query("select * from lfy");
while($row=mysql_fetch_array($fetch))               
{
  print_r($row);                                    
}
mysql_close($connection);                           
?>
