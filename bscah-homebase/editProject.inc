<?php

    /*
     * Created on Mar 17, 2014
     * @author Derek and Ka Ming
     */
    include_once('database/dbProjects.php');
    include_once('database/dbPersons.php');
    include_once('database/dbLog.php');

    function do_slot_num($persons, $vacancies) {
        if (!$persons[0]) {
            array_project($persons);
        }
        if ($vacancies < 0) {
            $vacancies = 0;
        }  // this is a kluge
        $slots = count($persons) + $vacancies;
        if ($slots == 1) {
            return "1 slot for this project:";
        }

        return $slots . " slots for this projects:";
    }

    function display_filled_slots($persons) {
        $s = "";
        if (!$persons[0]) {
            array_project($persons);
        }
        for ($i = 0; $i < count($persons); ++$i) {
            $p = explode("+", $persons[$i]);
            $s = $s . "<tr><td width=\"150\" valign=\"top\"><br>&nbsp;" . $p[1] . " " . $p[2] . "</td><td>
				<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_filled_slot_" . $i . "\" value=\"1\"><br>
				<input type=\"submit\" value=\"Remove Person\" name=\"submit\" style=\"width: 150px\">
			</form><br></td></tr>";
        }

        return $s;
    }

    function display_vacant_slots($vacancies) {
        $s = "";
        for ($i = 0; $i < $vacancies; ++$i) {
            $s = $s . "<tr><td width=\"150\" valign=\"top\"><br>&nbsp;<b>vacancy</b></td><td>
				<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_fill_vacancy\" value=\"1\"><br>
				<input type=\"submit\" value=\"Assign Volunteer\" name=\"submit\" style=\"width: 150px\"></form>";
            if ($_SESSION['access_level'] >= 2) {
                $s = $s . "<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_ignore_vacancy\" value=\"1\">
				<input type=\"submit\" value=\"Remove Vacancy\" name=\"submit\" style=\"width: 150px\"></form>";
            }
            $s = $s . "<br></td></tr>";
        }

        return $s;
    }

    function process_fill_vacancy($post, $project, $venue) {
        if (!array_key_exists('_submit_fill_vacancy', $post)) {
            return false;
        }
        $projectid = $project->get_id();
        $projecttime = $project->get_time_of_day();
        echo "<br><br><table align=\"center\"><tr><td align=\"center\" width=\"400\"><b>"
            . get_project_name_from_id($projectid) . "</b></td></tr>
		<tr><td><form method=\"POST\" style=\"margin-bottom:0;\">
			<select name=\"scheduled_vol\">
			<option value=\"0\" style=\"width: 371px;\">Select a volunteer with this availability</option>"
            . get_available_volunteer_options($projecttime, $project->get_day(), $project->get_persons(), $venue) .
            "</select><br>
			<br>or<br><br>
			<select name=\"all_vol\">
			<option value=\"0\" style=\"width: 371px;\">Select from all volunteers for this venue</option>"
            . get_all_volunteer_options($projecttime, $project->get_day(), $project->get_persons(), $venue) .
            "</select><br><br>
			<input type=\"hidden\" name=\"_submit_add_volunteer\" value=\"1\">
			<input type=\"submit\" value=\"Add Volunteer\" name=\"submit\" style=\"width: 400px\">
			</form></td></tr>";
        echo "</table>";
        echo "<table align=\"center\"><tr><td align=\"center\" width=\"400\">
		&nbsp;<a href=\"editProject.php?project=" . $projectid . "&venue=" . $venue . "\">Back to Project"
            . "</a><br></td></tr></table>";

        return true;

        // check that person is not already working that project
        // check that person is available
    }

    function process_add_volunteer($post, $project, $venue) {
        update_dprojecs($project);
        if (!array_key_exists('_submit_add_volunteer', $post)) {
            return false;
        }
        if ($post['all_vol'] == "0" && $post['scheduled_vol'] == "0") {
            $error = "<table align=\"center\"><tr><td width=\"400\">
				You must select a volunteer from one of the menus.</td></tr></table><br>";
        }
        else {
            if ($post['all_vol'] != "0" && $post['scheduled_vol'] != "0") {
                $error = "<table align=\"center\"><tr><td width=\"400\">
				You have selected a volunteer from both menus.  Please choose only one.</td></tr></table><br>";
            }
            else {
                $vol = $post['scheduled_vol'];
                if ($vol == "0") {
                    $vol = $post['all_vol'];
                }
                $persons = $project->get_persons();
            }
        }
        if ($error) {
            echo $error;

            return true;
        }
        else {
            $persons[] = $vol;
            $project->assign_persons($persons);
            $project->ignore_vacancy();
            update_dbProjects($project);
            $name = explode("+", $vol);
            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                          $_SESSION['l_name'] . '</a> assigned <a href=\"personEdit.php?id=' . $name[0] . '\">' .
                          $name[1] . ' ' . $name[2] . '</a> to the project: <a href=\"editProject.php?project=' .
                          $project > get_id() . '\">' . get_project_name_from_id($project->get_id()) . '</a>.');

            return false;
        }
    }

    function process_unfill_project($post, $project, $venue) {
        update_dbProjects($project);
        $persons = $project->get_persons();
        if (!$persons[0]) {
            array_project($persons);
        }
        for ($i = 0; $i < count($persons); ++$i) {
            $p2 = [];
            if (array_key_exists('_submit_filled_slot_' . $i, $post)) {
                for ($j = 0; $j < count($persons); ++$j) {
                    if ($i != $j) {
                        $p2[] = $persons[$j];
                    }
                    else {
                        $name = $persons[$j];
                    }
                }
                if (count($p2) == 0) {
                    $p2 = [];
                }
                error_log("removing " . $name);
                $project->assign_persons($p2);
                $project->add_vacancy();
                if ($name) {
                    $name = explode("+", $name);
                }
                update_dbProjects($project);
                add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                              $_SESSION['l_name'] . '</a> removed <a href=\"personEdit.php?id=' . $name[0] . '\">' .
                              $name[1] . ' ' . $name[2] . '</a> from the project: <a href=\"editProject.php?project=' .
                              $project->get_id() . '\">' . get_project_name_from_id($project->get_id()) . '</a>.');

                return true;
            }
        }

        return false;
    }

    function process_add_slot($post, $project, $venue) {
        if (array_key_exists('_submit_add_slot', $post)) {
            $project->add_vacancy();
            update_dbProjects($project);
            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                          $_SESSION['l_name'] . '</a> added a slot to the project: <a href=\"editProject.php?project=' .
                          $project->get_id() . '\">' .
                          get_project_name_from_id($project->get_id()) . '</a>.');

            return true;
        }

        return false;
    }

    function process_clear_project($post, $project, $venue) {
        if (array_key_exists('_submit_clear_project', $post)) {

            $project = new Project($project->get_id(), "weekly", $project->num_slots(), null, null, "", "");
            update_dbProjects($project);
            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                          $_SESSION['l_name'] . '</a> cleared the project: <a href=\"editProject.php?project=' .
                          $project->get_id() . '\">' .
                          get_project_name_from_id($project->get_id()) . '</a>.');

            return true;
        }

        return false;
    }

    function process_move_project($post, $project) {
        if (!array_key_exists('_submit_move_project', $post)) {
            return false;
        }
        echo "<br><br><table align=\"center\" border=\"1px\" style=\"width: 330px\"><tr><td align=\"center\"><b>"
            . get_project_name_from_id($project->get_id()) . "</b></td></tr>
		<tr><td align=\"center\"><form method=\"POST\" style=\"margin-bottom:0;\">
			<select name=\"new_start\">
			<option value=\"0\" >Select a new starting time</option>"
            . get_all_times() .
            "</select><br>
			<br>and/or<br><br>
			<select name=\"new_end\">
			<option value=\"0\" >Select a new ending time</option>"
            . get_all_times() .
            "</select><br><br>
			<input type=\"hidden\" name=\"_submit_change_times\" value=\"1\">
			<input type=\"submit\" value=\"Change Times\" name=\"submit\"><br><br>
			</form></td></tr>";
        echo "</table>";
        echo "<table align=\"center\"><tr><td align=\"center\" width=\"400\">
		<br><a href=\"editProject.php?project=" . $project->get_id() . "\">Back to Project</a><br></td></tr></table>";

        return true;
    }

    function get_all_times() {
        $s = "";
        for ($hour = 9; $hour < 22; $hour++) {
            $clock = $hour < 12 ? $hour . "am" : $hour - 12 . "pm";
            if ($clock == "0pm") {
                $clock = "12pm";
            }
            $s = $s . "<option value=\"" . $hour . "\">" . $clock . "</option>";
        }

        return $s;
    }

    function process_change_times($post, $project) {
        if (!array_key_exists('_submit_change_times', $post)) {
            return false;
        }
        if ($post['new_start'] == "0" && $post['new_end'] == "0") {
            $error = "<table align=\"center\"><tr><td width=\"400\">
				Can't move project: you must select a new start or end time.</td></tr></table><br>";
        }
        else {
            $error = false;
            $new_start = $post['new_start'];
            $new_end = $post['new_end'];

            if ($new_start == "0") {
                $new_start = $project->get_start_time();
            }
            if ($new_end == "0") {
                $new_end = $project->get_end_time();
            }
//			echo $new_start . ' ' . $new_end;
            if (!move_project($project, $new_start, $new_end)) {
                $error = "Can't move the project to an overlapping time.";
            }
        }
        if ($error) {
            echo $error;

            return true;
        }
        else {
            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                          $_SESSION['l_name'] . '</a> moved the project: <a href=\"editProject.php?project=' .
                          $project->get_id() . '\">' . get_project_name_from_id($project->get_id()) . '</a>.');

            return false;
        }
    }

    function process_ignore_slot($post, $project, $venue) {
        if (array_key_exists('_submit_ignore_vacancy', $post)) {
            $project->ignore_vacancy();
            update_dbProjects($project);
            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                          $_SESSION['l_name'] .
                          '</a> ignored a vacant slot for the project: <a href=\"editProject.php?project=' .
                          $project->get_id() . '\">' .
                          get_project_name_from_id($project->get_id()) . '</a>.');

            return true;
        }

        return false;
    }

    function get_available_volunteer_options($time, $day, $persons, $venue) {
        if (!$persons[0]) {
            array_project($persons);
        }
        $result = getall_available("volunteer", $day, $time);
        $s = "";
        for ($i = 0; $i < mysql_num_rows($result); ++$i) {
            $row = mysql_fetch_row($result);
            $value = $row[0] . "+" . $row[1] . "+" . $row[2];
            $label = $row[2] . ", " . $row[1];
            $match = false;
            for ($j = 0; $j < count($persons); ++$j) {
                if ($value == $persons[$j]) {
                    $match = true;
                }
            }
            if (!$match) {
                $s = $s . "<option value=\"" . $value . "\">" . $label . "</option>";
                $match = false;
            }
        }

        return $s;
    }

    function get_all_volunteer_options($name, $day, $persons, $venue) {
        if (!$persons[0]) {
            array_project($persons);
        }
        $result = getall_type("volunteer");
        $s = "";
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $row = mysql_fetch_row($result);
            //  if (!strpos($row[15],"manager")) {
            $value = $row[0] . "+" . $row[1] . "+" . $row[2];
            $label = $row[2] . ", " . $row[1];
            $match = false;
            for ($j = 0; $j < count($persons); ++$j) {
                if ($value == $persons[$j]) {
                    $match = true;
                }
            }
            if (!$match) {
                $s = $s . "<option value=\"" . $value . "\">" . $label . "</option>";
                $match = false;
            }
            //  }
        }

        return $s;
    }

?>
