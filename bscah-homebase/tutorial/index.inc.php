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
    session_start();
    session_cache_expire(30);
?>
<html>
<head>
    <title>Bed-Study Homebase</title>
</head>
<body>
<p>
    <strong>Help Information for BSCAH's Homebase</strong>
</p>
<ol>
    <li><a href="?helpPage=quickStartGuide.php">Quick Start Guide</a>
    </li>
    <br>

    <li><a href="?helpPage=login.php">Signing in and out of the System</a>
    </li>
    <br>
    <ul>
        <li><a href="?helpPage=index.php">About your Personal Home Page</a></li>
    </ul>
    <br>
    <li><strong>Working with the Volunteer Database</strong></li>
    <br>
    <ul>
        <li><a href="?helpPage=searchPeople.php">Searching for a Volunteer</a></li>
        <li><a href="?helpPage=rmh.php">Adding a Volunteer</a></li>
    </ul>
    <br>
    <li><strong>Working with the Project Database</strong></li>
    <br>
    <ul>
        <li><a href="?helpPage=addProject.php">Adding Projects</a></li>
        <li><a href="?helpPage=editProject.php">Searching for/Editing Projects</a></li>
    </ul>
    <br>
    <li><strong>Working with the Project Calendar</strong></li>
    <br>
    <ul>
        <li><a href="?helpPage=generateWeek.php">Generating and publishing
                new calendar weeks</a></li>
        <p>


        <ul>
            <li><a href="?helpPage=cancelShift.php">Editing/Canceling a Shift
                    (Volunteers Only)</a></li>
            <li><a href="help.php?helpPage=addSlotToShift.php">Adding/removing a
                    slot (Managers Only)</a></li>
            <li><a href="help.php?helpPage=addPersonToShift.php">Adding/removing
                    a person from a shift</a></li>
        </ul>
        <p>


        <li><a href="?helpPage=addNotes.php">Adding notes</a></li>
        <li><a href="?helpPage=navigateThroughWeeks.php">Navigate to
                Different Weeks</a></li>

    </ul>
    <br>
    <li><a href="?helpPage=addWeek.php">Working with the Master
            Schedule</a> (Managers Only)
    </li>
    <br>
    <li><a href="?helpPage=reports.php">Generating Reports</a> (Managers
        Only)
    </li>

</ol>
<p>
    If these help pages don't answer your questions, please contact the <a
        href="mailto:volunteers@bedstuyagainsthunger.org">Volunteer Coordinator</a> or call the
    front desk (207-780-6282).
</p>
</body>
</html>



