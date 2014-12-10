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

<p> </p>
    <strong>Information about Your Personal Home Page</strong>
<p>Whenever you log into BSCAH's Homebase, some useful personal information will
    appear.
<p> </p> 
<B>If you are a volunteer</B> and you would like to check out our current project so you can sign up for one and start volunteering, please click <strong><a href="currentProjectDetailed.php">Current Projects</a></strong>
<p>If you would like more information on what projects are and what you would do, please click <strong><a href="projectInfo.php">Project Info</a></strong>
<p>If you would like to check out the schedule's of the volunteer projects, please click <strong><a href="viewSchedule.php?frequency=garden">Garden</a></strong> for the garden schedule or <strong><a href="viewSchedule.php?frequency=pantry">Pantry</a></strong> for the pantry schedule, 
   or you can even click <strong><a href="calendar.php">Project Calender</a></strong> (only for managers) to know which projects are published and which are unpublished. 
<p> </p> <strong>If your a manager </strong> and you would like more information on the project calendar please visit the Working With The Calendar Help Page - <strong><a href="generateWeekHelp.inc.php">Generating and Publishing New Calendar Weeks</a></strong>
<p> </p>  
        <strong> On the Homepage:</strong> <p> 
    You will also see a display of your upcoming
    scheduled shifts, which looks like this: <p>
        <a
        href="tutorial/screenshots/indexHelp_upcoming_shifts.png"
        class="image" title="indexHelp_upcoming_shifts.png"
        target="tutorial/screenshots/indexHelp_upcoming_shifts.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/indexHelp_upcoming_shifts.png" width="10%"
            rel="popover"
            data-img="tutorial/screenshots/indexHelp_upcoming_shifts.png"
            border="1px" align="center"> </a> <br> <p> If you need to cancel a shift,
    please call the front desk (302-656-4847).
    
        <p> </p> 
    <B>If you are a manager</B>, you will also see the following current
    information displayed:
<p>
    A log of the most recent schedule changes, which looks like this: <p> 
    <a
        href="tutorial/screenshots/indexHelp_recent_changes.png" class="image"
        title="indexHelp_recent_changes.png"
        target="tutorial/screenshots/indexHelp_recent_changes.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/indexHelp_recent_changes.png" width="10%"
            rel="popover"
            data-img="tutorial/screenshots/indexHelp_recent_changes.png"
            border="1px" align="center"> </a> <br>
            
           <p>
    A list of upcoming birthdays and volunteer anniversaries, which looks
    like this: <p> 
                <a
        href="tutorial/screenshots/indexHelp_upcoming_birthdays.png"
        class="image" title="indexHelp_upcoming_birthdays.png"
        target="tutorial/screenshots/indexHelp_upcoming_birthdays.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/indexHelp_upcoming_birthdays.png"
            width="10%" rel="popover"
            data-img="tutorial/screenshots/indexHelp_upcoming_birthdays.png"
            border="1px" align="center"> </a>
<p>
                -    A list of upcoming calendar vacancies, which looks like this: <p> 
                <a
        href="tutorial/screenshots/indexHelp_upcoming_vacancies.png"
        class="image" title="indexHelp_upcoming_vacancies.png"
        target="tutorial/screenshots/indexHelp_upcoming_vacancies.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/indexHelp_upcoming_vacancies.png"
            width="10%" rel="popover"
            data-img="tutorial/screenshots/indexHelp_upcoming_vacancies.png"
            border="1px" align="center"> </a> <br> 
<p>