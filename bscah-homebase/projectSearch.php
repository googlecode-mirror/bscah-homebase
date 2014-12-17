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
<html>
    <head>
        <title>
            Search for Projects
        </title>
        <link rel="stylesheet" href="styles.css" type="text/css"/>
    </head>
    <body>
        <div id="container">
            <a href="index.php"</a>
            <?PHP include('header.php');
            include('accessController.php');?>
            <div id="content">
                <?PHP
                // display the search form
                session_start();
                session_cache_expire(30);
                include_once('database/dbProjects.php');
                include_once('domain/Project.php');
                $id = $_GET["id"];
                //See what is in the $_GET["id"] array
                error_log("id is " . $_GET["id"]);
                if ($id == "none") {
                    $area = $_GET['area'];
                    echo('<form method="post">');
                    echo('<p><strong>Search for projects:</strong>');

                    echo '<p>Name (type a few letters): ';
                    echo '<input type="text" name="s_name">';

                    echo '<fieldset>
						<legend>Project Details: </legend>
							<table><tr>
								<td>Day of week</td><td>Address</td><td>Vacancies</td><td>Date</td><td>Type</td>
								</tr>';
                    echo "<tr>";
                    echo "<td>";
                    $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                    echo '<select name="s_day">' . '<option value=""></option>';
                    foreach ($days as $day) {
                        echo '<option value="' . $day . '">' . $day . '</option>';
                    }


                    /* echo '</select>';
                      echo "</td><td>";
                      $shifts = array('morning' => 'Morning (9-12)', 'earlypm' => 'Early Afternoon (12-3)', 'latepm' => 'Late Afternoon (3-6)',
                      'evening' => 'Evening (6-9)', 'overnight' => 'Overnight');
                      echo '<select name="s_shift">' . '<option value=""></option>';
                      foreach ($shifts as $shiftno => $shiftname) {
                      echo '<option value="' . $shiftno . '">' . $shiftname . '</option>';
                      }

                     */
                    echo '</select>';

                    echo "</td>";
                    echo('<td><input type="text" name="form_Address"></td>');
                    echo('<td><input type="text" name="form_Vacancies"></td>');
                    echo('<td><input type="text" name="form_Date"></td>');
                    echo('<td><input type="text" name="form_Type"></td>');
                    echo "</tr>";
                    echo '</table></fieldset>';

                    echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
                    echo('</form></p>');

                    // if user hit "Search"  button, query the database and display the results
                    if ($_POST['s_submitted']) {
                        //type, status, and name of PROJECT
                        $date = $_POST['form_Date'];
                        $vacancies = $_POST['form_Vacancies'];
                        $address = $_POST['form_Address'];
                        $day = $_POST['s_day'];
                        $type = $_POST['form_Type'];
                        $status = $_POST['s_status'];
                        $name = trim(str_replace('\'', '&#39;', htmlentities($_POST['s_name'])));

                        include_once('database/dbProjects.php');
                        include_once('domain/Project.php');

                        $allProjects = get_Projects_By_All_Fields($name, $address, $day, $type, $vacancies, $date);
                        //$allProjects = search_dbProjects_By_Name($_POST['s_name']);

                        if (sizeof($allProjects) > 0) {
                            echo('<b>'. '<font size="6">' . 'Select one to add or remove yourself from the project.' . '</font>' . '</b>');
                            echo ('<p><table> <tr><td>Name</td><td>Date</td><td>Address</td><td>Start Time</td><td>End Time</td><td>Age Requirement</td><td>Volunteers</td></tr>');
                            foreach ($allProjects as $temp) {
                                echo ("<tr><td><a href=projectSearch.php?id=" . $temp->get_id() . ">" .
                                $temp->get_name() . "</td><td>" .
                                $temp->get_date() . "</td><td>" .
                                $temp->get_address() . "</td><td>" .
                                $temp->get_start_time() . "</td><td>" .
                                $temp->get_end_time() . "</td><td>" .
                                $temp->get_age() . "</td><td>" .
                                $temp->get_persons() . "</td></a></tr>");
                            }
                        }
                        echo ('</table>');
                    }
                } else {
                    $selectedProj = select_dbProjects($id);
                    if ($selectedProj == null) {
                        error_log ( "The ID is invalid." . $id);
                        die();

                    } else {
                        $personToBeAdded = $_SESSION['_id'];
                        include_once 'domain/Person.php';
                        $self = retrieve_person($personToBeAdded);

                    /*} else if($tempAge >= $ageZero){
                        error_log('user id is ' . $_SESSION['_id']);
                        
                        $completePerson = retrieve_person($personToBeAdded);
                        add_A_Person($selectedProj->get_id(), $completePerson->get_id(), $completePerson->get_first_name(), $completePerson->get_last_name());
                        */
                        if ($self == null) {
                            error_log('Error with User information');
                            die();
                        } else {
                            $ageReq = $selectedProj->get_age();
                        $personAge = $self->get_birthday();
                        error_log($personAge);
                            $tempAge = check_Age($personAge); //, $ageReq);
                            $ageZero = 0;
                            if ($tempAge >= $ageReq) {
                                error_log('user id is ' . $_SESSION['_id']);

                                $completePerson = retrieve_person($personToBeAdded);
                                add_A_Person($selectedProj->get_id(), $completePerson->get_id(), $completePerson->get_first_name(), $completePerson->get_last_name());

                                echo('<p>');
                                echo ('<fieldset>
				<legend>Project Details: </legend>
				');
                                echo("<p><table><tr><td>Date</td><td>" . $selectedProj->get_date() . "</td></tr>"
                                . "<tr><td>Project Name</td><td>" . $selectedProj->get_name() . " </td></tr>"
                                . "<tr><td>Address</td><td>" . $selectedProj->get_address() . " </td></tr>"
                                . "<tr><td>Start Time</td><td>" . $selectedProj->get_start_time() . " </td></tr>"
                                . "<tr><td>End Time</td><td>" . $selectedProj->get_end_time() . " </td></tr>"
                                . "<tr><td>Vacancies</td><td>" . $selectedProj->get_vacancies() . " </td></tr>"
                                . "<tr><td>Day</td><td>" . $selectedProj->get_dayOfWeek() . " </td></tr>"
                                //. "<tr><td>Persons</td><td>" . $selectedProj->get_persons() . " </td></tr>"
                                . "<tr><td>Notes</td><td>" . $selectedProj->get_project_description() . " </td></tr>"
                                . "</table>"
                                );
                                echo('</fieldset><p>');
                            } else {
                                echo('You do not meet the age requirement, but feel free to email the manager at manager@email.com to see if you can still join.');
                            }
                        }
                    }
                }
                ?>
                <!-- below is the footer that we're using currently-->
            </div>
        </div>
<?PHP include('footer.inc'); ?>
    </body>
</html>


