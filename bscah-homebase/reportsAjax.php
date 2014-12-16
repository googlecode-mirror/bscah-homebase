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

    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    include_once('database/dbShifts.php');
    include_once('domain/Shift.php');
    include_once('database/dbProjects.php');
    include_once('domain/Project.php');
    error_log("In reportsAjax.php");

    if (isset($_GET['q'])) {//Was $_POST changing it to $_GET allows hints to display - GIOVI
        $names = getall_volunteer_names(); 
        show_hint($names);
    }

    if (isset($_POST['_form_submit']) && $_POST['_form_submit'] == 'report') 
                               { show_report(); }

    function show_report() {
        error_log("******START: show_report******");
        
        $shifthistories = get_all_peoples_histories_in_shifts();// This returns a key sorted list of everyone's names that are or were in shifts; - GIOVI
                                      //The key being the the person's id and the associated value being the id of every shift s/he is in separated by commas. - GIOVI
        $projecthistories = get_all_peoples_histories_in_proj();//This returns a key sorted list of everyone's names that are or were in projects - GIOVI
        
        $name = $_POST['volunteer-names'];
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
                report_by_individual_volunteer($name, $shifthistories, $projecthistories, $from, $to);//Check if this needs to have a connection to projects - GIOVI
            }
            if (in_array('volunteer-hours', $_POST['report-types'])) {
                report_shifts_totalhours($from, $to);
            }
            if (in_array('shifts-staffed-vacant', $_POST['report-types'])) {
                report_shift_vacancies($from, $to);
            }
            if (in_array('project-hours', $_POST['report-types'])) {
                report_projects_totalhours($from, $to);
            }
            if (in_array('project-staffed-vacant', $_POST['report-types'])) {
                 report_project_vacancies($from, $to);
            }
        }
            error_log("******END: show_report******");
    }
                                                
    function report_by_individual_volunteer($name, $shifthistories, $projecthistories, $from, $to) {
        echo("<br><b>Individual Volunteer Hours</b>");
        
        $labels = IndividualHoursLabel($from, $to);
        
        foreach ($name as $n) { $individual = retrieve_persons_by_name($n); }
        
        foreach ($individual as $i)
        {
            if ($i != null) 
            {
                echo("<br>This report shows the total hours worked by " . $i->get_first_name() . " " . $i->get_last_name(). " within the specified date range");
                error_log("/////ENTERING the report_hours function for " . $i->get_first_name() . " " . $i->get_last_name(). "--------------------");
                $reports = $i->report_individual_hours($shifthistories, $projecthistories, $from, $to); //An array contaning [0] shift, [1] project, and [2] total should be returned - GIOVI
            }
        }
       
            echo displayIndividualHoursReport($labels, $reports);
        }


    function report_shifts_totalhours($from, $to) {
       echo("<br><b>Total Volunteer Shift Hours</b>");
        echo("<br>This report shows the total hours worked by all volunteers within the specified date range");
        error_log("Shift volunteer hours");
        $labels = shiftLabel($from, $to, 'hours');
        $reports = report_shifthours($from, $to);
        echo displayShiftTotalHoursReport($labels, $reports);
    }
    
    function report_shift_vacancies($from, $to) {
        echo("<br><b>Shift Vacancies</b>");
        echo("<br>This report shows the number of vacancies in each shift within specified date range");
        error_log("Shift Vacancies");
        $labels = shiftLabel($from, $to, 'vacancies');
        $reports = report_shifts_staffed_vacant($from, $to);
        echo displayShiftVacancyReport($labels, $reports);
    }

    function report_projects_totalhours($from, $to) {//New function for displaying the total hours for projects - GIOVI
        echo("<br><b>Total Volunteer Project hours</b>");
        error_log("Project Total volunteer hours");
        $labels = projectLabel($from, $to, 'hours');
        $reports = report_projecthours($from, $to);
        echo displayProjectTotalHoursReport($labels, $reports);
    }

    function  report_project_vacancies($from, $to) {//New function for displaying the vacancies for projects - GIOVI
        echo("<br><b>Project Vacancies</b>");
        error_log("Project Vacancies");
        $labels = projectLabel($from, $to, 'vacancies');
        $reports = report_projects_staffed_vacant($from, $to);
        echo displayProjectVacancyReport($labels, $reports);
    }

    function show_hint($names) {
        $q = $_GET['q'];
        $hint = [];
        if (strlen($q) > 0) {
            for ($i = 0; $i < count($names); $i++) {

            if (strtolower($q) == strtolower(stristr($names[$i],strlen($q))));
                {
                   $hint[] = $names[$i];
                }
                }
        }
        echo json_encode($hint);
    }
    
    function setFromDate($from) {
        $min_date = "01/01/2014";
        if ($from == '') { $from = $min_date; }
        $from_date = date_create_from_mm_dd_yyyy($from);
        
        return $from_date;      }
        
    function setToDate($to) {
        $max_date = "12/31/2018";
        if ($to == '') { $to = $max_date; }
        $to_date = date_create_from_mm_dd_yyyy($to);
        
        return $to_date;    }   
    
    function getNormWeek($mdy) { //Returns the starting date(Monday) of a week created from the week number and year of the date - GIOVI
    $date = new DateTime();
    $year = (int)date('o', $mdy); //Must be 'o' instead of 'Y' in order to get the ISO-8601 year number to prevent year/week overlapping - GIOVI
    $week = (int)date('W', $mdy);
    $date->setISODate($year, $week);
    
    if (date('w', $mdy) == 0) //If on a Sunday, keep date as is - GIOVI
    {    
        $date->modify('+1 week');
    }
    
    $startweek = $date->format('m/d/Y'); //Start of the week - GIOVI
    return $startweek;
    }
    
    function getSunWeek($year, $weeknum) { //Sister function of above; Returns the starting date(Sunday) of a week created from the week number and year of the date - GIOVI
    $date = new DateTime();
    $date->setISODate($year, $weeknum);
    $date->modify('-1 day');
    $startweek = $date->format('m/d/Y'); //Start of the week - GIOVI
          return $startweek;
    }
    
    function DateRange($startdate, $enddate) { //This returns an array of the week numbers within the chosen range - GIOVI
    $begin = new DateTime($startdate);
    $end = new DateTime($enddate);
    $end->add(new DateInterval('P1D')); //Adds 1 day to include the end date as a day
    $interval = new DateInterval('P1W'); //Adds 1 week
    $period = new DatePeriod($begin, $interval, $end);
    $daterange = array();

    foreach ( $period as $year_week )
    {
        $daterange[$year_week->format('o')][] = $year_week->format('W');
    }

    return $daterange;
}
    
    function IndividualHoursLabel($from, $to) {
        $fromweek = setFromDate($from);
        $toweek = setToDate($to);
        
        $fw = getNormWeek($fromweek);
        $tw = getNormWeek($toweek);

        $yearswithweeks = DateRange($fw, $tw);
        $labels = [];
        $count = 0;
        //Two foreach loops are need because the first runs through the array of years, but can't also run through the the array of week numbers, so a second one is needed to take care of it - GIOVI
        foreach($yearswithweeks as $years => $weeks) // Loop to go in and search each year in range to grab all weeks within range - GIOVI
        {   
           foreach ($weeks as $w) 
           { 
               array_push($labels, "<nobr>Week of " . getSunWeek($years, $w) . "</nobr><br>Shift Hours" . "<br>Project Hours" . "<br>Total");  //Why 2013 on 12/29? - GIOVI
               $count++;
           }
        }
        error_log("------- " . $count . " week(s) recorded-----------");
        return $labels;
    }
    
    function projectLabel($from, $to, $section) { //This is used to print out display the project table the new way - GIOVI
        $from_date = setFromDate($from);
        $to_date = setToDate($to);
        
        $labels = [];
        $projdata = get_all_projects();  
        $count = 0;
       
        foreach ($projdata as $project)
        {
            $projects_date = date_create_from_mm_dd_yyyy($project->get_mm_dd_yy());
           
                if ($section === 'hours')
                {
                    if ($projects_date >= $from_date && $projects_date <= $to_date && $project->get_persons() != null) 
                    {
                        $starthrmin = ConvertTimeToHrMin($project->get_start_time());
                        $endhrmin = ConvertTimeToHrMin($project->get_end_time());
                    
                        array_push($labels, $project->get_date() . "<br>" . ArrangeMinutesInHours($starthrmin[0], $starthrmin[1]) . " - " . ArrangeMinutesInHours($endhrmin[0], $endhrmin[1]) . "<br><nobr>" . $project->get_name() . "</nobr>");
                        $count++;
                    }
                }
                
                if ($section === 'vacancies')
                {
                    if ($projects_date >= $from_date && $projects_date <= $to_date && $project->get_vacancies() != 0) 
                    {
                        $starthrmin = ConvertTimeToHrMin($project->get_start_time());
                        $endhrmin = ConvertTimeToHrMin($project->get_end_time());
                    
                        array_push($labels, $project->get_date() . "<br>" . ArrangeMinutesInHours($starthrmin[0], $starthrmin[1]) . " - " . ArrangeMinutesInHours($endhrmin[0], $endhrmin[1]) . "<br><nobr>" . $project->get_name() . "</nobr>");
                        $count++;
                    }
                }   
        }
        
        error_log("------- " . $count . " project label(s) recorded-----------");
        return $labels;
    }
    
    function shiftLabel($from, $to, $section) { //This is used to print out display the project table the new way - GIOVI
        $from_date = setFromDate($from);
        $to_date = setToDate($to);
        
        $labels = [];
        $shiftdata = get_all_shifts();  
        $count = 0;
        
        foreach ($shiftdata as $shift)
        {
            $shifts_date = date_create_from_mm_dd_yyyy($shift->get_mm_dd_yy());
           
            if ($section === 'hours')
            {
                if ($shifts_date >= $from_date && $shifts_date <= $to_date && $shift->get_persons() != null) 
                {
                    $starthrmin = ConvertTimeToHrMin($shift->get_start_time());
                    $endhrmin = ConvertTimeToHrMin($shift->get_end_time());
                    
                    array_push($labels, $shift->get_date() . "<br>" . ArrangeMinutesInHours($starthrmin[0], $starthrmin[1]) . " - " . ArrangeMinutesInHours($endhrmin[0], $endhrmin[1]) . "<br>" . $shift->get_venue());
                    $count++;
                }
            }
            
            if ($section === 'vacancies')
            {
                if ($shifts_date >= $from_date && $shifts_date <= $to_date && $shift->get_vacancies() != 0) 
                {
                    $starthrmin = ConvertTimeToHrMin($shift->get_start_time());
                    $endhrmin = ConvertTimeToHrMin($shift->get_end_time());
                    
                    array_push($labels, $shift->get_date() . "<br>" . ArrangeMinutesInHours($starthrmin[0], $starthrmin[1]) . " - " . ArrangeMinutesInHours($endhrmin[0], $endhrmin[1]) . "<br>" . $shift->get_venue());
                    $count++;
                }
            }
        }
        error_log("------- " . $count . " shift label(s) recorded-----------");
        return $labels;
    }
    
