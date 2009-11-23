<?php

$host="localhost"; // Host name
$username="dbuser"; // Mysql username
$password="gr4pes"; // Mysql password
$db_name="vitaal"; // Database name

mysql_connect("$host", "$username", "$password")or die("cannot connect");
mysql_select_db("$db_name")or die("cannot select DB");

?>