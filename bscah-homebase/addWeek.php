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
            <a href="index.php"</a>
            <?PHP include_once('header.php'); ?>
            <?php include_once('accessController.php'); ?>
            <div id="content">
                <p>
                    <strong>Calendar Week Management</strong>
                    <br/>
                    Here you can add new weeks to the calendar and you can edit weeks that are already there.
                    <br>
                    Click the "Add new week" button for adding a new week, or select an option at the right of an existing week.
                </p>
                <hr/>
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

                    if (array_key_exists('publish', $_GET)) {
                        publish_week($_GET['publish']);
                    }
                    else if (array_key_exists('remove', $_GET)) {
                        remove_week($_GET['remove']);
                    }
                    else if (array_key_exists('start_date', $_POST)) {
                        // If the week-creation process fails, show the user an error
                        if (!generate_new_week(new DateTime($_POST['start_date']))) {
                            echo '<div style="font-weight: bold; color: red">ERROR: Could not create week object because the start-date that you selected wasn\'t a Sunday</div> ';
                        }
                    }

                    include_once('addWeek_newweek.inc');
                    include_once('footer.inc');
                ?>
            </div>
        </div>
    </body>
</html>

<?php
    function publish_week($id) {
        $week = get_dbWeeks($id);
        $weekStatus = $week->get_status();
        if ($weekStatus == "unpublished") {
            $week->set_status("published");
        }
        else if ($weekStatus == "published") {
            $week->set_status("unpublished");
        }
        update_dbWeeks($week);
        add_log_entry(sprintf(
                          '<a href="personEdit.php?id=%s">%s %s</a> %s the week of <a href="calendar.php?id=%s&edit=true">%s</a>.',
                          $_SESSION['_id'],
                          $_SESSION['f_name'],
                          $_SESSION['l_name'],
                          $week->get_status(),
                          $week->get_id(),
                          $week->get_name()
                      ));
        echo '<p>Week "' . $week->get_name() . '" ' .
            $week->get_status() . ".<br>";
    }

    function remove_week($id) {
        $week = get_dbWeeks($id);
        if ($week) {
            if ($week->get_status() == "unpublished" || $week->get_status() == "archived") {
                delete_dbWeeks($week);
                add_log_entry(sprintf(
                                  '<a href="personEdit.php?id=%s">%s %s</a> removed the week of <a href="calendar.php?id=%s&edit=true">%s</a>.',
                                  $_SESSION['_id'],
                                  $_SESSION['f_name'],
                                  $_SESSION['l_name'],
                                  $week->get_id(),
                                  $week->get_name()
                              ));
                echo '<p>Week "' . $week->get_name() . '" removed.<br>';
            }
            else {
                echo '<p>Week "' . $week->get_name() . ' is published, so it cannot be removed.<br>';
            }
        }
    }

    /**
     * uses the master schedule to create a new week in dbWeeks and
     * 7 new dates in dbDates and new shifts in dbShifts
     *
     * @param DateTime $date The Sunday that this week starts with
     * @return false if the week-creation process fails
     */
    function generate_new_week(DateTime $date) {
        // set the group names the format used by master schedule
        $weekdays = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
        $dates = [];      
        foreach ($weekdays as $day) {
            $venue_shifts = get_master_shifts($venue, $day);
            /* Each row in the array is an associative array
             *  of (venue, my_group, day, time, start, end, slots,notes)
             */
            $shifts = [];
            foreach ($venue_shifts as $venue_shift) {
                /** @noinspection PhpUndefinedMethodInspection */
                $shifts[] = generate_and_populate_shift($date->format("m-d-y"), $venue,
                                                        $venue_shift->get_start_time(),$venue_shift->get_end_time(), "");
            }

            // makes a new date with these shifts
            $new_date = new BSCAHdate($date->format("m-d-y"), $shifts, "","");

            // Exits this method if the ID was not properly set in the constructor
            if ($new_date->get_id() == null) {
                return false;
            }

            $dates[] = $new_date;
            $date->modify("+1 day");
        }

        // creates a new week from the dates
        // Week is set to "archived" if the week has already passed, otherwise is set to "unpublished"
        $newweek = new Week($dates, $date->getTimestamp() < time() ? "archived" : "unpublished");

        if ($newweek == null) {
            return false;
        }

        $insert_status = insert_dbWeeks($newweek);
        add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                      $_SESSION['l_name'] . '</a> generated a new week: <a href=\"calendar.php?id=' .
                      $newweek->get_id() . '&edit=true\">' . $newweek->get_name() . '</a>.');

        return $insert_status;
    }

    // makes new shifts, fills from master schedule
    // TODO: Remove this functionality, you should not be able to add people to master schedule
    function generate_and_populate_shift($day_id, $venue, $start, $end, $note) {
        $newShift = new Shift($day_id,$start,$end, $venue, "","", "",$note);
        return $newShift;

    }


    // TODO: Why is this here? It should probably be somewhere else since it isn't even used in this file.
    /*
     * displays form errors (only for first week)
     */
    function show_errors($e) {
        //this function should display all of our errors.
        echo("<p><ul>");
        foreach ($e as $error) {
            echo("<li><strong><span style=\"color: red; \">" . $error . "</span></strong></li>\n");
        }
        echo("</ul></p>");
    }
?>
