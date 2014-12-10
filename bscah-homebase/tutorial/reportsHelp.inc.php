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
    <BR> <a href="tutorial/screenshots/Reports.png" class="image"
            title="Reports.png" horizontalalign="center"
            target="tutorial/screenshots/Reports.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/Reports.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/Reports.png"
            border="1px" align="center"> </a>
    <br>
<p> 
    Here you may generate a report on a single volunteer's hours, total hours by all volunteers, or
    shifts and vacancies.
<p>
    <B>Step 2:</B> If you wish to see a report on a specific volunteer, under "Select Report Hours:"
    choose <B>Individual Hours.</B><BR> <p> 
    <a href="tutorial/screenshots/ReportsIndividualHours.png" class="image"
       title="ReportsIndividualHours.png" horizontalalign="center"
       target="tutorial/screenshots/ReportsIndividualHours.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/ReportsIndividualHours.png" width="10%" rel="popover"
            data-img="tutorial/screenshots/ReportsIndividualHours.png" border="1px"
            align="center"> </a> <p> 

            <br>Enter the volunteer's name in the appropriate text box and select the date range. <p> 
    <BR> <a href="tutorial/screenshots/ReportsIndividuals.png" class="image"
            title="ReportsIndividuals.png" horizontalalign="center"
            target="tutorial/screenshots/ReportsIndividuals.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/ReportsIndividuals.png" width="10%" rel="popover"
            data-img="tutorial/screenshots/ReportsIndividuals.png" border="1px"
            align="center"> </a> <BR>
    <BR> Note that when you type in a few letters, a box should appear with
    names containing those letters. You can choose the name by clicking it.
    <BR>
    <BR> <a href="tutorial/screenshots/reportsstep2-2.png" class="image"
            title="reportsstep2-2.png" horizontalalign="center"
            target="tutorial/screenshots/reportsstep2-2.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reportsstep2-2.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reportsstep2-2.png"
            border="1px" align="center"> </a> <BR>
    <BR>If you wish to look at more than one volunteer, click on the "Add More" button located
    right underneath the "Select Individual" text box.<BR>
    <br>
    <B>Step 3:</B> To view total volunteer hours, select "Total Hours."<BR>
    <BR>
    <a href="tutorial/screenshots/ReportsTotalHours.png" class="image"
       title="ReportsTotalHours.png" horizontalalign="center"
       target="tutorial/screenshots/ReportsTotalHours.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/ReportsTotalHours.png" width="10%" rel="popover"
            data-img="tutorial/screenshots/ReportsTotalHours.png" border="1px"
            align="center"> </a> <BR>
    <br> Again, select the date range and click the "Submit" button.
    <br>
    <BR><B>Step 4:</B> To view shifts staffed and vacancies, select "Shifts/Vacancies."<BR>
    <BR>
    <a href="tutorial/screenshots/ReportsShifts.png" class="image"
       title="ReportsShifts.png" horizontalalign="center"
       target="tutorial/screenshots/ReportsShifts.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/ReportsShifts.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/ReportsShifts.png"
            border="1px" align="center"> </a>
    <br><br>Select the date range and click the "Submit" button.
<p>
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
    <BR>And the report for <B>Shifts Staffed/Vacant</B> (by day) may look
    like this: <BR>
    <BR> <a href="tutorial/screenshots/reportsstep6-3.png" class="image"
            title="reportsstep6-3.png" horizontalalign="center"
            target="tutorial/screenshots/reportsstep6-3.png"> &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/reportsstep6-3.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/reportsstep6-3.png"
            border="1px" align="center"> </a> <BR>
<p>
    <B>Step 6:</B> When you finish, you can generate a new report by
    refreshing the page and following the steps above or return to any
    other function by selecting it on the navigation bar.
<p>
    Keep in mind: <p> 
    - When your generating the reports you cant put a date (time period) of more than 4 years. <p>
    - If your time period is more than a year, expect a longer wait to generate the results (couple seconds)