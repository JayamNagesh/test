<html>
<body>
<h1>Registration Form</h1>
<!-- <form action="test_insert.php" method="post">
Firstname: <input type="text" name="firstname" /><br><br>
Lastname: <input type="text" name="lastname" /><br><br>
 
<input type="submit" /> -->
</form>
<!-- <form action="test_getdata.php" method="get">
<input type="submit" value="Get Data">
</form> -->

<form action="saveimage.php" enctype="multipart/form-data"  method="post">
Firstname: <input type="text" name="firstname" /><br><br>
Lastname: <input type="text" name="lastname" /><br><br>
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
<input name="userfile" type="file" />
<input type="submit" value="Submit" />
</form>


<form action="file_display.php" method="get">
ID: <input type="text" name="id" />
<input type="submit" value="Display">
</form>

</body>
</html>
