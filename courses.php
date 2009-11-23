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

$userID=$_GET["userID"];
$query="SELECT runs.runID, courses.name, courses.courseID, TIMEDIFF( runs.endTime, runs.startTime ) AS time,
		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 60 THEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) 
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 60 AND TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 1440 THEN TIMESTAMPDIFF(HOUR, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 1440 AND TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 46080 THEN TIMESTAMPDIFF(DAY, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 46080 AND TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 416100 THEN TIMESTAMPDIFF(MONTH, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 416100 THEN TIMESTAMPDIFF(YEAR, dateAdded,CURRENT_TIMESTAMP())
		END AS timeAgo,
		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 60 THEN 'mins'
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 60 AND TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 1440 THEN 'hrs'
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 1440 AND TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 46080  THEN 'days'
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 46080 AND TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) < 416100  THEN 'months'
			WHEN TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) >= 416100 THEN 'years'
		END AS periodAgo,
		(select TIMEDIFF( runs.endTime, runs.startTime ) FROM runs WHERE userID='$userID' ORDER BY TIMEDIFF( runs.endTime, runs.startTime ) LIMIT 1 ) AS bestTime
		FROM runs JOIN courses ON runs.courseID = courses.courseID
		WHERE runs.userID='$userID'
		ORDER BY TIMESTAMPDIFF(MINUTE, dateAdded,CURRENT_TIMESTAMP()) DESC LIMIT 3;";

$result1=mysql_query($query);
$myCourses=mysql_fetch_array($result1);

$query="SELECT users.username, users.userID, runs.runID, courses.name, courses.courseID, TIMEDIFF( runs.endTime, runs.startTime ) AS time,
 		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 60 THEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) 
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 60 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 1440 THEN TIMESTAMPDIFF(HOUR, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 1440 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 46080 THEN TIMESTAMPDIFF(DAY, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 46080 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 416100 THEN TIMESTAMPDIFF(MONTH, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 416100 THEN TIMESTAMPDIFF(YEAR, runs.endTime,CURRENT_TIMESTAMP())
		END AS timeAgo,
		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 60 THEN 'mins'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endtime,CURRENT_TIMESTAMP()) >= 60 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 1440 THEN 'hrs'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 1440 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 46080  THEN 'days'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 46080 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 416100  THEN 'months'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 416100 THEN 'years'
		END AS periodAgo 
		FROM friendships
		JOIN users ON friendships.secondUser = users.userID
		JOIN runs ON users.userID = runs.userID
		JOIN courses ON runs.courseID = courses.courseID
		WHERE friendships.firstUser = '$userID'
		ORDER BY TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) DESC  LIMIT 3;";
$result2=mysql_query($query);
$friendsRuns=mysql_fetch_array($result2);

$query="SELECT DISTINCT courses.courseID, courses.name, users.zipCode,
		TIMEDIFF( runs.endTime, runs.startTime ) AS time, users.userID, users.username,
 		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 60 THEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) 
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 60 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 1440 THEN TIMESTAMPDIFF(HOUR, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 1440 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 46080 THEN TIMESTAMPDIFF(DAY, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 46080 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 416100 THEN TIMESTAMPDIFF(MONTH, dateAdded,CURRENT_TIMESTAMP())
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 416100 THEN TIMESTAMPDIFF(YEAR, runs.endTime,CURRENT_TIMESTAMP())
		END AS timeAgo,
		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 60 THEN 'mins'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endtime,CURRENT_TIMESTAMP()) >= 60 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 1440 THEN 'hrs'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 1440 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 46080  THEN 'days'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 46080 AND TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) < 416100  THEN 'months'
			WHEN TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) >= 416100 THEN 'years'
		END AS periodAgo 
		FROM courses JOIN runs ON runs.courseID = courses.courseID JOIN users ON runs.userID=users.userID
		WHERE courses.zipCode = users.zipCode
		ORDER BY TIMESTAMPDIFF(MINUTE, runs.endTime,CURRENT_TIMESTAMP()) DESC LIMIT 3;";
$result3=mysql_query($query);
$nbhRuns=mysql_fetch_array($result3);	

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
			<div id="leftColumn"><STRONG>My Courses</STRONG>
				
				<?php
				
					$num=mysql_numrows($result1);
					$i=0;
					while ($i < $num) {
					
				?>
				<div id="courseBox">
					<div id="courseBoxTitleRace"><a href=./courses.php?courseID=<?echo $myRuns['courseID']?>><? echo $myRuns['name']?> Course</a></div>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>Best Time</td>
								<td>:</td>
								<td align='left'><?echo $myCourses['time']?></td>
							</tr>
							<tr>
								<td align='left'>Ran</td>
								<td>:</td>
								<td align='left'><?echo $myCourses['ran']?> times</td>
							</tr>
							<tr>
								<td align='left'>Created</td>
								<td>:</td>
								<td align='left'><?php echo $myCourses['timeAgo']; echo " "; echo $myCourses['periodAgo'];?> ago</td>
							</tr>				
						</table> 
					</div>							
				</div>
				<?php 
						$i++;
						$myCourses=mysql_fetch_array($result1);
					}	
				?>
			</div>
			
			<div id="midColumn"><STRONG>Friend's Courses</STRONG>
				<?php
					$num=mysql_numrows($result2);
					$i=0;
					while ($i < $num) {
					
				?>
				<div id="courseBox">
					<div id="courseBoxTitleRace"><a href=./courses.php?courseID=<?echo $friendsRuns['courseID']?>><? echo $friendsRuns['name']?></a></div>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>User</td>
								<td>:</td>
								<td align='left'><a href=./users.php?userID=<?echo $friendsRuns['userID']?>><?php echo $friendsRuns['username'];?></a></td>
							</tr>
							<tr>
								<td align='left'>Time</td>
								<td>:</td>
								<td align='left'><?php echo $friendsRuns['time'];?></td>
							</tr>
							<tr>
								<td align='left'>Ran</td>
								<td>:</td>
								<td align='left'><?php echo $friendsRuns['timeAgo']; echo " "; echo $friendsRuns['periodAgo'];?></td>
							</tr>							
						</table> 
					</div>							
				</div>
				<?php 
						$i++;
						$friendsRuns=mysql_fetch_array($result2);
					}	
				?>
			</div>	
			
			<div id="rightColumn"><STRONG>Neighborhood Courses</STRONG>
				<?php
					$num=mysql_numrows($result3);
					$i=0;
					while ($i < $num) {
					
				?>
				<div id="courseBox">
					<div id="courseBoxTitleRace"><a href=./courses.php?courseID=<?echo $nbhRuns['courseID']?>><? echo $nbhRuns['name']?></a></div>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>User</td>
								<td>:</td>
								<td align='left'><a href=./users.php?userID=<?echo $nbhRuns['userID']?>><? echo $nbhRuns['username']?></a></td>
							</tr>
							<tr>
								<td align='left'>Time</td>
								<td>:</td>
								<td align='left'><?php echo $nbhRuns['time'];?></td>
							</tr>
							<tr>
								<td align='left'>Ran</td>
								<td>:</td>
								<td align='left'><?php echo $nbhRuns['timeAgo']; echo " "; echo $nbhRuns['periodAgo'];?> ago</td>
							</tr>							
						</table> 
					</div>							
				</div>
				<?php 
						$i++;
						$nbhRuns=mysql_fetch_array($result3);
					}	
				?>
			</div>		
			
		
		<!--Footer-->
		<div id="footer"></div>
		</div>
</body>
</html>