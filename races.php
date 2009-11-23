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
<script src="js/lightbox.js" type="text/javascript" type="text/javascript"></script>
<script src="js/jquery.js" type="text/javascript"></script>

<script>	
		$(document).ready(function(){
			$('.dropDown').hide();
			$('.button').hover(
				function(){
					$('.dropDown').fadeIn();
			},
				function(){
					$('.dropDown').fadeOut();
			});			
		});
</script>		

</head>
<body>

<?php
include './sql/dbconnect.php';

$userID=$_GET["userID"];
$query="SELECT races.raceID, races.raceName, courses.name, races.courseID, TIMEDIFF( runs.endTime, runs.startTime ) AS time,
		(SELECT COUNT(DISTINCT runs.userID) FROM runs WHERE runs.raceID=races.raceID) as runners,
		(SELECT COUNT(DISTINCT runs.userID) FROM runs WHERE runs.raceID=1 AND TIMEDIFF( runs.endTime, runs.startTime )
		< (SELECT TIMEDIFF( runs.endTime, runs.startTime ) FROM runs WHERE runs.userID='$userID' and runs.raceID=races.raceID LIMIT 1)) AS place
		FROM races JOIN courses ON races.courseID = courses.courseID
		JOIN runs ON races.raceID = runs.raceID
		WHERE runs.userID='$userID';";

$result1=mysql_query($query);
$myRaces=mysql_fetch_array($result1);

$query="SELECT DISTINCT races.raceName, races.raceID, courses.name, races.courseID, races.endDate, 
		(select COUNT(DISTINCT runs.userID) from runs WHERE runs.raceID=races.raceID) as runners,
		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 60 THEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) 
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 60 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 1440 THEN TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), races.endDate)
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 1440 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 46080 THEN TIMESTAMPDIFF(DAY, CURRENT_TIMESTAMP(), races.endDate)
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 46080 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 416100 THEN TIMESTAMPDIFF(MONTH, CURRENT_TIMESTAMP(), races.endDate)
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 416100 THEN TIMESTAMPDIFF(YEAR, CURRENT_TIMESTAMP(), races.endDate)
		END AS timeTill,
		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 60 THEN 'mins'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 60 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 1440 THEN 'hrs'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 1440 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 46080  THEN 'days'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 46080 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 416100  THEN 'months'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 416100 THEN 'years'
		END AS periodTill
		FROM races JOIN courses ON races.courseID = courses.courseID
		JOIN runs ON races.raceID = runs.raceID
		WHERE races.userID='$userID'
		ORDER BY TIMESTAMPDIFF(MINUTE, races.endDate,CURRENT_TIMESTAMP()) DESC LIMIT 3;";
$result2=mysql_query($query);
$hostedRaces=mysql_fetch_array($result2);

$query="SELECT DISTINCT races.raceID, races.raceName, courses.courseID, courses.name, races.endDate,
		(select COUNT(DISTINCT runs.userID) from runs WHERE runs.raceID=races.raceID) as runners,
		(select zipCode from users WHERE userID='$userID') as zipCode,
				CASE 
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 60 THEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) 
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 60 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 1440 THEN TIMESTAMPDIFF(HOUR, CURRENT_TIMESTAMP(), races.endDate)
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 1440 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 46080 THEN TIMESTAMPDIFF(DAY, CURRENT_TIMESTAMP(), races.endDate)
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 46080 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 416100 THEN TIMESTAMPDIFF(MONTH, CURRENT_TIMESTAMP(), races.endDate)
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 416100 THEN TIMESTAMPDIFF(YEAR, CURRENT_TIMESTAMP(), races.endDate)
		END AS timeTill,
		CASE 
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 60 THEN 'mins'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 60 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 1440 THEN 'hrs'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 1440 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 46080  THEN 'days'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 46080 AND TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) < 416100  THEN 'months'
			WHEN TIMESTAMPDIFF(MINUTE, CURRENT_TIMESTAMP(), races.endDate) >= 416100 THEN 'years'
		END AS periodTill,
		(SELECT COUNT(runs.runID) FROM runs JOIN races ON runs.raceID=races.raceID WHERE runs.userID='$userID') AS part
		FROM courses JOIN races ON races.courseID = courses.courseID
		WHERE courses.zipCode = zipCode
		ORDER BY TIMESTAMPDIFF(MINUTE, races.endDate,CURRENT_TIMESTAMP()) DESC LIMIT 3;";
$result3=mysql_query($query);
$nbhRaces=mysql_fetch_array($result3);	

