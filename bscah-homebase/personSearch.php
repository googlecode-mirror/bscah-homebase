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
    <title>
        Search for People
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
<div id="container">
    <a href="index.php"</a>
    <?PHP include('header.php');
          include('accessController.php');
    ?>
    <div id="content">
        <?PHP
        include('projectTypes.php');
            // display the search form
        if(isset($_GET['area']))
        {
            $area = $_GET['area'];//fixes undefined error for area
        }
            echo('<form method="post">');
            echo('<p><strong>Search for volunteers:</strong>');

            echo('<p>Type:<select name="s_type">' .
                '<option value="" SELECTED></option>' .
                '<option value="volunteer">Volunteer</option>' .
                '<option value="Manager">Manager</option>' .
                '<option value="guest">Guest</option>' .
                '</select>');


            echo('&nbsp;&nbsp;Status:<select name="s_status">' .
                '<option value="" SELECTED></option>' . '<option value="applicant">Applicant</option>' .
                '<option value="Approved">Approved</option>' . '<option value = "onleave">On leave</option>'.
                    '<option value= "former">Former</option>'.
                '</select>');
            echo '<p>Name (type a few letters): ';
            echo '<input type="text" name="s_name">';

            echo '<fieldset>
						<legend>Availability: </legend>
							<table><tr>
								<td>Day       </td>
								<td>Shift</td>
								</tr>';
            echo "<tr>";
            echo "<td>";
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            echo '<select name="s_day">' . '<option value=""></option>';
            foreach ($days as $day) 
            {
                echo '<option value="' . $day . '">' . $day . '</option>';
            }
        
            echo '</select>';
            echo "</td><td>";
            $shifts = ['Morning(9-12)' => 'Morning(9-12)', 'EarlyPM(12-3)' => 'EarlyPM(12-3)',
                        'LatePM(3-6)' => 'LatePM(3-6)',
                        'Evening(6-9)' => 'Evening(6-9)', 'Overnight' => "Overnight"];
            echo '<select name="s_shift">' . '<option value=""></option>';
            foreach ($shifts as $shiftno => $shiftname) 
            {
                echo '<option value="' . $shiftno . '">' . $shiftname . '</option>';
            }

          
            echo '</select>';
            echo "</td>";
            echo "</tr>";
            echo '</table></fieldset>';

         
            $projectTypes = new projectTypes();
           echo '<fieldset>
						<legend> Project Type: </legend>
							<table><tr>
								<td>Types  </td>
								<td></td>
								</tr>';
            echo "<tr>";
            echo "<td>";
         
            echo '<select name="s_types">' . '<option value=""></option>';
            foreach ($projectTypes->types as $type) 
            {
                echo '<option value="' . $type . '">' . $type . '</option>';
            }
        
            echo "</td>";
            echo "<td>";
            echo '</select>';
            
            
            echo '</select>';
            echo "</td>";
            echo "</tr>";
            echo '</table></fieldset>';

            echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
            echo('</form></p>');
            
            
           
           

            // if user hit "Search"  button, query the database and display the results
            if (isset($_POST['s_submitted'])) {
                $type = $_POST['s_type'];
                $status = $_POST['s_status'];
                $name = trim(str_replace('\'', '&#39;', htmlentities($_POST['s_name'])));
                $day = $_POST['s_day'];
                $shift = $_POST['s_shift'];
                // now go after the volunteers that fit the search criteria
                include_once('database/dbPersons.php');
                include_once('domain/Person.php');
                $result = getonlythose_persons($type, $status, $name, $day, $shift);
                //$result = getall_dbPersons();

                

                echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result) . ' ' . $status . ' ';
                if ($type != "") {
                    echo $type . "s";
                }
                else {
                    echo "persons";
                }
                if ($name != "") {
                    echo ' with name like "' . $name . '"';
                }
                $availability = $_POST['s_day'];
                if ($availability != " ") {
                    echo " with an availability day of " . $availability;
                }
                if($availability == "")
                {
                    echo "  any day ";
                }
                $shiftOn = $_POST['s_shift'];
                
                if($shiftOn != " ")
                {
                    echo " with shift of " . $shiftOn;
                }
                if($shiftOn == "")
                {
                    echo "  any shifts.";
                }
                if (sizeof($result) > 0) {
                    echo ' (select one for more info).';
                    echo '<p><table> <tr><td>Name</td><td>Phone</td><td>E-mail</td><td>Availability</td></tr>';
                    foreach ($result as $vol) {
                        
                        echo "<tr><td><a href=personEdit.php?id=" . str_replace(" ", "_", $vol->get_id()) . ">" .
                            $vol->get_first_name() . " " . $vol->get_last_name() . "</td><td>" .
                            phone_edit($vol->get_phone1()) . "</td><td>" .
                            $vol->get_email() . "</td><td>" . $avail = implode("  |  ", $vol->get_availability());
                        }
                        echo "</td></a></tr>";
                    }
                }
                echo '</table>';
            
        ?>
        <!-- below is the footer that we're using currently-->
    </div>
</div>
<?PHP include('footer.inc'); ?>
</body>
</html>


