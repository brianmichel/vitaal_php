<?php
session_start();
if(!session_is_registered(myusername))
{
header("location:index.php");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
include './sql/queries.php';

$userID=$_SESSION['myuserid'];
$zipCode=getZip($userID);

$result1=getAreaCourses($zipCode);
$result2=courseActivity($userID);
$result3=friendsFeed($userID);
	
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

		<!--Main Content-->		
		<div id="content">
			<div id="leftColumn"><STRONG>New Courses in My Area</STRONG>
				<?php
					$num=mysql_numrows($result1);
					$i=0;
					while ($i < $num) {		
						$newCourses=mysql_fetch_array($result1);
				?>
				<div id="courseBox">
					<div id="courseBoxTitle"><a href=./courses.php?courseID=<?echo $newCourses['courseID']?>><? echo $newCourses['name']?></a></div>
					<div id="map"><a href="./images/maps/<? echo $newCourses['mapLink']?>" rel="lightbox"><img src="./images/maps/<? echo $newCourses['mapLink'];?>" height=150 width=270></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>Difficulty</td>
								<td>:</td>
								<td align='left'><?php echo $newCourses['difficulty'];?></td>
							</tr>
							<tr>
								<td align='left'>Length</td>
								<td>:</td>
								<td align='left'><?php echo $newCourses['length'];?> mi</td>
							</tr>
							<tr>
								<td align='left'>Created</td>
								<td>:</td>
								<td align='left'><?php echo $newCourses['timeAgo']; echo " "; echo $newCourses['periodAgo'];?> ago</td>
							</tr>							
						</table> 
					</div>	
				</div>
				<?php 
					$i++;
					}	
				?>		
			</div>
				
			
			<div id="midColumn"><STRONG>Recent Activity on My Courses</STRONG>
				<?php
					$num=mysql_numrows($result2);
					$i=0;
					while ($i < $num) {		
						$recentRuns=mysql_fetch_array($result2);
				?>
				<div id="courseBox">
					<div id="courseBoxTitle"><a href=./courses.php?courseID=<?echo $recentRuns['courseID']?>><? echo $recentRuns['name']?></a></div>
					<div id="map"><a href="./images/maps/<? echo $recentRuns['mapLink']?>" rel="lightbox"><img src="./images/maps/<? echo $recentRuns['mapLink']?>"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>User</td>
								<td>:</td>
								<td align='left'><?php echo $recentRuns['username'];?></td>
							</tr>
							<tr>
								<td align='left'>Time</td>
								<td>:</td>
								<td align='left'><?php echo $recentRuns['time'];?></td>
							</tr>
							<tr>
								<td align='left'>Ran</td>
								<td>:</td>
								<td align='left'><?php echo $recentRuns['timeAgo']; echo " "; echo $recentRuns['periodAgo'];?> ago</td>
							</tr>						
						</table>
					</div>	
				</div>
				<?php 
					$i++;
					}	
				?>	
			</div>	
			<div id="rightColumn"><STRONG>Friend's Activity</STRONG>
			<?php
					$num=mysql_numrows($result3);
					$i=0;
					while ($i < $num) {			
						$friendsRuns=mysql_fetch_array($result3);
			?>
			<div id="courseBox">
					<div id="courseBoxTitle"><a href=./courses.php?courseID=<?echo $friendsRuns['courseID']?>><? echo $friendsRuns['name']?></a></div>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>User</td>
								<td>:</td>
								<td align='left'><?php echo $friendsRuns['username'];?></td>
							</tr>
							<tr>
								<td align='left'>Time</td>
								<td>:</td>
								<td align='left'><?php echo $friendsRuns['time'];?></td>
							</tr>
							<tr>
								<td align='left'>Ran</td>
								<td>:</td>
								<td align='left'><?php echo $friendsRuns['timeAgo']; echo " "; echo $friendsRuns['periodAgo'];?> ago</td>
							</tr>						
						</table> 	
					</div>	
				</div>
				<?php 
					$i++;
					}	
				?>					
				
			</div>
		</div>
		
		<!--Footer-->
		<div id="footer">
			
			<ul>
				<li>Copyright &copy; 2009 GbS Inc.
				<li>About Us
				<li>Contact Us
				<li>Terms of Use
				<li>Site Map
			</ul>
		
		</div>

</body>
</html>