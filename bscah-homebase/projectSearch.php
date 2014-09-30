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
        Search for Projects
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
<div id="container">
    <?PHP include('header.php'); ?>
    <div id="content">
        <?PHP
            // display the search form
            $area = $_GET['area'];
            echo('<form method="post">');
            echo('<p><strong>Search for projects:</strong>');

            echo '<p>Name (type a few letters): ';
            echo '<input type="text" name="s_name">';

            echo '<fieldset>
						<legend>Time of project: </legend>
							<table><tr>
								<td>Day of week</td>
								</tr>';
            echo "<tr>";
            echo "<td>";
            $days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
            echo '<select name="s_day">' . '<option value=""></option>';
            foreach ($days as $day) {
                echo '<option value="' . $day . '">' . $day . '</option>';
            }


            /*echo '</select>';
            echo "</td><td>";
            $shifts = array('morning' => 'Morning (9-12)', 'earlypm' => 'Early Afternoon (12-3)', 'latepm' => 'Late Afternoon (3-6)',
                'evening' => 'Evening (6-9)', 'overnight' => 'Overnight');
            echo '<select name="s_shift">' . '<option value=""></option>';
            foreach ($shifts as $shiftno => $shiftname) {
                echo '<option value="' . $shiftno . '">' . $shiftname . '</option>';
            }

             */
            echo '</select>';
            echo "</td>";
            echo "</tr>";
            echo '</table></fieldset>';

            echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Search">');
            echo('</form></p>');

            // if user hit "Search"  button, query the database and display the results
            if ($_POST['s_submitted']) {
                $type = $_POST['s_type'];
                $status = $_POST['s_status'];
                $name = trim(str_replace('\'', '&#39;', htmlentities($_POST['s_name'])));
                // now go after the volunteers that fit the search criteria
                include_once('database/dbPersons.php');
                include_once('domain/Person.php');
                $result = getonlythose_dbPersons($type, $status, $name, $_POST['s_day']);
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
                    echo " with availability " . $availability;
                }
                if (sizeof($result) > 0) {
                    echo ' (select one for more info).';
                    echo '<p><table> <tr><td>Name</td><td>Phone</td><td>E-mail</td><td>Availability</td></tr>';
                    foreach ($result as $vol) {
                        echo "<tr><td><a href=personEdit.php?id=" . str_replace(" ", "_", $vol->get_id()) . ">" .
                            $vol->get_first_name() . " " . $vol->get_last_name() . "</td><td>" .
                            phone_edit($vol->get_phone1()) . "</td><td>" .
                            $vol->get_email() . "</td><td>";
                        foreach ($vol->get_availability() as $availableon) {
                            echo($availableon . ", ");
                        }
                        echo "</td></a></tr>";
                    }
                }
                echo '</table>';
            }
        ?>
        <!-- below is the footer that we're using currently-->
    </div>
</div>
<?PHP include('footer.inc'); ?>
</body>
</html>