?>
		<!--Header-->
		<div id="banner">			
			<div id="navLogo">
				<a href=./main.php><img src="./images/vitaal_logo.png" width="194" height="133" border="0"></a></div>
			<div id="bannerRightBox">LOGIN STUFF / SEARCH BOX?</div>	
			<div id="navButtons">					
				<div class="menu">
					<ul>
						<li><a class=hide href=./races.php?userID<? echo $userID?>>Races</a>
							<ul>
								<li><a href="#">Create Race</a></li>
								<li><a href="#">Races</a></li>
								<li><a href="#">Hosted races</a></li>
								<li><a href="#">Neighborhood Races</a></li>
								<li><a href="#">Friend's races</a></li>
								<li><a href="#">Most Popular Races</a></li>
							</ul>				
						<li><a href=./runs.php?userID=<? echo $userID?>>Runs</a>
					        <ul>
								<li><a href="#">Create Race</a></li>
								<li><a href="#">Races</a></li>
								<li><a href="#">Hosted races</a></li>
								<li><a href="#">Neighborhood Races</a></li>
								<li><a href="#">Friend's races</a></li>
								<li><a href="#">Most Popular Races</a></li>
							</ul>
						<li><a class=hide href=./courses.php?userID=<? echo $userID?>>Courses</a>
							<ul>
								<li><a href="#">Courses</a></li>
								<li><a href="#">Create course</a></li>
								<li><a href="#">Neighborhood courses</a></li>
								<li><a href="#">Friend's Courses</a></li>
								<li><a href="#">Most popular</a></li>
								<li><a href="#">Favorite courses</a></li>
							</ul>
						<li><a class=hide herf=./events.php?userID=<?echo $userID?>>Events</a>
							<ul>
								<li><a href="#">Events</a></li>
								<li><a href="#">Create event</a></li>
								<li><a href="#">Neighborhood events</a></li>
								<li><a href="#">Friend's events</a></li>
								<li><a href="#">Most popular events</a></li>
							</ul>	
					</ul>
				</div>
			</div>	
		</div>
		
		
		<!--Main Content-->
		<div id="content">
			<div id="leftColumn"><STRONG>My Recent Races</STRONG>
				
				<?php
				
					$num=mysql_numrows($result1);
					$i=0;
					while ($i < $num) {
					
				?>
				<div id="courseBox">
					<div id="courseBoxTitleRace"><a href=./races.php?raceID=<?echo $myRaces['raceID']?>><? echo $myRaces['raceName']?></a></div>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>Course</td>
								<td>:</td>
								<td align='left'><a href=./courses.php?courseID=<?echo $myRaces['courseID']?>><?php echo $myRaces['name'];?></a></td>
							</tr>
							<tr>
								<td align='left'>Time</td>
								<td>:</td>
								<td align='left'><?php echo $myRaces['time'];?></td>
							</tr>
							<tr>
								<td align='left'>Place</td>
								<td>:</td>
								<td align='left'><?php echo $myRaces['place']+1; echo " of "; echo $myRaces['runners'];?></td>
							</tr>				
						</table> 
					</div>							
				</div>
				<?php 
						$i++;
						$myRaces=mysql_fetch_array($result1);
					}	
				?>
			</div>
			
			<div id="midColumn"><STRONG>My Hosted Races</STRONG>
				<?php
					$num=mysql_numrows($result2);
					$i=0;
					while ($i < $num) {
					
				?>
				<div id="courseBox">
					<div id="courseBoxTitleRace"><a href=./races.php?raceID=<?echo $hostedRaces['raceID']?>><? echo $hostedRaces['raceName']?></a></div>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>Course</td>
								<td>:</td>
								<td align='left'><a href=./courses.php?courseID=<?echo $hostedRaces['courseID']?>><?php echo $hostedRaces['name'];?></a></td>
							</tr>
							<tr>
								<td align='left'>Runners</td>
								<td>:</td>
								<td align='left'><?php echo $hostedRaces['runners'];?></td>
							</tr>
							<tr>
								<td align='left'>Ends In</td>
								<td>:</td>
								<td align='left'><?php echo $hostedRaces['timeTill']; echo " "; echo $hostedRaces['periodTill'];?></td>
							</tr>							
						</table> 
					</div>							
				</div>
				<?php 
						$i++;
						$myRaces=mysql_fetch_array($result2);
					}	
				?>
			</div>	
			
			<div id="rightColumn"><STRONG>Neighborhood Races</STRONG>
				<?php
					$num=mysql_numrows($result3);
					$i=0;
					while ($i < $num) {
					
				?>
				<div id="courseBox">
					<div id="courseBoxTitleRace"><a href=./races.php?raceID=<?echo $nbhRaces['raceID']?>><? echo $nbhRaces['raceName']?></a></div>
					<div id="map"><a href="./images/testmap.jpg" rel="lightbox"><img src="./images/testmap.jpg"/></a></div>
					<div id="columnText">
						<table>
							<tr>
								<td align='left'>Course</td>
								<td>:</td>
								<td align='left'><a href=./courses.php?courseID=<?echo $nbhRaces['courseID']?>><?php echo $nbhRaces['name'];?></a></td>
							</tr>
							<tr>
								<td align='left'>Runners</td>
								<td>:</td>
								<td align='left'><?php echo $nbhRaces['runners'];?></td>
							</tr>
							<tr>
								<td align='left'>Ends In</td>
								<td>:</td>
								<td align='left'><?php echo $nbhRaces['timeTill']; echo " "; echo $nbhRaces['periodTill'];?></td>
							</tr>							
						</table> 
					</div>							
				</div>
				<?php 
						$i++;
						$nbhRaces=mysql_fetch_array($result3);
					}	
				?>
			</div>		
			
		
		<!--Footer-->
		<div id="footer">
		
		</div>
		</div>
</body>
</html>