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


    /**
     * Person class for RMH homebase.
     * @author Oliver Radwan, Judy Yang and Allen Tucker
     * @version May 1, 2008, modified 2/15/2012
     */


    /**
     * Person class
     * Edited by Humza Ahmad
     */
    include_once(dirname(__FILE__) . '/../database/dbZipCodes.php');
    include_once(dirname(__FILE__) . '/../database/dbShifts.php');
    include_once(dirname(__FILE__) . '/../database/dbPersons.php');
    include_once(dirname(__FILE__) . '/../database/dbProjects.php');
    include_once('Shift.php');
    include_once('Person.php');
    include_once('Project.php');
    include_once('reportsAjax.php');
    

    class Person {

        private $ID;            // id (unique key) = first_name . phone1
        private $NameFirst;    // first name as a string
        private $NameLast;     // last name as a string
        private $Birthday;      //birthday
        private $Gender;        // gender - string
        private $Address;       // address - string
        private $City;          // city - string
        private $State;         // state - string
        private $Zip;           // zip code - integer
        private $Phone1;        // main phone
        private $Phone2;        // alternate phone
        private $Email;         // email address as a string
        private $Type;          // Manager, Volunteer or Guest
        private $Status;        // applicant or approved for  volunteers, null for coordinators
        private $Schedule;      // dates scheduled for volunteering
        private $Notes;         // notes or this person
        private $Password;      // password for calendar and database access: default = $id
        private $Availability;  // format: 03-24-14
        private $Contact_Preference;    //String email, mail or phone


        /**
         * constructor for all persons
         * matches the format in the database
         */

        function __construct($fname, $lname, $bday, $gender, $addr, $city, $state, $zip, $ph1, $ph2, $email,
            $type, $status, $sch, $notes, $pswd, $avail, $cont_pref) {
            $this->ID = $fname . $ph1;
            $this->NameFirst = $fname;
            $this->NameLast = $lname;
            $this->Birthday = $bday;
            $this->Gender = $gender;
            $this->Address = $addr;
            $this->City = $city;
            $this->State = $state;
            $this->Zip = $zip;
            //$this->County = $co;
            $this->Phone1 = $ph1;
            $this->Phone2 = $ph2;
            $this->Email = $email;
            $this->Type = $type;
            $this->Status = $status;

            if ($sch !== "") {
                $this->Schedule = explode(',', $sch);
            }
            else {
                $this->Schedule = [];
            }

            $this->Notes = $notes;
            $this->Password = $pswd;

            if ($avail == "") {
                $this->Availability = [];
            }
            else {
                $this->Availability = explode(',', $avail);
            }

            $this->Contact_Preference = $cont_pref;

        }

        function get_id() {
            return $this->ID;
        }

        function get_first_name() {
            return $this->NameFirst;
        }

        function get_last_name() {
            return $this->NameLast;
        }

        function get_birthday() {
            return $this->Birthday;
        }

        function get_gender() {
            return $this->Gender;
        }

        function get_address() {
            return $this->Address;
        }

        function get_city() {
            return $this->City;
        }

        function get_state() {
            return $this->State;
        }

        function get_zip() {
            return $this->Zip;
        }

        function get_county() {
            return $this->County;
        }

        function get_phone1() {
            return $this->Phone1;
        }

        function get_phone2() {
            return $this->Phone2;
        }

        function get_email() {
            return $this->Email;
        }

        function get_type() {
            return $this->Type;
        }

        function get_status() {
            return $this->Status;
        }

        function get_schedule() {
            return $this->Schedule;
        }

        function get_password() {
            return $this->Password;
        }

        function get_notes() {
            return $this->Notes;
        }

        function get_availability() {
            return $this->Availability;
        }

        function get_contact_preference() {
            return $this->Contact_Preference;
        }

        /*
          function set_county ($county){
               $this->County = $county;
           }

         * /
         */
        /*   function compute_county () {
               if ($this->state=="ME") {
                   $countydata = false;
                   if ($this->get_zip()!="")
                       $countydata = retrieve_dbZipCodes($this->get_zip(),"");
                   else if (!$countydata)
                       $countydata = retrieve_dbZipCodes("",$this->get_city());
                   if ($countydata) {
                       if ($this->zip == "")
                           $this->zip = $countydata[0];
                       return $countydata[3];
                   }
               }
               return "";
           } */

        // return a dictionary reporting total number hours worked by days of the week with
        // a given date range. $from and $to are strings of the form 'm/d/y', if one of the strings
        // is the empty string, then the range is unbounded in that direction.
        // the dictionary is of the form {'Mon' => , 'Tue' => }.
        function report_hours($shifthis, $projecthis, $from, $to) {
            $from_date = setFromDate($from);
            $to_date = setToDate($to);
    
            $groupedreports = [];
            $count = 0;
            
           $fw = getNormWeek($from_date);
           $tw = getNormWeek($to_date);
           $yearswithweeks = DateRange($fw, $tw);
           
    foreach($yearswithweeks as $years => $weeks)
    {   
        foreach ($weeks as $w) 
        {    
            $currentweek = getSunWeek($years, $w);
            $weeklyreport = ['Sun' => [0, 0, 0], 'Mon' => [0, 0, 0], 'Tue' => [0, 0, 0], 'Wed' => [0, 0, 0], 'Thu' => [0, 0, 0], 'Fri' => [0, 0, 0], 'Sat' => [0, 0, 0]];
            
            if (array_key_exists($this->get_id(), $shifthis)) 
           { 
                $sfthid = explode(',', $shifthis[$this->ID]);

                foreach ($sfthid as $shift_id) 
               {
                 $s = select_dbShifts($shift_id);
                  
                 if (CheckIfDateIsInWeek($s->get_date(), $currentweek)) // This way the same shift's hours won't be taken for every week - GIOVI
                    {  
                        $shift_date = date_create_from_mm_dd_yyyy($s->get_mm_dd_yy());
                    
                         if ($shift_date >= $from_date && $shift_date <= $to_date) 
                         { 
                           $weeklyreport[$s->get_day()][0] += $s->duration(); //First element is for shift hours - GIOVI
                         } 
                    }
                }
            }
            
            if (array_key_exists($this->get_id(), $projecthis)) 
           { 
                $projhid = explode(',', $projecthis[$this->ID]);

                foreach ($projhid as $proj_id) 
               {
                    $p = select_dbProjects($proj_id);
                    
                    if (CheckIfDateIsInWeek($p->get_date(), $currentweek)) // This way the same project's hours won't be taken for every week - GIOVI
                    {
                        $proj_date = date_create_from_mm_dd_yyyy($p->get_mm_dd_yy());
                    
                        if ($proj_date >= $from_date && $proj_date <= $to_date)
                        { 
                            $weeklyreport[$p->get_dayOfWeek()][1] += $p->duration(); //Second element is for project hours - GIOVI
                        } 
                    }
                      
                }
            }
            
            foreach ($weeklyreport as $day => $hrs)
            {
                $weeklyreport[$day][2] = $weeklyreport[$day][0] + $weeklyreport[$day][1]; // Third element is for the total of both shift and project hours - GIOVI
            }
            
            $groupedreports[] = $weeklyreport;
            $count++;
        }
    }
            error_log("------- " . $count . " grouped report(s) recorded-----------");
            error_log("/////EXITING the report_hours function--------------------");
            return $groupedreports;
        }
    }

    function CheckIfDateIsInWeek($datetocheck, $weekdate) //This is to check if a date falls within the current week starting with Sunday - GIOVI
    {   error_log("-------------" . $datetocheck . " is checking to see if it's in " . $weekdate);
        $checkingdate = strtotime($datetocheck);
        $currentweek = strtotime($weekdate);
        $endofweek = strtotime($weekdate . '+6 days');
        
        if ($checkingdate >= $currentweek && $checkingdate <= $endofweek) { error_log("The date check returned TRUE---------"); return TRUE;}
        else { error_log("The date check returned FALSE---------"); return FALSE;}
     }
    
    function report_shifthours_by_day($histories, $from, $to) {
        error_log("report hours by day");
        $min_date = "01/01/2000";
        $max_date = "12/31/2020";
        if ($from == '') {
            $from = $min_date;
        }
        if ($to == '') {
            $to = $max_date;
        }
        error_log("from date = " . $from);
        error_log("to date = " . $to);
        $from_date = date_create_from_mm_dd_yyyy($from);
        $to_date = date_create_from_mm_dd_yyyy($to);
        $reports = [
            'morning' => ['Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
                'Fri' => 0, 'Sat' => 0, 'Sun' => 0],
            'earlypm' => ['Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
                'Fri' => 0, 'Sat' => 0, 'Sun' => 0],
            'latepm' => ['Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
                'Fri' => 0, 'Sat' => 0, 'Sun' => 0],
            'evening' => ['Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
                'Fri' => 0, 'Sat' => 0, 'Sun' => 0],
            'overnight' => ['Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
                'Fri' => 0, 'Sat' => 0, 'Sun' => 0],
            'total' => ['Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
                'Fri' => 0, 'Sat' => 0, 'Sun' => 0]
        ];

        foreach ($histories as $person_id => $person_shifts) {
            $ps = explode(',', $person_shifts);
            foreach ($ps as $shift_id) {
                $s = select_dbShifts($shift_id);
                $shift_date = date_create_from_mm_dd_yyyy($s->get_mm_dd_yy());
                if ($shift_date >= $from_date && $shift_date <= $to_date) {
                    $reports[$s->get_time_of_day()][$s->get_day()] += $s->duration();
                    $reports['total'][$s->get_day()] += $s->duration();
                }
            }
        }

        return $reports;
    }

    function report_projecthours($from, $to) {
        $from_date = setFromDate($from);
        $to_date = setToDate($to);
        
        $reports = [];
        $all_projects = get_all_projects();
        $count = 0;
        
        foreach ($all_projects as $p) 
        {
                
            $project_date = date_create_from_mm_dd_yyyy($p->get_mm_dd_yy());
                
            if ($project_date >= $from_date && $project_date <= $to_date) 
            {
                
                if (!isset($reports[$p->get_id()][0]) || !isset($reports[$p->get_id()][1]) || !isset($reports[$p->get_id()][2]))
                {
                    $reports[$p->get_id()][0] = NULL;
                    $reports[$p->get_id()][1] = NULL;        
                }
                
                    error_log("Getting total hours and number of volunteers---------------------------");
                    error_log("The number of hours is " . $p->duration());
                    error_log("The number of volunteers is " . $p->get_num_of_persons());
                    
                    $reports[$p->get_id()][0] += ($p->duration() * $p->get_num_of_persons());//Tell me to removed the multiplier if needed, all it does is multiply the number of hours by the number of volunteers in that particular project, I assume this is how it'll go to see the total hours being worked on be each volunteer - GIOVI
                    $reports[$p->get_id()][1] += $p->get_num_of_persons();
                    $count++;
    
                    error_log("End of loop--------------------------------------");
            }
        }
        error_log("------- " . $count . " project(s) recorded-----------");
        return $reports;
    }

?>
