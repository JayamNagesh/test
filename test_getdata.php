<html>
<body>
<?php
$con = mysql_connect('localhost','root','root123');
mysql_select_db('nagesh', $con);

#$query = mysql_query("select * from registration", $con);
#while ($row = mysql_fetch_array($query)) {
#echo "$row['firstname']";
#echo "$row['lastname']";
#}

$query  = "SELECT firstname,lastname from registration";
$result = mysql_query($query);

while($row = mysql_fetch_assoc($result))
{
    echo "FirstName :{$row['firstname']} <br>" .
         "LastName : {$row['lastname']} <br>" ;
} 


mysql_close($con)
?>
</body>
</html>
