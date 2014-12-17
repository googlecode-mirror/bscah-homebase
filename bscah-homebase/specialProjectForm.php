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
     * 	projectForm.inc
     *  shows a form for a project to be added or edited in the database
     * 	@author Oliver Radwan and Allen Tucker
     * 	@version 9/1/2008, revised 4/1/2012
     */

    if ($_SESSION['access_level'] == 1) {
        if ($_SESSION['_id'] != $project->get_id()) {
            echo("<p id=\"error\">You do not have sufficient permissions to edit this project.</p>");
            include('footer.inc');
            echo('</div></div></body></html>');
            die();
        }
        else {
            echo('<p><strong>Special Project Edit Form</strong><br />');
            echo('Here you can edit your fundrasing project information in the database.' .
                '<br>When you are finished, hit <b>Submit</b> at the bottom of this page.');
        }
    }
    else {
        if ($_SESSION['access_level'] == 2) {
            if ($id == 'new') {
            
                echo('<p><strong>Special Project Form</strong><br />');
                echo('Here you can add a new fundraising project into the database. </p>');

            }
            else {
                echo("<p id=\"error\">You do not have sufficient permissions to add a new project to the database.</p>");
                include('footer.inc');
                echo('</div></div></body></html>');
                die();
            }
        }
    }
?>

<form method="POST">
    <input type="hidden" name="old_id" value=<?PHP echo($id); ?>>
    <input type="hidden" name="_form_submit" value="1">

    <p>(<span style="font-size:x-small;color:FF0000">*</span> denotes required fields)

    <p>Sponsor Name<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="name" tabindex="1"
                                                                         value="<?PHP echo($project->get_name()) ?>">

    <p>Sponsor's Volunteers<span style="font-size:x-small;color:FF0000"></span>:<input type="text" name="persons" tabindex="2"
                                                                            value="<?PHP echo($project->get_persons()) ?>">

    <p>Donations ($)<span style="font-size:x-small;color:FF0000">*</span>: <input
            type="number" name="donations" tabindex="3" value="<?PHP echo($project->get_persons()) ?>">

<?PHP

    echo('<p>Fundraiser Description:<br />');
    echo('<textarea name="notes" rows="2" cols="60">');
    echo($project->get_project_description());
    echo('</textarea></fieldset>');
    echo "<br />\n";
    echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete this application.<br /><br />');
 ?>
    </form>
 


