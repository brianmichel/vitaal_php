<?

$host="localhost"; // Host name
$username="dbuser"; // Mysql username
$password="gr4pes"; // Mysql password
$db_name="vitaal"; // Database name


//Connect to server and select databse.
mysql_connect("$host", "$username", "$password")or die("cannot connect to server");
mysql_select_db("$db_name")or die("cannot select DB");

// value sent from form
$email_to=$_POST['email_to'];

// table name
$tbl_name=users;

// retrieve password from table where e-mail = $email_to(mark@phpeasystep.com)
$sql="SELECT password FROM $tbl_name WHERE email='$email_to'";
$result=mysql_query($sql);

// if found this e-mail address, row must be 1 row
// keep value in variable name "$count"
$count=mysql_num_rows($result);

// compare if $count =1 row
if($count==1){


//Set new random password
$random_password=uniqid(rand());
$hashed_password=md5($random_password);
$new_password=substr($random_password, 0, 8);

$sql2 = "UPDATE users SET password='$hashed_password' WHERE email='$email_to'";
mysql_query($sql2);

       

// ---------------- SEND MAIL FORM ----------------

// send e-mail to ...
$to=$email_to;

// Your subject
$subject="New Password From Vita.al";

// From
$header="from: Vita.al";

// Your message
$messages= "Your password for login to our website \r\n";
$messages.="Your password new is $new_password \r\n";
$messages.="more message... \r\n";

// send email
$sentmail = mail("brooke.mckim@gmail.com","hi2u","test test test");

}

// else if $count not equal 1
else {
echo "Not found your email in our database";
}

// if your email succesfully sent
if($sentmail){
echo "Your New Password Has Been Sent To Your Email Address.";
}
else {
echo "Cannot send password to your e-mail address";
}

?>