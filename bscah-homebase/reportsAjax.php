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
//Changes: shift table added a few ids in different shifts IMPORTANT: ids in person's column must end with '+' in order the if statement to return true in line 405 - GIOVI
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    include_once('database/dbShifts.php');
    include_once('domain/Shift.php');
    $names = getall_volunteer_names();
    $shifthistories = get_all_peoples_histories();// This returns a key sorted list of everyone's names that are or were in shifts; - GIOVI
                                                  //The key being the the person's id and the associated value being the id of every shift s/he is in separated by commas. - GIOVI
    $projecthistories = get_all_peoples_histories_in_proj();//This returns a key sorted list of everyone's names that are or were in projects - GIOVI
    
    if (isset($_GET['q'])) {//Was $_POST changing it to $_GET allows hints to display - GIOVI
        show_hint($names);
    }

    if (isset($_POST['_form_submit']) && $_POST['_form_submit'] == 'report') {
        show_report($shifthistories, $projecthistories);
    }

    function show_report($shifthistories, $projecthistories) {

        $names = $_POST['volunteer-names'];
        $from = "";
        $to = "";
        if (isset($_POST['date']) && $_POST['date'] != "") {
            if ($_POST['date'] == "last-week") {
                $from = date("m/d/y", strtotime("6 weeks ago"));
                $to = date("m/d/y", strtotime("last week"));
            }
            else {
                if ($_POST['date'] == "last-month") {
                    $from = date("m/d/y", strtotime("2 months ago"));
                    $to = date("m/d/y", strtotime("last month"));
                }
                else {
                    $from = $_POST["from"];
                    $to = $_POST["to"];
                }
            }
        }
            //Affects Individual Hours, Total Hours, and Shift/Vacancies respectivly - GIOVI
            //Added two more if statements to take in total projects and project vacancies - GIOVI
        if (isset($_POST['report-types'])) {
            if (in_array('volunteer-names', $_POST['report-types'])) {
                report_by_volunteer_names($names, $shifthistories, $from, $to);//Check if this needs to have a connection to projects - GIOVI
            }
            if (in_array('volunteer-hours', $_POST['report-types'])) {
                report_shifts_totalhours_by_day($shifthistories, $from, $to);
            }
            if (in_array('shifts-staffed-vacant', $_POST['report-types'])) {
                report_shifts_staffed_vacant_by_day($from, $to);
            }
            if (in_array('project-hours', $_POST['report-types'])) {
                report_projects_totalhours_by_day($projecthistories, $from, $to);
            }
            if (in_array('project-staffed-vacant', $_POST['report-types'])) {
                report_project_staffed_vacant_by_day($from, $to);
            }
        }

    }
                                                   
    function report_by_volunteer_names($names, $histories, $from, $to) {
        echo("<br><b>Individual volunteer hours</b>");
        error_log("volunteer names");
        $the_persons = [];
        foreach ($names as $name) {
            $the_persons = array_merge($the_persons, retrieve_persons_by_name($name));
        }
        $reports = [];
        $names = [];
        foreach ($the_persons as $p) {
            if ($p != null) {
                $names[] = $p->get_first_name() . " " . $p->get_last_name();
                $reports[] = $p->report_hours($histories, $from, $to);
            }
        }
        echo display_table_reports($names, $reports);

    }

    function report_shifts_totalhours_by_day($shifthistories, $from, $to) {
        echo("<br><b>Total Volunteer Shift hours</b>");
        error_log("Shift volunteer hours");
//	$all_volunteers = getall_dbPersons();
        $labels = [
            "Morning",
            "Early Afternoon",
            "Late Afternoon",
            "Evening",
            "Overnight",
            "Total"
        ];
        $reports = report_shifthours_by_day($shifthistories, $from, $to);
        echo display_table_reports($labels, $reports);
    }
    
    function report_shifts_staffed_vacant_by_day($from, $to) {
        echo("<br><b>Shifts/vacancies</b>");
        error_log("shifts hours");
        $labels = [
            "Morning",
            "Early Afternoon",
            "Late Afternoon",
            "Evening",
            "Overnight",
            "Total"
        ];
        $reports = report_shifts_staffed_vacant($from, $to);
        echo display_table_reports($labels, $reports);
    }

        function report_projects_totalhours_by_day($projecthistories, $from, $to) {//New function for displaying the total hours for projects - GIOVI
        echo("<br><b>Total Volunteer Project hours</b>");
        error_log("Project volunteer hours");
        $labels = [
            "Morning",
            "Early Afternoon",
            "Late Afternoon",
            "Evening",
            "Overnight",
            "Total"
        ];
        $reports = report_projecthours_by_day($projecthistories, $from, $to);
        echo display_table_reports($labels, $reports);
    }

    function report_project_staffed_vacant_by_day($from, $to) {//New function for displaying the vacancies for projects - GIOVI
        echo("<br><b>Project Vacancies</b>");
        error_log("Project hours");
        $labels = [
            "Morning",
            "Early Afternoon",
            "Late Afternoon",
            "Evening",
            "Overnight",
            "Total"
        ];
        $reports = report_projects_staffed_vacant($from, $to);
        echo display_table_reports($labels, $reports);
    }
    
    function display_table_reports($labels, $reports) {
        $res = "
		<table id = 'report'> 
			<thead>
			<tr>
				<td></td>
				<td>Mon</td>
				<td>Tue</td>
				<td>Wed</td>
				<td>Thu</td> 
				<td>Fri</td>
				<td>Sat</td>
				<td>Sun</td>
				<td>Total</td>
			</tr>
			</thead>
			<tbody>
	"; //<td>Thu</td> was mispelled as <td>tdu</td> ↑ - Giovi
        foreach (array_combine($labels, $reports) as $label => $report) {
            $res .= display_table_report($label, $report);
        }
        $res = $res . "</tbody></table>";

        return $res;
    }

    function display_table_report($label, $report) {

        $row = "<tr>";
        $row .= "<td>" . $label . "</td>";
        $total = 0;
        //$total2 = 0;
        foreach ($report as $hours) {
            if (is_array($hours)) {
                $total += $hours[0];
                //$total2 += $hours[1];
                $hours = implode('/', $hours);
            }
            else {
                $total += $hours;
            }
            $row .= "<td>" . $hours . "</td>";
        }
        //if ($total2 > 0) {
         //   $total = $total . "/" . $total2;
        //}
        if (isset($total)) {
            $row .= "<td>" . $total . "</td>";
        }
        $row .= "</tr>";

        return $row;
    }

    function show_hint($names) {
        $q = $_GET['q'];
        $hint = [];
        if (strlen($q) > 0) {
            for ($i = 0; $i < count($names); $i++) {
                if (strtolower($q) == strtolower(substr($names[$i], 0, strlen($q)))); {
                    $hint[] = $names[$i];
                }
            }
        }
        echo json_encode($hint);
    }

?>