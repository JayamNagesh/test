<html>
<body>
<?php
$con = mysql_connect('localhost','root','root123');
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db('nagesh', $con);

$sql="INSERT INTO registration (firstname, lastname)
VALUES
('$_POST[firstname]','$_POST[lastname]')";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "Registerd successfully.....!";

mysql_close($con)
?>
Go <a href="/test.php" >back</a> to the Main Page</p> 

</body>
</html>
