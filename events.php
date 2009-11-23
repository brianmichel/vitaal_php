<?php
session_start();
if(!session_is_registered(myusername))
{
header("location:index.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<!--CSS-->
<link rel="stylesheet" type="text/css" href="css/shared.css" />    
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />

<!--JavaScript-->
<script src="js/prototype.js" type="text/javascript"></script>
<script src="js/scriptaculous.js?load=effects,builder" type="text/javascript"></script>
<script src="js/lightbox.js" type="text/javascript"></script>
</head>
<body>

<?php
include './sql/dbconnect.php';
?>
		<!--Header-->
		<div id="banner">			
			<div id="navLogo">
				<a href=./main.php><img src="./images/vitaal_logo.png" width="194" height="133" border="0"></a></div>
			<div id="bannerRightBox">LOGIN STUFF / SEARCH BOX?</div>	
			<div id="navButtons">
				<div id="button"><? echo "<a href=./races.php?userID=$userID>Races</a>";?></div>
				<div id="button"><? echo "<a href=./runs.php?userID=$userID>Runs</a>";?></div>
				<div id="button"><? echo "<a href=./courses.php?userID=$userID>Courses</a>";?></div>
				<div id="button"><? echo "<a href=./events.php?userID=$userID>Events</a>";?></div>
			</div>	
		</div>

		<!--Left Nav Buttons-->
		
		
		<!--Main Content-->		
		<div id="content">
			<div id="leftColumn"><STRONG>My Recent Races</STRONG>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>						
				</div>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>						
				</div>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>						
				</div>
			</div>
			
			<div id="midColumn"><STRONG>My Hosted Races</STRONG>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>	
				</div>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>						
				</div>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>						
				</div>
			</div>	
			
			<div id="rightColumn"><STRONG>Neighborhood Races</STRONG>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>	
				</div>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>						
				</div>
				<div id="courseBox">
					<h2></h2>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
					</div>						
				</div>
			</div>		

		
		<!--Footer-->
		<div id="footer"></div>
</body>
</html>