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

    /*
     * Created on April 1, 2012
     * @author Judy Yang <jyang2@bowdoin.edu>
     */

    session_start();
    session_cache_expire(30);
    include_once("database/dbMasterSchedule.php");
    include_once("domain/MasterScheduleEntry.php");

?>
    <!--  page generated by the BowdoinRMH software package -->
    <html>
    <head>
        <title>Master Schedule</title>
        <!--  Choose a style sheet -->
        <link rel="stylesheet" href="styles.css" type="text/css"/>
        <link rel="stylesheet" href="calendarhouse.css" type="text/css"/>
        <!-- 	<link rel="stylesheet" href="calendar_newGUI.css" type="text/css"/> -->
    </head>
    <!--  Body portion starts here -->
    <body>
    <div id="container">
        <?php include_once("header.php"); ?>
        <div id="content">
            <?php
                if ($_SESSION['access_level'] < 2) {
                    die("<p>Only managers can view the master schedule.</p>");
                }
                $week_days = ["Mon" => "Monday", "Tue" => "Tuesday", "Wed" => "Wednesday",
                    "Thu" => "Thursday", "Fri" => "Friday"];
                $weekend_days = ["Sat" => "Saturday", "Sun" => "Sunday"];
                $weekday_groups = ["odd", "even"];
                $weekend_groups = ["1st", "2nd", "3rd", "4th", "5th"];
                foreach ($weekday_groups as $weekday_group) {
                    show_master_week($weekday_group, $week_days);
                    echo "<br>";
                }
                foreach ($weekend_groups as $weekend_group) {
                    show_master_week($weekend_group, $weekend_days);
                    echo "<br>";
                }
            ?>
        </div>
    </div>
    </body>
    </html>



