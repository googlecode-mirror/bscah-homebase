<?php
    /*
     * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,
     * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan,
     * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.
     * This program is part of BSCAH Homebase, which is free software.  It comes with
     * absolutely no warranty. You can redistribute and/or modify it under the terms
     * of the GNU General Public License as published by the Free Software Foundation
     * (see <http://www.gnu.org/licenses/ for more information).
     *
     */

    session_start();
    session_cache_expire(30);
?>
<!--
        addWeek.php
        @author Max Palmer and Allen Tucker
        @version 3/25/08, revised 9/10/08
-->
<html>
<head>
    <title>
        Add Weeks to Calendar
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
<div id="container">
    <?PHP include('header.php');
          include('accessController.php');
    ?>
    <div id="content">
        <?PHP
            include_once('database/dbWeeks.php');
            include_once('database/dbMasterSchedule.php');
            include_once('database/dbPersons.php');
            include_once('database/dbLog.php');
            include_once('domain/Shift.php');
            include_once('domain/Project.php'); //added by james
            include_once('domain/BSCAHdate.php'); //edited by james
            include_once('domain/Week.php');
            include_once('domain/Person.php');
            // Check to see if there are already weeks in the db
            // connects to the database to see if there are any weeks in the dbWeeks table
            $result = get_all_dbWeeks();
            // If no weeks for either the house or the family room, show first week form
            $firstweek = sizeof($result) == 0;
            // publishes a week if the user is a manager
            if ($_GET['publish'] && $_SESSION['access_level'] >= 2) {
                $id = $_GET['publish'];
                $week = get_dbWeeks($id);
                if ($week->get_status() == "unpublished") {
                    $week->set_status("published");
                }
                else {
                    if ($week->get_status() == "published") {
                        $week->set_status("unpublished");
                    }
                }
                update_dbWeeks($week);
                add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                              $_SESSION['l_name'] . '</a> ' .
                              $week->get_status() . ' the week of <a href=\"calendar.php?id=' . $week->get_id() .
                              '&edit=true\">' . $week->get_name() . '</a>.');
                echo "<p>Week \"" . $week->get_name() . "\" " .
                    $week->get_status() . ".<br>";
                include('addWeek_newweek.inc');
            }
            // removes a week if user is a manager
            else {
                if ($_GET['remove'] && $_SESSION['access_level'] >= 2) {
                    $id = $_GET['remove'];
                    $week = get_dbWeeks($id);
                    if ($week) {
                        if ($week->get_status() == "unpublished" || $week->get_status() == "archived") {
                            delete_dbWeeks($week);
                            add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' .
                                          $_SESSION['f_name'] . ' ' . $_SESSION['l_name'] .
                                          '</a> removed the week of <a href=\"calendar.php?id=' . $week->get_id() .
                                          '&edit=true\">' . $week->get_name() . '</a>.');
                            echo "<p>Week \"" . $week->get_name() . "\" removed.<br>";
                        }
                        else {
                            echo "<p>Week \"" . $week->get_name() . "\" is published, so it cannot be removed.<br>";
                        }
                        include('addWeek_newweek.inc');
                    }
                }
                else {
                    // If the user submitted a form through "addweek_newweek.inc", this flag will be in their POST-data, and we can process their form
                    if (array_key_exists('_submit_check_newweek', $_POST)) {
                        process_form($firstweek);
                    }
                    include('addweek_newweek.inc');
                }
            }
            // must be a manager
            function process_form($firstweek) {

                if ($_SESSION['access_level'] < 2) {
                    return null;
                }
                if ($firstweek) {
                    //find the beginning of the week
                    $timestamp = mktime(0, 0, 0, $_POST['month'], $_POST['day'], $_POST['year']);
                    $dow = date("N", $timestamp);
                    $m = date("m", mktime(0, 0, 0, $_POST['month'], $_POST['day'] - $dow + 1, $_POST['year']));
                    $d = date("d", mktime(0, 0, 0, $_POST['month'], $_POST['day'] - $dow + 1, $_POST['year']));
                    $y = date("y", mktime(0, 0, 0, $_POST['month'], $_POST['day'] - $dow + 1, $_POST['year']));
                    generate_populate_and_save_new_week($m, $d, $y);
                }
                else {
                    $timestamp = $_POST['_new_week_timestamp'];
                    $m = date("m", $timestamp);
                    $d = date("d", $timestamp);
                    $y = date("y", $timestamp);
                    // finds the last week, and calculates next week's groups
                    //$week = get_dbWeeks($m.'-'.$d.'-'.$y);
                    generate_populate_and_save_new_week($m, $d, $y);
                }
            }

            // uses the master schedule to create a new week in dbWeeks and
            // 7 new dates in dbDates and new shifts in dbShifts
            //
            function generate_populate_and_save_new_week($m, $d, $y) {
                // set the group names the format used by master schedule
                $weekdays = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
                $day_id = $m . "-" . $d . "-" . $y;
                $dates = [];
                foreach ($weekdays as $day) {
                    $venue_shifts = get_master_shifts("weekly", $day);
                    /* Each row in the array is an associative array
                     *  of (venue, my_group, day, time, start, end, slots, persons, notes)
                     *  and persons is a comma-separated string of ids, like "alex2077291234"
                     */
                    $shifts = [];
                    if (sizeof($venue_shifts) > 0) {
                        foreach ($venue_shifts as $venue_shift) {
                            $shifts[] = generate_and_populate_shift($day_id, "weekly", $day,
                                                                    $venue_shift->get_time(), "");
                        }
                    }

                    // makes a new date with these shifts
                    $new_date = new BSCAHdate($day_id, $shifts, "","");
                    $dates[] = $new_date;
                    $d++;

                    $day_id = date("m-d-y", mktime(0, 0, 0, $m, $d, $y));
                }
                // creates a new week from the dates
                $newweek = new Week($dates, "unpublished");
                insert_dbWeeks($newweek);
                add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                              $_SESSION['l_name'] . '</a> generated a new week: <a href=\"calendar.php?id=' .
                              $newweek->get_id() . '&edit=true\">' . $newweek->get_name() . '</a>.');
            }

            // makes new shifts, fills from master schedule
            //!
            // TODO: Remove this functionality, you should not be able to add people to master schedule
            function generate_and_populate_shift($day_id, $venue,$day, $time, $note) {
           
                $newShift = new Shift($day_id . "-" . $time, $venue, "", "", "", $note);
                return $newShift;

            }

            // displays form errors (only for first week)
            function show_errors($e) {
                //this function should display all of our errors.
                echo("<p><ul>");
                foreach ($e as $error) {
                    echo("<li><strong><font color=\"red\">" . $error . "</font></strong></li>\n");
                }
                echo("</ul></p>");
            }

        ?>
        <?PHP include('footer.inc'); ?>
    </div>
</div>
</body>
</html>