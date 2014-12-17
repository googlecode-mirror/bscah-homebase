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

    /*
     * 	reports.inc.php
     *   shows a form to search for a data object
     * 	@author Jerrick Hoang
     * 	@version 11/5/2013
     */
?>
<link
    rel="stylesheet" href="lib/jquery-ui.css"/>
<script
    src="lib/jquery-ui.js"></script>
<script
    src="reports.js"></script>

<link rel="stylesheet" href="reports.css" type="text/css"/>

<div id="content">
    <div id="report-table">
        <p id="search-fields-container">

        <form id="search-fields" method="post">
            <input type="hidden" name="_form_submit" value="report"/>

            <p class="search-description" id="today"><b>House Volunteer Hours, Shifts, Projects, and Vacancies</b><br> Report
                date: <?php echo Date("F d, Y"); ?> <br><br>To view hours worked by a volunteer, select Individual Hours<br>To view hours worked by all volunteers, select Total Hours
                <br> To view vacancies in shifts, select Shift Vacancies <br> To view hours worked in all projects, select Total Project Hours<br>To view vacancies in projects, select Project Vacancies <br> The time format is hour(s):minute(s) </p>
            <table>
                <tr>
                    <td class="search-description" valign="top"> Select Report Type:
                        <p><select multiple name="report-types[]" id="report-type" style="height: 87px;">
                                <option value="volunteer-names">Individual Hours</option>
                                <option value="volunteer-hours">Total Shift Hours</option>
                                <option value="shifts-staffed-vacant">Shift Vacancies</option>
                                <option value="project-hours">Total Project Hours</option>
                                <option value="project-staffed-vacant">Project Vacancies</option>
                            </select>
                        </p>
                    </td>
                    <td class="search-description" id="indititle"> Select Individuals:
                        <p id="volunteer-name-inputs"
                           class="ui-widget"><input type="text" name="volunteer-names[]" class="volunteer-name" id="1">
                        </p>
                        <br><br>
                    </td>
                    <td class="search-description" valign="top"> Select Date Range:
                        <input type="radio" name="date" value="date-range">

                        <p id="fromto"> From : <input name="from" type="text" id="from">
                            To : <input name="to" type="text" id="to"></p>
                    </td>
                </tr>
            </table>
            And hit <input type="submit" value="submit" id="report-submit" class="btn">
            
        </form>
        <p id="outputs">

        </p>
    </div>
</div>