<?php
    /*
     * displays the master schedule for a given group (odd or even week of the year or week of month)
     * and series of days (Mon-Fri or Sat-Sun)
     */

    function show_master_week($group, $days) {
        echo('<br><table id="calendar" align="center" ><tr class="weekname"><td colspan="' . (sizeof($days) + 2) .
            '" ' .
            'bgcolor="#99B1D1" align="center" >' . $group);
        if (sizeof($days) > 2) {
            echo(' weekday Master Schedule');
        }
        else {
            echo(' weekend Master Schedule');
        }
        echo('</td></tr><tr><td bgcolor="#99B1D1">  </td>');
        foreach ($days as $day => $dayname) {
            echo('<td class="dow" align="center"> ' . $dayname . ' </td>');
        }
        echo('<td bgcolor="#99B1D1"></td></tr>');
        $free_hour = [];
        $columns = sizeof($days);
        for ($i = 0; $i < 12 * $columns; $i++) {
            $free_hour[] = true;
        }
        for ($hour = 9; $hour < 21; $hour++) {
            echo("<tr><td class=\"masterhour\">" . show_hours($hour) . "</td>");
            $i = 0;
            foreach ($days as $day => $dayname) {
                $master_shift = retrieve_dbMasterSchedule("weekly" . $day . $group . "-" . $hour);
                /* retrieves a MasterScheduleEntry whose start time is $hour */
                if ($master_shift) {
                    $shift_length = $master_shift->get_end_time() - $master_shift->get_start_time();
                    echo do_shift($master_shift, $shift_length);
                    for ($j = $hour; $j < $hour + $shift_length; $j++) {
                        $free_hour[$columns * ($j - 9) + $i] = false;
                    }
                }
                else {
                    if ($free_hour[$columns * ($hour - 9) + $i]) {
                        //	$t = $hour . "-" . ($hour+1);
                        $master_shift = new MasterScheduleEntry("weekly", $day, $group, $hour, $hour + 1, 1, "", "", "");
                        echo do_shift($master_shift, 0);
                    }
                }
                $i++;
            }
            echo("<td class=\"masterhour\">" . show_hours($hour) . "</td></tr>");
        }
        echo("<tr><td class=\"masterhour\">" . "overnight" . "</td>");
        foreach ($days as $day => $dayname) {
            $master_shift = retrieve_dbMasterSchedule("weekly" . $day . $group . "-overnight");
            if ($master_shift) {
                echo do_shift($master_shift, 1);
            }
            else {
                $master_shift = new MasterScheduleEntry("weekly", $day, $group, "overnight", 0, 1, "", "", "");
                echo do_shift($master_shift, 0);
            }
        }
        echo("<td class=\"masterhour\">" . "overnight" . "</td></tr>");
        echo "</table>";
    }

    function show_hours($hour) {
        $d = 3;
        $clock = $hour < 12 ? $hour . "am" : $hour - 12 . "pm";
        $clockend = $hour + $d < 12 ? ($hour + $d) . "am" : ($hour - 12 + $d) . "pm";
        if ($clock == "0pm") {
            $clock = "12pm";
        }
        if ($clockend == "0pm") {
            $clockend = "12pm";
        }
        if (($clock) % $d == 0) {
            return $clock . " - " . $clockend;
        }
        else {
            return "";
        }
    }

    function do_shift($master_shift, $master_shift_length) {
        /* $master_shift is a MasterScheduleEntry object
         */
        if ($master_shift_length == 0) {
            $s = "<td bgcolor=\"darkgray\" rowspan='" . $master_shift_length . "'>" .
                "<a id=\"shiftlink\" href=\"editMasterSchedule.php?group=" .
                $master_shift->get_week_no() . "&day=" . $master_shift->get_day() . "&shift=" .
                $master_shift->get_time() . "&venue=" . $master_shift->get_schedule_type() . "\">" .
                "<br>" .
                "</td>";
        }
        else {
            if ($master_shift->get_slots() == 0) {
                $s = "<td rowspan='" . $master_shift_length . "'>" .
                    "<a id=\"shiftlink\" href=\"editMasterSchedule.php?group=" .
                    $master_shift->get_week_no() . "&day=" . $master_shift->get_day() . "&shift=" .
                    $master_shift->get_time() . "&venue=" . $master_shift->get_schedule_type() . "\">" .
                    "<br>" .
                    "</td>";
            }
            else {
                $s = "<td rowspan='" . $master_shift_length . "'>" .
                    "<a id=\"shiftlink\" href=\"editMasterSchedule.php?group=" .
                    $master_shift->get_week_no() . "&day=" . $master_shift->get_day() . "&shift=" .
                    $master_shift->get_time() . "&venue=" . $master_shift->get_schedule_type() . "\">" .
                    get_people_for_shift($master_shift, $master_shift_length) .
                    "</td>";
            }
        }

        return $s;
    }

    function get_people_for_shift($master_shift, $master_shift_length) {
        /* $master_shift is a MasterScheduleEntry object
         * an associative array of (venue, my_group, day, time,
         * start, end, slots, persons, notes) */
        $people =
            get_persons($master_shift->get_schedule_type(), $master_shift->get_week_no(), $master_shift->get_day(),
                        $master_shift->get_time());
        $slots =
            get_total_slots($master_shift->get_schedule_type(), $master_shift->get_week_no(), $master_shift->get_day(),
                            $master_shift->get_time());
        if (!$people[0]) {
            array_shift($people);
        }
        $p = "<br>";
        for ($i = 0; $i < count($people); ++$i) {
            if (is_array($people[$i])) {
                $p = $p . "&nbsp;" . $people[$i]['first_name'] . " " . $people[$i]['last_name'] . "<br>";
            }
            else {
                $p = $p . "&nbsp;" . $people[$i] . "<br>";
            }
        }
        if ($slots - count($people) > 0) {
            $p = $p . "&nbsp;<b>Vacancies (" . ($slots - count($people)) . ")</b><br>";
        }
        else {
            if (count($people) == 0) {
                $p = $p . "&nbsp;<br>";
            }
        }

        return substr($p, 0, strlen($p) - 4);
    }

?>