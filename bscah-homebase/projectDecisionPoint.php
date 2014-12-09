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
       
    }
    else {
        if ($_SESSION['access_level'] == 2) {
            if ($id == 'new') {
                echo('<p><strong>Project Edit Form</strong><br />');
                echo('<p>Which type of project would you like to add?<br/>');

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
        <p>Project Type
      <?PHP    
      $project_types = ['Fundraising', 'Team Building'];
            echo '<select name="type">' . '<option value= ""></option>';
            foreach ($project_types as $type) 
            {
                echo '<option value="' . $type . '">' . $type . '</option>';
            }
        
            echo '</select>';
            
        
        ?>
       <input type="submit" value="Submit">
       </form>
           
<?PHP


