<?
session_start();
session_destroy();
?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="css/index.css" />  
</head>

<body>

<CENTER><img src="./images/logo.png" width="250" height="100" border="0" /></CENTER>
<table width="224" align="center" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<form name="form1" method="post" action="checklogin.php">
<tr>
<td width="65">Username</td>
<td width="144"><input name="myusername" type="text" id="myusername"></td>
</tr>
<tr>
<td>Password</td>
<td><input name="mypassword" type="password" id="mypassword"></td>
</tr>
<tr>
<td></td>
<td align="right"><input type="submit" name="Submit" value="Login"></td>
</tr>
<tr>
<td><div align="right"><span class="style3"><a href="register.php">Sign Up</a></span></div></td>
<td><div align="right"><span class="style3"><a href="forgotpass.php">I forgot my password </a></span></div></td>
</tr>
</form>
</table>


</body></html>