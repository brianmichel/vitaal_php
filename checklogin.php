<?php
$host="localhost"; // Host name
$username="dbuser"; // Mysql username
$password="gr4pes"; // Mysql password
$db_name="vitaal"; // Database name
$tbl_name="users"; // Table name

// Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];

// To protect MySQL injection (more detail about MySQL injection)
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$mypassword=md5($mypassword);

$sql="SELECT * FROM $tbl_name WHERE username='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

// Mysql_num_row is counting table row
$count=mysql_num_rows($result);
// If result matched $myusername and $mypassword, table row must be 1 row
$sql="SELECT userID FROM users WHERE username='$myusername'";
$myuserid=mysql_query($sql);
$myuserid=mysql_fetch_array($myuserid);
$myuserid=$myuserid[0];

if($count==1){
// Register $myusername, $mypassword and redirect to file "login_success.php"
session_register("myusername");
session_register("mypassword");
session_register("myuserid");
header("location:main.php");
}
else {
echo "Wrong Username or Password";
}
?>