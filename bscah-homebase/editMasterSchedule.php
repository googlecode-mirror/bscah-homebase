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
                Edit Master Schedule Shift
            </title>
            <link rel="stylesheet" href="styles.css" type="text/css"/>
        </head>
        <body>
            <div id="container">
                <?PHP include('header.php'); ?>
                <div id="content">
                    <?php
                        if ($_SESSION['access_level'] < 2) {
                            die("<p>Only managers can edit the master schedule.</p>");
                        }
                        // $frequency=$_GET['frequency'];
                        $venue = $_GET['venue'];
                        $day = $_GET['day'];
                        $shift = [$day, $_GET['shift']];
                        $shift = get_day_names($shift, $day);
                        include_once('database/dbMasterSchedule.php');
                        include_once('domain/MasterScheduleEntry.php');
                        include_once('database/dbLog.php');
                        //if($group=="" || $day=="" || $shift=="") {
                        if ($day == "" || $shift == "") {
                            echo "<p>Invalid schedule parameters.  Please click on the \"Master Schedule\" link above to edit a master schedule shift.</p>";
                        } // see if there is no master shift for this time slot and try to set times starting there
                        else {
                            $master_entry = retrieve_dbMasterSchedule($venue . $day . $shift[1]);
                            if ($master_entry == false) {
                                $result = process_set_times($_POST, $day);

                                if ($result) {
                                    $returnpoint = "viewSchedule.php?frequency=" . $venue;
                                    echo "<table align=\"center\"><tr><td align=\"center\" width=\"442\">
                                        <br><a href=\"" . $returnpoint . "\">
                                        Back to Master Schedule</a></td></tr></table>";
                                }
                                // if not, there's an opportunity to add a shift
                                else {
                                    //$groupdisplay = $venue . " Group ".$group;
                                    echo("<table align=\"center\" width=\"450\"><tr><td align=\"center\" colspan=\"2\"><b>
		                                Adding a new ". ucfirst($venue) ." shift for " .
                                        substr($shift[0], 3) . " " . $shift[2] .  " which starts at " . explode(" to ", do_name($_GET['shift']))[0] . "</b></td></tr>" . "<tr><td>
                                            <b>Shift Name:</b>
                                            <form method=\"POST\" style=\"margin-bottom:0;\">
                                            <input name=\"shift_name\" type=\"text\"><br>
                                            		<select hidden name=\"new_start\">
                                                    <option value=\"0\">Please select a new starting time</option>"
                                        . get_all_times() . "
                                                    </select>
                                                    <select name=\"new_end\">
                                                    <option value=\"0\">Default End</option>"
                                        . get_all_end_times(explode("-", $shift[1])[1]) . "
                                                    </select>
                                                    <input type=\"hidden\" name=\"_submit_change_times\" value=\"1\">
		                                    <input type=\"submit\" value=\"Add New Shift\" name=\"submit\">
		                                    </form><br></td></tr></table>");
                                }
                            }
                            else { // if one is there, see what we can do to update it
                                if (!process_remove_shift($_POST, $shift, $day, $shift[1], $venue)) { // try to remove the shift
                                    // we've tried to clear the shift, add a slot, or remove a slot;
                                    // so now display the shift again.
                                    // $groupdisplay = $venue . " Group ".$group;
                                    echo("<table align=\"center\" width=\"450\"><tr><td align=\"center\" colspan=\"2\"><b>" .
                                        ucfirst($venue) .
                                        " shift for " .
                                        " " . $shift[2] . ", " . do_name($shift[1]) . "<br> \"" .  $master_entry->get_Shifts() ."\"" .
                                        "</b>
			<form method=\"POST\" style=\"margin-bottom:0;\">
			<input type=\"hidden\" name=\"_submit_remove_shift\" value=\"1\"><br>
			<input type=\"submit\" value=\"Remove Entire Shift\"
			name=\"submit\">
			</form><br>
			</td></tr>");

                                    $returnpoint = "viewSchedule.php?frequency=" . $venue;
                                    echo "<table align=\"center\"><tr><td align=\"center\" width=\"442\">
			<br><a href=\"" . $returnpoint . "\">
			 Back to Master Schedule</a></td></tr></table>";
                                }
                            }
                        }
                    ?>
                    <br>
                </div>
                <?PHP include('footer.inc'); ?>
            </div>
        </body>
    </html>

<?php

    function get_all_times() {
        $s = "";
        for ($hour = 9; $hour < 22; $hour++) {
            $clock = $hour < 12 ? $hour . "am" : $hour - 12 . "pm";
            if ($clock == "0pm") {
                $clock = "12pm";
            }
            $s = $s . "<option value=\"" . $hour . "\">" . $clock . "</option>";
        }
        $s = $s . "<option value=\"" . "overnight" . "\">" . "overnight" . "</option>";

        return $s;
    }

    function get_all_end_times($start_time) {
        $s = "";
        if($start_time == "") {
            return null;
        }
        for ($hour = $start_time + 1; $hour < 22; $hour++) {
            $clock = $hour < 12 ? $hour . "am" : $hour - 12 . "pm";
            if ($clock == "0pm") {
                $clock = "12pm";
            }
            $s = $s . "<option value=\"" . $hour . "\">" . $clock . "</option>";
        }

        return $s;
    }

    function process_set_times($post, $day) {
        $venue = $_GET['venue'];
        $times = explode("-", $_GET['shift']);
        $start = $times[0];
        $end = $times[1];

        $shift_name = $post['shift_name'];
        if($shift_name === ""){
            $shift_name = ucfirst($venue) . " Shift";
        }
        if($post['new_end'] != 0) {
            $end = ($post['new_end']);
        }
        if (!array_key_exists('_submit_change_times', $post)) {
            return false;
        }

        $entry = new MasterScheduleEntry(
            $venue, // Schedule type
            $day, // Day
            $start, // Start time
            $end, // End time
            0, // Slots
            "", // Persons
            "", // Notes
            $shift_name
        );

        if (!insert_nonoverlapping($entry)) {
            $error = "Can't insert a new shift into an overlapping time slot.<br><br>";
        }
        if (isset($error)) {
            echo $error;

            return false;
        }
        else {
            $day_name[] = [];
            $day_name = get_day_names($day_name, $day);
            //$groupdisplay = $venue . " Group ".$group." Time ".$time;
            echo "Added a new " . ucfirst($venue) ." shift for " . $day_name[1] . " which starts at " . explode(" to ", do_name($_GET['shift']))[0] . "<br><br>";
            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                          $_SESSION['l_name'] .
                          '</a> added a new master schedule shift: <a href=\"editMasterSchedule.php?' .
                          "day=" . $day . "&shift=" . $post['shift_name'] . "&venue=" . $post['$venue'] . '\">' . " " .
                          $day . $post['shift_name'] . '</a>.');

            return true;
        }
    }

    function process_remove_shift($post, $shift, $day, $time, $frequency) {
        if (!array_key_exists('_submit_remove_shift', $post)) {
            return false;
        }
        $id = $frequency . $day . $time;
        if (delete_dbMasterSchedule($id)) {
            echo "<br>Deleted " . ucfirst($frequency) . " shift for " . $shift[2] . " (" . do_name($time) . ")<br><br>";
            $returnpoint = "viewSchedule.php?frequency=" . $frequency;
            echo "<table align=\"center\"><tr><td align=\"center\" width=\"442\">
				<br><a href=\"" . $returnpoint . "\">
				Back to Master Schedule</a></td></tr></table>";
            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                          $_SESSION['l_name'] .
                          '</a> deleted a new master schedule shift: <a href=\"editMasterSchedule.php?' .
                          "day=" . $day . "&shift=" . $shift . "&frequency=" . $frequency . '\">' .
                          $frequency . " " . $day . " " . $shift . '</a>.');

            return true;
        }

        return false;
    }

    function do_name($id) {
        if ($id == "overnight") {
            return "overnight";
        }
        else {
            $start = substr($id, 0, strpos($id, "-"));
            $end = substr($id, strpos($id, "-") + 1);
            if ($start < 12) {
                if ($end < 12) {
                    return $start . "am to " . $end . "am";
                }
                else {
                    if ($end == 12) {
                        return $start . "am to " . $end . "pm";
                    }
                    else {
                        return $start . "am to " . ($end - 12) . "pm";
                    }
                }
            }
            else {
                if ($start == 12) {
                    return $start . "pm to " . ($end - 12) . "pm";
                }
                else {
                    return ($start - 12) . "pm to " . ($end - 12) . "pm";
                }
            }
        }
    }

    /**
     * Takes in a shift and a day and appends the long format of the date (eg Monday) and the short format (eg Mon)
     *
     * @param $shift The shift to add to
     * @param $day The day of the week to add
     *
     * @return array The array with the long and short formats of the date appended
     */
    function get_day_names($shift, $day) {
        $days = [
            "Mon" => "Monday",
            "Tue" => "Tuesday",
            "Wed" => "Wednesday",
            "Thu" => "Thursday",
            "Fri" => "Friday",
            "Sat" => "Saturday",
            "Sun" => "Sunday"
        ];
        $dayName = isset($days[$day]) ? $days[$day] : "";
        if ($dayName != "") {
            $shift[] = $dayName;
            $shift[] = $day;
        }
        else {
            error_log("ERROR: $day is not a valid day");
        }

        return $shift;
    }
?>