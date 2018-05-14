<?php
include "file_constants.php";
$id = $_GET['id'];

 // just so we know it is broken
 error_reporting(E_ALL);
 // some basic sanity checks
 if(isset($id) && is_numeric($id)) {
     //connect to the db
     $link = mysql_connect("$host", "$user", "$pass")
     or die("Could not connect: " . mysql_error());

     // select our database
     mysql_select_db("$db") or die(mysql_error());

    $sql = "SELECT firstname,lastname,image FROM registration_images WHERE id=" .$_GET['id'] . ";";
    $result = mysql_query($sql) ;
    while($row = mysql_fetch_array($result)){
      header('Content-type: MIME');
       $image=$row['image']; 
       $firstname=$row['firstname'];
       $lastname=$row['lastname'];
    }

    

     // get the image from the db
     //$sql = "SELECT image FROM registration_images WHERE id=" .$_GET['id'] . ";";
     // the result of the query
     //$result = mysql_query("$sql") or die("Invalid query: " . mysql_error());


     // set the header for the image
    //header("Content-type: image/jpeg");
    // echo mysql_result($result, 0);
    

     // close the db link
     mysql_close($link);
 }
?>

<!DOCTYPE html>
<html>
<body>

<audio src="Gudilo.mp3" autoplay></audio>
        <table>
            <tr><td>Happy Birthday Dear...<?php echo $firstname; ?>
<?php echo $lastname; ?></td></tr>
            <tr><td><?php echo '<img src="data:image/jpeg;base64,'.base64_encode($image) .'" />';?></td></tr>
        </table>
    </body>
</html> 
