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

 if ($_SESSION['access_level'] == 1)
    if ($_SESSION['_id'] != $project->get_id()) {
        echo("<p id=\"error\">You do not have sufficient permissions to edit this project.</p>");
        include('footer.inc');
        echo('</div></div></body></html>');
        die();
    } else {
        echo('<p><strong>Project Edit Form</strong><br />');
        echo('Here you can edit your project information in the database.' .
        '<br>When you are finished, hit <b>Submit</b> at the bottom of this page.');
    } 
 else if ($_SESSION['access_level'] == 2)
    if ($id == 'new') {
        echo('<p><strong>New Project Form</strong><br />');
        echo('Here you can add a new project into the database. </p>');

    } 
  else {
    echo("<p id=\"error\">You do not have sufficient permissions to add a new project to the database.</p>");
    include('footer.inc');
    echo('</div></div></body></html>');
    die();
}
?>
<form method="POST">
    <input type="hidden" name="old_id" value=<?PHP echo("\"" . $id . "\""); ?>>
    <input type="hidden" name="_form_submit" value="1">
    <p>(<span style="font-size:x-small;color:FF0000">*</span> denotes required fields)
    <p>Name<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="name" tabindex="1" value="<?PHP echo($project->get_name()) ?>">
    <p>Address<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="address" tabindex="2" value="<?PHP echo($project->get_address()) ?>">
    <fieldset>    
         <legend>Project time information:</legend>
               <p>Date of Project<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="date" tabindex="2" value="<?PHP echo($project->get_date()) ?>">             
                Day of Week<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="dayOfWeek" tabindex="1" value="<?PHP echo($project->get_dayOfWeek()) ?>">
               <p>Start Time<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="start_time" MAXLENGTH=2 tabindex="7" value="<?PHP echo($project->get_start_time()) ?>">
               <p>End Time<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="end_time" MAXLENGTH=2 tabindex="7" value="<?PHP echo($project->get_end_time()) ?>">
              
     </textarea></fieldset>
  <?PHP
      
        echo('<p>Notes:<br />');
        echo('<textarea name="notes" rows="2" cols="60">');
        echo($project->get_notes());
        echo('</textarea></fieldset>');
        error_log("Day of week is " . $project->dayOfWeek);
/*        
if ($_SESSION['access_level'] == 0) {
	echo ('<option value="applicant"');
    echo (' SELECTED'); 
    echo('>applicant</option>');
}
else {
	echo ('<option value="applicant"');
	if ($project->get_status() == 'applicant')
    	echo (' SELECTED'); 
    echo('>applicant</option>'); echo ('<option value="active"');
	if ($project->get_status() == 'active')
	    echo (' SELECTED'); echo('>active</option>');
	echo ('<option value="LOA"');
	if ($project->get_status() == 'LOA')
	    echo (' SELECTED'); echo('>Not being worked on at this time</option>');
	echo ('<option value="former"');
	if ($project->get_status() == 'former')
	    echo (' SELECTED'); echo('>former</option>');
}
?>
    <fieldset id='availability'>
        <legend>Availability:<span style="font-size:x-small;color:FF0000">*</span> </legend>
        <span class="bigTable">
            <table>
                <?PHP
                $projects = array('morning' => 'Morning (9-12)', 'earlypm' => 'Early afternoon (12-3)', 'latepm' => 'Late afternoon (3-6)',
                    'evening' => 'evening (6-9)', 'overnight' => "Overnight");
                $days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
              
    			foreach ($projects as $weekno => $weekvalue) {
       				echo ('<tr><td>'. $weekvalue . '</td>');
       				foreach ($days as $day) {
       	  				$realkey = $day . ":". $weekno;
       	  				echo ('<td><input type="checkbox" name="availability[]" value=' . $realkey);
    	  				
       				}
       				echo ('</tr>');
    			}
   		 		echo "</table><p>";
    			?>
            </table>
        </span></p>
    </fieldset>
    <p>
    
        echo('<input type="hidden" name="_submit_check" value="1"><p>');
        if ($_SESSION['access_level'] == 0)
            echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to complete this application.<br /><br />');
        else
            echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
        if ($id != 'new' && $_SESSION['access_level'] >= 2) {
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />' .
            '<input type="checkbox" name="reset_pass" value="RESET"> Check this box and then hit ' .
            '<input type="submit" value="Reset Password" name="Reset Password"assword.</p>');
        }

        function &select_date($month, $day, $year, $month_name, $day_name, $year_name) {
            $months = array('', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
            echo('<select name=' . $month_name . '><option value=""></option>');
            echo('');
            for ($i = 1; $i <= 12; $i++) {
                echo '<option value=' . (($i < 10) ? "0" . $i : $i);
                if ($month == $i)
                    echo(' SELECTED');
                echo '>' . $months[$i] . ' </option>';
            }
            echo "</select>";

            echo '<select name=' . $day_name . '><option value=""></option>';
            for ($i = 1; $i <= 31; $i++) {
                echo '<option value=' . (($i < 10) ? "0" . $i : $i);
                if ($day == $i)
                    echo(' SELECTED');
                echo '>' . $i . ' </option>';
            }
            echo "</select>";
            // handles a year range of 81 years, from today+1 to today-80
            echo '<select name=' . $year_name . '><option value=""></option>';
            $start_year = date("Y")+1;
            for ($i = $start_year; $i >= ($start_year - 90); $i--) {
                echo '<option value=' . substr($i, 2, 2);
                if ($year == substr($i, 2, 2))
                    echo(' SELECTED');
                echo '>' . $i . ' </option>';
            }
            echo "</select>";
        }
        ?>
</form>
 * 
 */
