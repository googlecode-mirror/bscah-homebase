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
    <B>Step 1:</B> On the navigation bar at the top of the page, find <B>reports</B>.
    <BR>Click on it and you should see the following page: <BR>
    <BR> <a href="tutorial/screenshots/reports1.png" class="image"
            title="reports1.png" horizontalalign="center"
            target="tutorial/screenshots/reports1.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reports1.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reports1.png"
            border="1px" align="center"> </a>
    <br>
<p> 
    Here you may generate a report on a single volunteer's hours, total hours by all volunteers, or
    shifts and vacancies.
<p>
    <B>Step 2:</B> If you wish to see a report on a specific volunteer, under "Select Report Hours:"
    choose <B>Individual Hours.</B><BR> <p> 
    <a href="tutorial/screenshots/reports2.png" class="image"
            title="reports2.png" horizontalalign="center"
            target="tutorial/screenshots/reports2.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reports2.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reports2.png"
            border="1px" align="center"> </a> <p> 

            <br>Enter the volunteer's name in the appropriate text box and select the date range. <p> 
    
    Note that when you type in a few letters, a box should appear with
    names containing those letters. You can choose the name by clicking it. <p> 
    <BR>If you wish to look at more than one volunteer, click on the "Add More" button located
    right underneath the "Select Individual" text box.<BR>
    <br>
    <B>Step 3:</B> To view total volunteer hours, select "Total Hours."<BR>
    <BR>
    <a href="tutorial/screenshots/reports3.png" class="image"
            title="reports3.png" horizontalalign="center"
            target="tutorial/screenshots/reports3.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reports3.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reports3.png"
            border="1px" align="center"> </a> <BR>
    <br> Again, select the date range and click the "Submit" button.
    <br>
    <BR><B>Step 4:</B> To view shifts staffed and vacancies, select "Shifts/Vacancies."<BR>
    <BR>
    <a href="tutorial/screenshots/reports4.png" class="image"
            title="reports4.png" horizontalalign="center"
            target="tutorial/screenshots/reports4.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reports4.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reports4.png"
            border="1px" align="center"> </a>
    <br><br>Select the date range and click the "Submit" button.
<p>
    To view total project hours, select that: <p>
        <a href="tutorial/screenshots/reports5.png" class="image"
            title="reports5.png" horizontalalign="center"
            target="tutorial/screenshots/reports5.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reports5.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reports5.png"
            border="1px" align="center"> </a>
</p>
To view project vacancies, select that: <p>
    <a href="tutorial/screenshots/reports6.png" class="image"
            title="reports6.png" horizontalalign="center"
            target="tutorial/screenshots/reports6.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reports6.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reports6.png"
            border="1px" align="center"> </a>
</p>
    
    <B>Step 5:</B> <BR>The report for <B>Volunteer Names</B> (and total
    hours) may look like this:<BR> <BR> <a
        href="tutorial/screenshots/reportsstep6.png" class="image"
        title="reportsstep6.png" horizontalalign="center"
        target="tutorial/screenshots/reportsstep6.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reportsstep6.png" width="10%" rel="popover"
            data-img="tutorial/screenshots/reportsstep6.png" border="1px"
            align="center"> </a> <BR> <p> 
    The number under a day (eg. Mon) indicates
    the total hours worked on that day. In our example, Amy Jones did not
    work any hours from 11/03/2013 - 12/09/2013. <BR>
    <BR>The report for <B>Volunteer Hours</B> (by day) may look like this:
    <BR>
    <BR> <a href="tutorial/screenshots/reportsstep6-2.png" class="image"
            title="reportsstep6-2.png" horizontalalign="center"
            target="tutorial/screenshots/reportsstep6-2.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reportsstep6-2.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reportsstep6-2.png"
            border="1px" align="center"> </a> <BR>
    <BR>The report for <B>Shifts Staffed/Vacant</B> (by day) may look
    like this: <BR>
    <BR> <a href="tutorial/screenshots/reportsstep6-3.png" class="image"
            title="reportsstep6-3.png" horizontalalign="center"
            target="tutorial/screenshots/reportsstep6-3.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reportsstep6-3.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reportsstep6-3.png"
            border="1px" align="center"> </a> <BR>
    <BR>The report for <B>Total Volunteer Shift Hours</B> (by day) may look
    like this: <BR>
    <BR> <a href="tutorial/screenshots/TotalVolunteerShiftHours.png" class="image"
            title="TotalVolunteerShiftHours.png" horizontalalign="center"
            target="tutorial/screenshots/TotalVolunteerShiftHours.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/TotalVolunteerShiftHours.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/TotalVolunteerShiftHours.png"
            border="1px" align="center"> </a> <BR> <p> 
NOTE: The hour(s):minutes(s) in left end of the table is the time; The rest is the number of hours and minutes totaled 
<p>
    <B>Step 6:</B> When you finish, you can generate a new report by
    refreshing the page and following the steps above or return to any
    other function by selecting it on the navigation bar.
<p>
    Keep in mind: <p> 
    - When your generating the reports you cant put a date (time period) of more than 4 years. <p>
    - If your time period is more than a year, expect a longer wait to generate the results (couple seconds)