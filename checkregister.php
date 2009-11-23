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
$username=$_POST['username'];
$password=$_POST['password'];
$email=$_POST['email'];
$firstname=$_POST['firstname'];
$lastname=$_POST['lastname'];
$zipcode=$_POST['zipcode'];
$bio=$_POST['bio'];
$height=$_POST['height'];
$weight=$_POST['weight'];

// To protect MySQL injection (more detail about MySQL injection)
$username = stripslashes($username);
$password = stripslashes($password);
$email = stripslashes($email);
$firstname = stripslashes($firstname);
$lastname = stripslashes($lastname);
$bio = stripslashes($bio);
$zipcode = stripslashes($zipcode);
$height = stripslashes($height);
$weight = stripslashes($weight);

$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
$email = mysql_real_escape_string($email);
$firstname = mysql_real_escape_string($firstname);
$lastname = mysql_real_escape_string($lastname);
$zipcode = mysql_real_escape_string($zipcode);
$bio = mysql_real_escape_string($bio);
$height = mysql_real_escape_string($height);
$weight = mysql_real_escape_string($weight);

$password=md5($password);

//DUPLCIATE USERNAME CHECKING
$sql = mysql_query("SELECT * FROM users WHERE username = '$username'");
    if(mysql_num_rows($sql) != 0)
	{
        echo "That username is already in use.";
		echo "<a href=\"javascript:history.go(-1)\"> Try again</a>";

    }
	elseif(!$password || !$zipcode || !$username)
	{
	
		echo "You did not fill out all required fields.";
		echo "<a href=\"javascript:history.go(-1)\"> Try again</a>";
	}
	else
	{

		$sql = "INSERT INTO users (username, password, email, firstName, lastName, zipCode, bio, height, weight) 
					VALUES ('$username', '$password', '$email', '$firstname', '$lastname', '$zipcode', '$bio', '$height', '$weight');";
		$result=mysql_query($sql);
	

		if(!$result)
		{ 
			// The dot seperates PHP code and plain text.
			echo "Your query failed. " . mysql_error();
		} 
		else 
		{
			// Display a success message!
			session_register("username");
			session_register("password");
			header("location:main.php");
		}
	}
	
?>
