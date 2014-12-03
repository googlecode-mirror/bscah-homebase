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
    <strong>How to Search/Edit Project Information</strong> 
<p>
    <B>Step 1:</B> On the navigation bar at the top of the page, find <B>Projects</B>
<p> <B> Step 2:</B> Then from there click on the <B>Search</B> tab next to <B>Projects</B> 
</p>
<p>
    <B>Step 3:</B> When you click that it will take you to this page 
</p>
<a
        href="tutorial/screenshots/SearchProject.png" class="image"
        title="SearchProject.png"
        target="tutorial/screenshots/SearchProject.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/SearchProject.png" width="10%"
            rel="popover" data-img="tutorial/screenshots/SearchProject.png"
            border="1px" align="middle"> </a>

<P> Here you will enter information like project name, date, etc. </P>
<B>Step 4:</B> When you are done filling out the information you can hit submit and if there are no errors it will take you to the projects that met your search criteria.
<P> If there were errors it will revert you back to the same page and ask you to correct them before you can move on. Once you've corrected them you can hit submit and continue on with your search.
<P> Once your search is complete you can click on the project your searching for and you can find out more information about it, you can join it, or you can even edit it if you have the rights to.