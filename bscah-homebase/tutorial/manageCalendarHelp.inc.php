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
?>

<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script
    src="lib/bootstrap/js/bootstrap.js"></script>

<script>
    $(function () {
        $('img[rel=popover]').popover({
            html: true,
            trigger: 'hover',
            placement: 'right',
            content: function () {
                return '<img border="3" src="' + $(this).data('img') + '" width="60%"/>';
            }
        });
    });
</script>

<p>
    <strong>Working with the Master Schedule and Calendar</strong>
<p>
    The master schedule entails many things, one being the Calendar. So you will get more information on the Calendar through this help page as well. 
<p> to understand the Master Schedule there are 3 main steps you will need to go through:
<p> <b>Step 1:</b> You need to generate a master schedule entry through the open cells on the garden or pantry tabs.
<p> This is what a blank garden calendar looks like under the master schedule: <p> 
    <a
        href="tutorial/screenshots/blankCalendar.png"
        class="image" title="blankCalendar.png"
        target="tutorial/screenshots/blankCalendar.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/blankCalendar.png" width="10%"
            rel="popover"
            data-img="tutorial/screenshots/blankCalendar.png"
            border="1px" align="center"> </a>
<p> 
    When you click on one of the empty cells, this is the page that comes up where you will need to add a shift with a length of time: <p> 
    <a
        href="tutorial/screenshots/addingToMasterSchedule.png"
        class="image" title="addingToMasterSchedule.png"
        target="tutorial/screenshots/addingToMasterSchedule.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/addingToMasterSchedule.png" width="10%"
            rel="popover"
            data-img="tutorial/screenshots/addingToMasterSchedule.png"
            border="1px" align="center"> </a> <p> 
                And this is what the garden calendar under master schedule looks like when you added a shift to it: <p> 
                <a
        href="tutorial/screenshots/calendarWithJob.png"
        class="image" title="calendarWithJob.png"
        target="tutorial/screenshots/calendarWithJob.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/calendarWithJob.png" width="10%"
            rel="popover"
            data-img="tutorial/screenshots/calendarWithJob.png"
            border="1px" align="center"> </a>
            <p> 
                Once you have a filled cell you can click it to view its info or delete the shift. You can also name and/or set the shift length. 
            <p>
                <b>Step 2: </b> Construct a new week using the add week button under the calendar management page. You want to construct the weeks that have shifts and projects added to it. <p> 
                When you add a week to the calendar that will call the the cells generated before with their shifts and lengths and it will be added to the calendar. <p> 
                Once you feel the week is ready to go public, you can publish it; HOWEVER, once the week is published you will not be able to add anymore cells (shifts or projects) on the calendar for that week!
            <p> 
                <b>Step 3:</b> You can now view the populated Calendar from the Project Calendar tab with the weeks that are generated. 
            <p>Here volunteers can view / find shifts and join the projects that are published on these weeks</p>