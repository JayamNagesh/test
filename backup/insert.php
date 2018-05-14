<?php
$link = mysql_connect('localhost', 'root', 'root123', 'nagesh');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

$empname = mysql_real_escape_string($link, $_REQUEST['empname']);

$sql = "INSERT INTO employee (empname) VALUES ('$empname')";

if(mysql_query($link, $sql)){
    echo "Records added successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysql_error($link);
}
 
// close connection
mysql_close($link);
?>
