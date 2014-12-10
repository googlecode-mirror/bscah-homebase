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

    <!-- jQuery 2.x -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- FullCalendar and related libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.3/fullcalendar.min.css" type="text/css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.3/fullcalendar.min.js" type="text/javascript"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script type="text/javascript">
        // Gets the current version of jQuery because header.php loads jQuery 1.x into the "$" symbol, which breaks everything
        var jQ2 = jQuery.noConflict();

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
                        jQ2('#modal-vacancies').html('<span style="color: ' + event.color + '">' + event.vacancies + '</span> vacancies remaining');
                        jQ2('#modal-persons').html(makeUL(event.persons));
                        jQ2('#calendar-modal').modal();
                    },

                    eventAfterAllRender: function(view) {
                        // Gets the 2nd-to-last row of the table, which is the row with the last label for time,
                        // and replaces its text with "Overnight"
                        jQ2(jQ2('.fc-axis.fc-time.fc-widget-content').get(-2)).find("span").text("Overnight");


                        // We have to trick FullCalendar into thinking the window was resized
                        // so that it re-renders the calendar. This keeps the "Overnight" label from flowing out of its box
                        jQ2(document).ready(function() {
                            jQ2(window).trigger('resize');
                        });
                    }
                })
            })
        }

        function getStartDate(json) {
            var id = <?php echo '"'.$_GET['id'].'"'?>;

            if (id == "") {
                return json[0].start;
            }

            return moment(id, "MM-DD-YY").format("YYYY-MM-DD");
        }

        /**
         * @returns {HTMLElement} Unordered list that represents the JS array passed in
         */
        function makeUL(array) {
            // Create the list element:
            var list = document.createElement('ul');

            for(var i = 0; i < array.length; i++) {
                // Create the list item:
                var item = document.createElement('li');

                // Set its contents:
                item.appendChild(document.createTextNode(array[i]));

                // Add it to the list:
                list.appendChild(item);
            }

            // Finally, return the constructed list:
            return list;
        }

    </script>

    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <link rel="stylesheet" href="calendarhouse.css" type="text/css"/>

    <!--suppress CssUnusedSymbol -->
    <style>
        .fc-time-grid-container {
            /* For some reason, FullCalendar doesn't set its height to auto by default */
            height: auto !important;
        }
        .fc-event-inner { border: 50000px !important; }
    </style>
</head>

<body>
<div id="container">
    <?php
    include_once("header.php");
    include_once("accessController.php");
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


        if ((!$week)|| ($week->get_status() == "unpublished" )) {
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