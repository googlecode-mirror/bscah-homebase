<?php
/*
 * This program is part of BSCAH, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 *
 *
 * @author Kevin Most
 * @version 2014-12-01
 * The new frontend for the Weekly Calendar
 */
session_start();
session_cache_expire(30);

// TODO: It might be nice if we could use the modal that pops up when clicking an event to add new
// volunteers without having to go to a new page at all.
?>

<html>
<head>
    <title>Calendar Viewing</title>

    <?php include_once("fullcalendar.inc")?>
    <script type="text/javascript">
        /**
         * Creates the FullCalendar object in <div id="calendar"> HTML element
         * @param json The JSON returned from the PHP function "get_fullcalendar_json(Week $week)"
         */
        function makeCalendar(json) {
            // WARNING: Please always use "jQ2" to refer to jQuery instead of "$". There is a conflict in our project; "$" is jQuery 1.9
            jQ2(document).ready(function() {
                // The options that are available to you are detailed in the FullCalendar.io docs: http://fullcalendar.io/docs/
                // All FullCalendar customization is done simply by attaching a new field to this JSON
                jQ2("#calendar").fullCalendar({
                    events: json,

                    editable: false,

                    defaultView: 'agendaWeek',
                    defaultDate: getStartDate(json),

                    // These are magic strings, check: http://fullcalendar.io/docs/display/header/ for valid inputs
                    header: {
                        left: '',
                        center: 'title',
                        right: 'today prev,next'
                    },

                    allDaySlot: false,
                    minTime: '09:00:00',
                    maxTime: '22:00:00', // We set this to end at 10PM, because we are going to rename the 9-10PM slot to "overnight"

                    eventClick: function(event, jsEvent, view) {
                        showModal(event, jsEvent, view);
                    },

                    eventAfterAllRender: function(view) {
                        reflowCalendar(view);
                    }
                })
            })
        }


    </script>

    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <link rel="stylesheet" href="calendarhouse.css" type="text/css"/>


</head>

<body>
<div id="container">
    <?php
    echo "<a href=\"index.php\">";
    include_once("header.php");
    echo "</a>";
    include_once('accessController.php');
    ?>
    <div id="content">
        <?php

        include_once('database/dbWeeks.php');
        include_once('calendarhouse_new.inc');

        $edit = ($_GET['edit'] == "true") ? true : false;
        $venue = $_GET['venue'];
        $week_id = $_GET['id'];


        // If no week ID set, default to the current week
        if (!$week_id) {
            $week_id = date("m-d-y", time());
        }

        $week = get_dbWeeks($week_id);


        if ($week == null || $week->get_status() == "unpublished") {
            echo "This week's calendar is not available for viewing.";
            if ($_SESSION['access_level'] >= 2) {
                echo "<br/> <a href='addWeek.php'>Manage weeks</a>";
            }
        } else {
            ?>
            <div style="text-align: center">
                <form method="get" action="addWeek.php">
                    <button type="submit">Manage weeks</button>
                </form>
            </div>
            <script type="text/javascript">
                makeCalendar(<?php echo get_fullcalendar_json(); ?>)
            </script>

            <!-- The fullcalendar_display() function will use Javascript to populate this div with content -->
            <div style="padding: 0 10%" id="calendar"></div>

            <!-- Bootstrap modal -->
            <div id="calendar-modal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <h3 id="modal-vacancies"></h3>
                        <h3>Currently-registered volunteers:</h3>
                        <div id="modal-persons"></div>
                    </div>
                </div>
            </div>

        <?php
        }
        include_once("footer.inc");
        ?>


    </div>
</div>
</body>
</html>