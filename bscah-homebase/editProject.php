<?php
/*
 * Created on Mar 17, 2014
 * @author Derek and Ka Ming
 */
	session_start();
	session_cache_expire(30);
?>

<html>
	<head>
		<title>
			Edit Project
		</title>
		<link rel="stylesheet" href="styles.css" type="text/css" />
	</head>
	<body>
		<div id="container">
			<?PHP include('header.php');?>
			<div id="content">
				<?php
					$projectid=$_GET['project'];
					$venue = $_GET['venue'];
					include_once('editProject.inc');
					if($projectid=="") {
						echo "<p>No Project ID Supplied.  Click on \"Calendar\" above to edit projects.</p>";
					}
					else {
						$project=select_dbProjects ($projectid);
						if(!$project instanceof Project)
							echo "<p>Invalid Project ID Supplied.  Click on \"Calendar\" above to edit projects.</p>";
						else {
							if(!process_fill_vacancy($_POST,$project,$venue) &&
							   !process_add_volunteer($_POST,$project,$venue) &&
							   !process_move_project($_POST, $project) &&
							   !process_change_times($_POST, $project)){
								if (process_unfill_project($_POST,$project,$venue))
									$project=select_dbProjects($projectid);
								else if (process_add_slot($_POST,$project,$venue))
									$project=select_dbProjects($projectid);
								else if (process_clear_project($_POST,$project,$venue))
								    $project = select_dbProjects($projectid);
								else if (process_ignore_slot($_POST,$project, $venue))
									$project=select_dbProjects($projectid);
								$persons=$project->get_persons();
								echo "<br><br><table align=\"center\" border=\"1px\"><tr><td align=\"center\" colspan=\"2\"><b>"
									.get_project_name_from_id($projectid)."</b></td></tr>";
								if($_SESSION['access_level']>=2) {
									echo "<tr><td valign=\"top\"><br>&nbsp;".do_slot_num($persons, $project>num_vacancies())."</td><td>";
								
										echo ("<form method=\"POST\" style=\"margin-bottom:0;\">
											<input type=\"hidden\" name=\"_submit_add_slot\" value=\"1\"><br>
											<input type=\"submit\" value=\"Add Slot\" style=\"width: 150px\"
											name=\"submit\" >
											</form>");
										echo ("<form method=\"POST\" style=\"margin-bottom:0;\">
											<input type=\"hidden\" name=\"_submit_clear_project\" value=\"1\">
											<input type=\"submit\" value=\"Clear Entire Project\" style=\"width: 150px\"
											name=\"submit\" >
											</form>");
										echo ("<form method=\"POST\" style=\"margin-bottom:0;\">
											<input type=\"hidden\" name=\"_submit_move_project\" value=\"1\">
											<input type=\"submit\" value=\"Move Project\" style=\"width: 150px\"
											name=\"submit\" >
											</form>");
									echo "<br></td></tr>";
								}
								
                                                                echo display_filled_slots($persons);
								echo display_vacant_slots($project->num_vacancies());
								echo "</td></tr></table>";
								echo "<p align=\"center\"><a href=\"calendar.php?id=".substr($projectid,0,8)."&edit=true&venue=house"."\">
									Back to Calendar</a>";
							}
						}
					}
				?>
				
			</div>
			<?PHP include('footer.inc');?>
		</div>
	</body>
</html>