//Altered versions of display_table_reports and display_table_report in order to better work with the individual tables - GIOVI
     
    function displayIndividualHoursReport($labels, $reports) {
        $res = "<style type='text/css'>
                newft { font-size:14px; color:black; font-weight:bold; }
                </style>
                    <table id = 'report'> 
			<thead> 
                        <tr>
				<td></td>
				<td><newft>Sun</newft></td>
                                <td><newft>Mon</newft></td>
				<td><newft>Tue</newft></td>
				<td><newft>Wed</newft></td>
                                <td><newft>Thu</newft></td>
                                <td><newft>Fri</newft></td>
                                <td><newft>Sat</newft></td>
                                <td><newft>Total</newft></td>
			</tr>
			</thead>
			<tbody>";

	
        if (count($labels) == count($reports))
        {            
            foreach (array_combine($labels, $reports) as $label => $report) 
            {
                $res .= appendIndividualHoursData($label, $report);
            }
        }
        else 
        {
                error_log("FAIL: The two arrays are not equal");
                echo ("<br> - FAIL: There was an error in combining the arrays.");
                die();
        }
        
        
        
        $res = $res . "</tbody></table>";

        return $res;
    }
     
     function appendIndividualHoursData($label, $report)
     {
        $row = "<tr>";
        $row .= "<td style='font-size:14px; color:black; font-weight:bold'>" . $label . "</td>";
        $total = [[0, 0], [0, 0], [0, 0]]; //Hours and minutes for shift, project, total
        $datawithhrmins = [null, null, null];
        foreach ($report as $data) 
        {   
            if (is_array($data)) {
                $total[0][0] += $data[0][0]; //Shift total
                $total[0][1] += $data[0][1];
                $total[1][0] += $data[1][0]; //Project total
                $total[1][1] += $data[1][1];
                $total[2][0] += $data[2][0]; //Grand total
                $total[2][1] += $data[2][1];
                
                $datawithhrmins[0] = ArrangeMinutesInHours($data[0][0], $data[0][1]);
                $datawithhrmins[1] = ArrangeMinutesInHours($data[1][0], $data[1][1]);
                $datawithhrmins[2] = ArrangeMinutesInHours($data[2][0], $data[2][1]);
                
                $data = implode("<br>", $datawithhrmins);
            }
            
            else {  $total[0][0] += $data[0][0]; 
                    $total[0][1] += $data[0][1];
                    $total[1][0] += $data[1][0]; 
                    $total[1][1] += $data[1][1];
                    $total[2][0] += $data[2][0]; 
                    $total[2][1] += $data[2][1]; }
            
            $row .= "<td style='font-size:14px; color:black; font-weight:bold; text-align:center; vertical-align: bottom'><nobr>" . $data . "</nobr></td>";
        }
        
            $row .= "<td style='font-size:14px; color:black; font-weight:bold; text-align:center; vertical-align: bottom'><nobr>" . ArrangeMinutesInHours($total[0][0], $total[0][1]) . "<br>" . ArrangeMinutesInHours($total[1][0], $total[1][1]) . "<br>" . ArrangeMinutesInHours($total[2][0], $total[2][1]) . "</nobr></td>";
        
        $row .= "</tr>";

        return $row;
     }
    
    function displayShiftTotalHoursReport($labels, $reports)
    {
        $res = "<style type='text/css'>
                newft { font-size:14px; color:black; font-weight:bold; }
                </style>
                <table id = 'report' style = width:300px;>
                <thead>
                <td><newft>Shift Date & Name</newft></td>
                <td><newft>Hours</newft></td>
                <td><newft>Volunteers</newft></td>
                </thead>
                <tbody>";

        $total = [0, 0, 0];
       
        foreach ($reports as $shiftid => $data) //To get those total for shift hours and volunteers - GIOVI
            {   
                $hrmin = explode(':', $data);
                $total[0] += $hrmin[0];
                $total[1] += $hrmin[1];
                $total[2] += $data[1];
            }
        
        if (count($labels) == count($reports))
        {
	    foreach (array_combine($labels, $reports) as $label => $report)
            {
                $res .= appendShiftOrProjectData($label, $report);
            }
        }
        else 
        {
                error_log("FAIL: The two arrays are not equal");
                echo ("<br> - FAIL: There was an error in combining the arrays.");
                die();
        }
        
        $res = $res . "<td><newft>Total:</newft></td><td style='text-align:center'><newft>" . ArrangeMinutesInHours($total[0], $total[1]) . "</newft></td><td style='text-align:center'><newft>$total[2]</newft></td></tbody></table>";

        return $res;
    }
    
    function displayShiftVacancyReport($labels, $reports)
    {
        $res = "<style type='text/css'>
                newft { font-size:14px; color:black; font-weight:bold; }
                </style>
                <table id = 'report' style = width:250px;> 
                <thead>
                <td><newft>Shift Date & Name</newft></td>
                <td><newft>Vacancies</newft></td>
                </thead>
                <tbody>";
        
        $total = 0;
        
	if (count($labels) == count($reports))
        {
	    foreach (array_combine($labels, $reports) as $label => $report) 
            { 
                $res .= appendShiftOrProjectData($label, $report);
                $total += array_sum($report);
            }
        }
        else 
        {
                error_log("FAIL: The two arrays are not equal");
                echo ("<br> - FAIL: There was an error in combining the arrays.");
                die();
        }
        

        
        $res = $res . "<td><newft>Total:</newft></td><td style='text-align:center'><newft>$total</newft></td></tbody></table>";

        return $res;
    }
        
    function displayProjectTotalHoursReport($labels, $reports)
    {
        $res = "<style type='text/css'>
                newft { font-size:14px; color:black; font-weight:bold; }
                </style>
                <table id = 'report' style = width:300px;>
                <thead>
                <td><newft>Project Date & Name</newft></td>
                <td><newft>Hours</newft></td>
                <td><newft>Volunteers</newft></td>
                </thead>
                <tbody>";

        $total = [0, 0, 0];
       
        foreach ($reports as $projid => $data) //To get those total for project hours and volunteers - GIOVI
            {   
                $hrmin = explode(':', $data);
                $total[0] += $hrmin[0];
                $total[1] += $hrmin[1];
                $total[2] += $data[1];
            }
        
        if (count($labels) == count($reports))
        {
	    foreach (array_combine($labels, $reports) as $label => $report)
            {
                $res .= appendShiftOrProjectData($label, $report);
            }
        }
        else 
        {
                error_log("FAIL: The two arrays are not equal");
                echo ("<br> - FAIL: There was an error in combining the arrays.");
                die();
        }
        
        $res = $res . "<td><newft>Total:</newft></td><td style='text-align:center'><newft>" . ArrangeMinutesInHours($total[0], $total[1]) . "</newft></td><td style='text-align:center'><newft>$total[2]</newft></td></tbody></table>";

        return $res;
    }
    
    function displayProjectVacancyReport($labels, $reports)
    {
        $res = "<style type='text/css'>
                newft { font-size:14px; color:black; font-weight:bold; }
                </style>
                <table id = 'report' style = width:250px;> 
                <thead>
                <td><newft>Project Date & Name</newft></td>
                <td><newft>Vacancies</newft></td>
                </thead>
                <tbody>";
        
        $total = 0;
        
	if (count($labels) == count($reports))
        {
	    foreach (array_combine($labels, $reports) as $label => $report) 
            { 
                $res .= appendShiftOrProjectData($label, $report);
                $total += array_sum($report);
            }
        }
        else 
        {
                error_log("FAIL: The two arrays are not equal");
                echo ("<br> - FAIL: There was an error in combining the arrays.");
                die();
        }
        

        
        $res = $res . "<td><newft>Total:</newft></td><td style='text-align:center'><newft>$total</newft></td></tbody></table>";

        return $res;
    }
    
    function appendShiftOrProjectData($label, $report) {

        $row = "<tr>";
        $row .= "<td style='font-size:14px; color:black; font-weight:bold'>" . $label . "</td>";
        $total = 0;
        foreach ($report as $data) 
        {
            if (is_array($data)) {
                $total += $data[0];
                $data = implode('/', $data);
            }
            
            else { $total += $data; }
            
            $row .= "<td style='font-size:14px; color:black; font-weight:bold; text-align:center'>" . $data . "</td>";
        }

        $row .= "</tr>";

        return $row;
    }
    
    function ConvertTimeToHrMin($time)
    {        
        if (strlen($time) == 3) { $hours = substr($time, 0, 1); }
        else { $hours = substr($time, 0, 2); }            
            
        $minutes = substr($time, -2);
         
        $hrmin = [$hours, $minutes];
        
        return $hrmin;
    }

    function ArrangeMinutesInHours($hours, $minutes) //This keeps minutes under 60 and returns the proper format for minutes and hours - GIOVI
    {
        while ($minutes > 59)
        {
            $hours += 1;
            $minutes -= 60;
        }
        
        $hrs = str_pad($hours, 2, 0, STR_PAD_LEFT);
        $mins = str_pad($minutes, 2, 0, STR_PAD_LEFT);
        
        return $hrs . ":" . $mins;
    }
    //CONSIDER USING : TO MAKE TABLES CLEARER - GIOVI
 ?>
