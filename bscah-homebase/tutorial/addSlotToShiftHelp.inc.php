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
    <strong>How to Add or Remove a Slot from a Shift</strong>
<p>
    To begin, you must have already selected <strong>(edit this week)</strong>
    at the top of the calendar:
<p>
    <B>Step 1:</B> Click on a calendar shift, like this:<BR> <BR> <a
        href="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png"
        class="image" title="addSlotToShiftHelp_choose_shift.png"
        horizontalalign="center"
        target="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png"
            rel="popover"
            data-img="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png"
            width="10%" border="1px" align="center"> </a> <br> <br> (Each upcoming
    calendar shift will turn gray whenever the mouse passes over it.)
<p>
    <B>Step 2:</B> This will give you a shift form that looks like this:<BR>
    <BR> <a href="tutorial/screenshots/slot.png"
            class="image" title="slot.png"
            horizontalalign="center"
            target="tutorial/screenshots/slot.png">
        &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/slot.png"
            rel="popover"
            data-img="tutorial/screenshots/slot.png"
            width="10%" border="1px" align="center"> </a>
<p>
    <B>Step 3:</B> You can now remove the slot if you want 
<p>
    <B>Step 4:</B> You can return to any other function by selecting it on
    the navigation bar.