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
    <strong>How to Generate and Publish Future Weeks on the Calendar
        (Managers Only)</strong>
</p>
<p>
    To begin this activity, select <B>(manage weeks)</B> at the top of the project
    calendar page, like this:<BR> <BR> <a
        href="tutorial/screenshots/generateWeekHelp_manage_weeks.png"
        class="image" title="generateWeekHelp_manage_weeks.png"
        target="tutorial/screenshots/generateWeekHelp_manage_weeks.png"> <img
            src="tutorial/screenshots/generateWeekHelp_manage_weeks.png"
            rel="popover"
            data-img="tutorial/screenshots/generateWeekHelp_manage_weeks.png"
            width="10%" border="1px"> </a>
</p>
<p>
    You should then see this page: <p> 
    <a
        href="tutorial/screenshots/manageWeeks.png"
        class="image" title="manageWeeks.png"
        target="tutorial/screenshots/manageWeeks.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/manageWeeks.png"
            rel="popover"
            data-img="tutorial/screenshots/manageWeeks.png"
            width="10%" border="1px" align="center"> </a>
<p>
    Each calendar week in this list has the status <i>archived</i>, <i>published</i>,
    or <i>unpublished</i>.
<ul>
    An
    <i>archived</i> week is any week that is fully in the past (as of the
    current date) -- its calendar cannot be changed.
    <br>A
    <i>published</i> week is is an active calendar week, visible and
    changeable by either managers or volunteers as schedule changes occur.
    <br>An
    <i>unpublished</i> week is a calendar week that is not visible to
    volunteers, and can only be changed or published by a manager.
</ul>
<p>
    The <strong> View Archive/Hide Archive</strong> button in the lower
    right corner of this table allows you to either see or not see the
    archived weeks from the table. (Most of the time you will not need to
    see the archived calendar weeks, so this button will simplify your view
    by showing only current and future scheduled weeks.)
<p>From here, you can do any of the following:
<ul>
    <li>edit a week - edit notes / shifts / projects for that week</li>
    <li>publish a week - publish the week so that it can be viewed by volunteers</li>
    <li>Unpublish a published week</li>
    <li>view - view the week</li>
    <li>remove - remove the week</li> 

</ul>
<p>
    When you add a new week to the calendar, this will populate each day
    and shift with volunteers from the master schedule. Before generating a
    new calendar week it is important to be sure the master schedule is up
    to date. So this tutorial and the tutorial on <strong><a href="?helpPage=addWeek.php">How to Manage the
            Master Schedule</strong></a> go hand-in-hand.
<p>
    And this is how a calendar with published week and projects look like: <p> 
    <a
        href="tutorial/screenshots/viewCalendar.png"
        class="image" title="viewCalendar.png"
        target="tutorial/screenshots/viewCalendar.png"> <img
            src="tutorial/screenshots/viewCalendar.png"
            rel="popover"
            data-img="tutorial/screenshots/viewCalendar.png"
            width="10%" border="1px"> </a>
    
<p>These are the basic steps to follow once you get the hang of it: <p> 
    1. Generate weeks (unpublished) <p> 
    2. Add projects and events to the generated weeks (through project add and garden / pantry calendars) <p> 
    3. Publish the weeks that are ready to go public (which the projects are added to) <p> 
    4. Volunteers join the projects on the published weeks </p>