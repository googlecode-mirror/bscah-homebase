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
    <strong>How to Add Projects to the Database</strong>
<p>
    <B>Step 1:</B> On the navigation bar at the top of the page, find <B>Projects</B>
<p> <B> Step 2:</B> Then from there click on the <B>Add</B> tab next to <B>Projects</B> 
</p>
<p>
    <B>Step 3:</B> That will take you to this form where you enter the volunteer's information such as name, phone,
    address, their shifts, etc. <BR> <BR> <a
        href="tutorial/screenshots/AddProject.png" class="image"
        title="AddProject.png"
        target="tutorial/screenshots/AddProject.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/AddProject.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/AddProject.png"
            border="1px" align="middle"> </a>
</p>

<B>Step 4:</B> Once you completed the form, hit <B>Submit</B> and you have just added a project to the Database. <P>
If you entered anything wrong it will take you back to the same page with error messages and it will ask you to fix them before submitting
<P> When your project is correctly added to the Database, your project will be shown on <B>Project Calendar</B> and it can now be viewed under <B>Project Search</B> as well for other volunteers to view and join!