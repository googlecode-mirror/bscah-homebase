<?php
    /*
     * This program is part of BSCAH, which is free software.  It comes with
     * absolutely no warranty. You can redistribute and/or modify it under the terms
     * of the GNU General Public License as published by the Free Software Foundation
     * (see <http://www.gnu.org/licenses/ for more information).
     *
     *
     * @author Matthew Freitas
     * @version 2014-12-15
     * The new frontend for the Master Calendar
     */

    session_start();
    session_cache_expire(30);

    include_once("fullcalendar.inc");
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
            <?php
                echo "<a href=\"index.php\">";
                include_once("header.php");
                echo "</a>";
                include_once('accessController.php');
            ?>
            <div id="content">
                <?php
                    if ($_SESSION['access_level'] < 2) {
                        die("<p>Only managers can view the master schedule.</p>");
                    }
                    $venue = $_GET['venue'];
                ?>
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
                                    jQ2('#modal-vacancies').html('<span style="color: ' + event.color + '">';
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
                </script>
            </div>
        </div>
    </body>
    <?php include_once("footer.inc"); ?>
</html>