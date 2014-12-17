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
    <strong>How to Search for People in the Database</strong>
<p>
    <B>Step 1:</B> On the navigation bar at the top of the page, find <B>volunteers:</B>
    and select <B>search</B>. And you should see a page that looks like this: 
<p> <a
        href="tutorial/screenshots/volunteersearch.png" class="image"
        title="volunteersearch.png" horizontalalign="center"
        target="tutorial/screenshots/volunteersearch.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/volunteersearch.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/volunteersearch.png"
            border="1px" align="middle"> </a>
    
</p>
<br>
<p>
    <B>Step 2:</B> The search criteria contains four parts:
<p>
    1. The <B>type</B>: volunteer, manager, or guest. <BR> <BR> <a
        href="tutorial/screenshots/VolunteerType.png" class="image"
        title="VolunteerType.png" horizontalalign="center"
        target="tutorial/screenshots/VolunteerType.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/VolunteerType.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/VolunteerType.png"
            border="1px" align="middle"> </a>
</p>
<p>
    2. The <B>status</B> of the volunteer: applicant or approved.<BR> <BR> <a
        href="tutorial/screenshots/VolunteerStatus.png" class="image"
        title="VolunteerStatus.png" horizontalalign="center"
        target="tutorial/screenshots/VolunteerStatus.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/VolunteerStatus.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/VolunteerStatus.png"
            border="1px" align="middle"> </a>
</p>
<p>
    3. The volunteer's <B>name</B> can be entered.<BR> <BR> <a
        href="tutorial/screenshots/SearchVolunteer.png" class="image"
        title="SearchVolunteer.png" horizontalalign="center"
        target="tutorial/screenshots/SearchVolunteer.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/SearchVolunteer.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/SearchVolunteer.png"
            border="1px" align="middle"> </a>
</p>
<p>
    4. The <B>availability</B> of the volunteer according to the day(s) they are scheduled to work.<BR> <BR> <a
        href="tutorial/screenshots/VolunteerAvailability.png" class="image"
        title="VolunteerAvailability.png" horizontalalign="center"
        target="tutorial/screenshots/VolunteerAvailability.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/VolunteerAvailability.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/VolunteerAvailability.png"
            border="1px" align="middle"> </a>
</p>
5. The <B>Project Type:</B> Pantry Volunteer, Garden Volunteer, or Building Project Volunteer <p> 
<a
        href="tutorial/screenshots/volunteerProjectType.png" class="image"
        title="volunteerProjectType.png" horizontalalign="center"
        target="tutorial/screenshots/volunteerProjectType.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/volunteerProjectType.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/volunteerProjectType.png"
            border="1px" align="middle"> </a>
<br>
</p> 
<p>
    <B>Step 3:</B> After typing your criteria in the appropriate box,
    select the <B>Search</B> button.
</p>
<br>
<p>
    <B>Step 4:</B> Now you will see a list of the names in the database
    that match your search criteria, like this:<BR> <BR> <a
        href="tutorial/screenshots/searchpersonstep4.png" class="image"
        title="searchpersonstep4.png"
        target="tutorial/screenshots/searchpersonstep4.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/searchpersonstep4.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/searchpersonstep4.png"
            border="1px" align="middle"> </a>
<p>
    Note that the person's phone number will appear next to his/her name: <BR>
    <BR> <a href="tutorial/screenshots/searchpersonstep4-2.png"
            class="image" title="searchpersonstep4.png"
            target="tutorial/screenshots/searchpersonstep4-2.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/searchpersonstep4-2.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/searchpersonstep4-2.png"
            border="1px" align="middle"> </a>
</p>
<p>
    If you see the person you want to view or edit, then <B>click on</B>
    that person's name.
    <br>
    <br>
<p>
    <B>Step 5:</B> If you don't see what you were looking for, you can try
    again by repeating <B>Step 2</B>. <BR> <BR>
</p>
<p>
    <B>Step 6:</B> When you finish, you can return to any other function by
    selecting it on the navigation bar.
