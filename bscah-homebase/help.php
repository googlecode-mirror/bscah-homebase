<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

	session_start();
	session_cache_expire(30);
?>
<!-- page generated by the BowdoinRMH software package -->
<html>
	<head>
		<title>
			BSCAH Help <?PHP echo($_GET['helpPage']); ?>
		</title>
		<link rel="stylesheet" href="tutorial/styles.css" type="text/css" />
	</head>

	<body>
		<div id="container">
			<div id="content">
                            <div align="center"><a href="index.php">BSCAH Home Page</a> |
				<a href="?">Help Home Page</a></div>
                            

				<?PHP
					//This array associates pages a person might be viewing
					//with the help page we assume they want. Note: it might be important
					//for each page to include within it a link to the 'home help' website
					//to allow us to get them to material somewhere else they might want.
					//you can guarantee a link to the home site by simply linking to
					//help.php with no variable passed through the GET method.

					//basic pages
					$assocHelp['login.php']='login.inc.php';
					$assocHelp['index.php']='index.inc.php';
					$assocHelp['about.php']='index.inc.php';

					//person editing, searching, viewing
					$assocHelp['searchPeople.php']='searchPersonHelp.inc.php';
					$assocHelp['edit.php']='editPersonHelp.inc.php';
					$assocHelp['rmh.php']='addPersonHelp.inc.php';
					$assocHelp['viewPerson.php']='viewPersonHelp.inc.php';
					$assocHelp['cancelShift.php']='cancelPersonShift.inc.php';

					//schedule managing
					$assocHelp['calendar.php']='manageCalendarHelp.inc.php';
					$assocHelp['viewCalendar.php']='manageCalendarHelp.inc.php';
					$assocHelp['addWeek.php']='manageCalendarHelp.inc.php';
					$assocHelp['generateWeek.php']='generateWeekHelp.inc.php';
					$assocHelp['addNotes.php']='calendarNotesHelp.inc.php';
					$assocHelp['editShift.php']='editShiftHelp.inc.php';
					$assocHelp['addSlotToShift.php']='addSlotToShiftHelp.inc.php';
					$assocHelp['assignToShift.php']='assignToShiftHelp.inc.php';
					$assocHelp['removeFromShift.php']='removeFromShiftHelp.inc.php';
					$assocHelp['masterSchedule.php']='schedulingHelp.inc.php';
					$assocHelp['addPersonToShift.php']='addPersonToShiftHelp.inc.php';
					$assocHelp['navigateThroughWeeks.php']='navigateThroughWeeksHelp.inc.php';
					$assocHelp['quickStartGuide.php']='quickStartGuideHelp.inc.php';
					$assocHelp['reports.php']='reportsHelp.inc.php';
					$assocHelp['dataExport.php']='dataExportHelp.inc.php';
                                        $assocHelp['addProject.php']='addProject.inc.php';
                                        $assocHelp['editProject.php']='editProjectHelp.inc.php';

					//personal home page
					$assocHelp['index.php']='indexHelp.inc.php';


					//Now if we have an undefined array value for the key they've passed us
					//what happens? This means that the page they're looking for help on doesn't have a
					//specific help page we defined above. So we pass them to the index page to see if they can find help from there.
					if(!$assocHelp[$_GET['helpPage']])
						$assocHelp[$_GET['helpPage']]='index.inc.php';

					//now this line actually snags the tutorial data they're requesting and displays it.
					include('tutorial/'.$assocHelp[$_GET['helpPage']]);
				?>

				
			</div>
		<?PHP include('footer.inc');?>
		</div>
	</body>
</html>


