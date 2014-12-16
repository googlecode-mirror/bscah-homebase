<?php
/**
 * This class contains helper methods and dependencies for using FullCalendar. Simply include it in any PHP
 * script that is supposed to use FullCalendar to get your dependencies.
 * IMPORTANT: Because of conflicts with the jQuery 1.x versions that are included in header.php, and because FullCalendar
 * requires jQuery 2.x, we cannot use jQuery as we normally would.
 * To avoid conflicts, we are assigning jQuery 1.x to "$" and jQuery 2.x to "jQ2". So in any reference to jQuery
 * where FullCalendar is used, you must replace any reference to "$" with "jQ2"
 */

/**
 * Tips on using FullCalendar:
 * 1) ALWAYS use jQ2 when referring to jQuery, not $. $ is broken because header.php overrides it to be jQuery 1.x,
 * which is too old to work properly with FullCalendar.
 * 2) Everything is set via a JSON in FullCalendar. The bread-and-butter of FullCalendar is the Javascript method
 * `jQ2("#divId").fullCalendar({json});`, where you pass in a JSON that contains all related information. For an example
 * JSON, please see the weekly calendar PHP script.
 * 3)
 */
?>

<!-- Import all JS dependencies for FullCalendar -->

<!-- jQuery 2.x -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<!-- FullCalendar and related libraries -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.3/fullcalendar.min.css" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.3/fullcalendar.min.js" type="text/javascript"></script>

<!-- Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>


<!-- Custom FullCalendar stylesheet -->
<style>
    /* For some reason, FullCalendar doesn't set its height to auto by default, so we force that here */
    .fc-time-grid-container {
        height: auto !important;
    }
    /* Make the borders around events thicker */
    .fc-time-grid-event {
        border-width: 0.3em;
    }
</style>


<!-- Custom JS helper methods for use in constructing the FullCalendar JSONs -->
<script type="text/javascript">
    // This is very important to avoid jQuery 2.x getting clobbered by the 1.x imported by header.php
    // All references to jQuery MUST use "jQ2" where normal jQuery would use "$", or you will get cryptic errors.
    var jQ2 = jQuery.noConflict();



    /**
     * Gets the first date that we want to view. This is either the date of the ID parameter in the URL,
     * or if that is not present, the earliest date in our JSON.
     * Note that FullCalendar always starts its weeks on a Sunday (can be changed in the constructor-method via a JSON
     * parameter). So if you give it a Tuesday, for example, it goes back to the last Sunday and starts there.
     * @return {String} a YYYY-MM-DD representation of the start-date
     */
    function getStartDate(json) {
        var id = <?php echo '"'.$_GET['id'].'"'?>;

        if (id == "") {
            return json[0].start;
        }

        return moment(id, "MM-DD-YY").format("YYYY-MM-DD");
    }

    /**
     * @return {HTMLElement} Unordered list that represents the JS array passed in
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

    /**
     * Shows the modal for the weekly calendar
     */
    function showModal(event, jsEvent, view) {
        jQ2('#modal-vacancies').html('<span style="color: ' + event.color + '">' + event.vacancies + '</span> vacancies remaining');
        jQ2('#modal-persons').html(makeUL(event.persons));
        jQ2('#calendar-modal').modal();
    }

    /**
     * Reflows the calendar and relabels the last time-slot as "overnight". This should be set as the callback method
     * for the "eventAfterAllRender" property in your FullCalendar JSON.
     */
    function reflowCalendar(view) {
        // Gets the 2nd-to-last row of the table, which is the row with the last label for time,
        // and replaces its text with "Overnight"
        jQ2(jQ2('.fc-axis.fc-time.fc-widget-content').get(-2)).find("span").text("Overnight");


        // We have to trick FullCalendar into thinking the window was resized
        // so that it re-renders the calendar. This keeps the "Overnight" label from flowing out of its box
        jQ2(document).ready(function() {
            jQ2(window).trigger('resize');
        });
    }

</script>