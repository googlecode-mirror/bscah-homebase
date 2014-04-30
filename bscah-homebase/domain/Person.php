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
include_once(dirname(__FILE__).'/../database/dbZipCodes.php');
include_once(dirname(__FILE__).'/../database/dbShifts.php');
include_once(dirname(__FILE__).'/../database/dbPersons.php');
include_once('Shift.php');
include_once('Person.php');

class Person {
    
    private $ID;            // id (unique key) = first_name . phone1
    private $NameFirst;    // first name as a string
    private $NameLast;     // last name as a string
    private $Birthday;      //birhday
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
            $type, $status, $sch, $notes, $pswd, $avail, $cont_pref ) {
        $this->ID = $fname.$ph1;
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
        $this->Status =$status;

        if ($sch !== "")
            $this->Schedule = explode(',', $sch);
        else
            $this->Schedule = array();
        
        $this->Notes = $notes;
        $this->Password = $pswd;
        
        if ($avail == "")
            $this->Availability = array();
        else
            $this->Availability = explode(',', $avail);
        
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
    
    function get_notes()   {
        return $this->Notes; 
    }
    
    function get_availability(){
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
function report_hours ($histories, $from, $to) {
    	$min_date = "01/01/2000";
    	$max_date = "12/31/2020";
    	if ($from == '') $from = $min_date;
    	if ($to == '') $to = $max_date;
    	error_log("from date = " . $from);
    	error_log("to date = ". $to);
    	$from_date = date_create_from_mm_dd_yyyy($from); 
    	$to_date   = date_create_from_mm_dd_yyyy($to);
    	$report = array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0, 
    					'Fri' => 0, 'Sat' => 0, 'Sun' => 0);
    	if (array_key_exists($this->get_id(), $histories)) {
    	  $hid = explode(',',$histories[$this->id]);
    	  foreach ($hid as $shift_id) {
    		$s = select_dbShifts($shift_id);
    		$shift_date = date_create_from_mm_dd_yyyy($s->get_mm_dd_yy());
    		if ($shift_date >= $from_date && $shift_date <= $to_date) {
    			$report[$s->get_day()] += $s->duration();
    		}
    	  }
    	}
    	return $report;
    }
}

function report_hours_by_day($histories, $from, $to) {
	$min_date = "01/01/2000";
	$max_date = "12/31/2020";
	if ($from == '') $from = $min_date;
	if ($to == '') $to = $max_date;
	error_log("from date = " . $from);
	error_log("to date = ". $to);
	$from_date = date_create_from_mm_dd_yyyy($from);
	$to_date   = date_create_from_mm_dd_yyyy($to);
	$reports = array(
		'morning' => array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
    				'Fri' => 0, 'Sat' => 0, 'Sun' => 0), 
		'earlypm' => array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
    				'Fri' => 0, 'Sat' => 0, 'Sun' => 0),
		'latepm' => array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
    				'Fri' => 0, 'Sat' => 0, 'Sun' => 0),
		'evening' => array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
    				'Fri' => 0, 'Sat' => 0, 'Sun' => 0),
		'overnight' => array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
    				'Fri' => 0, 'Sat' => 0, 'Sun' => 0),
		'total' => array('Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0,
    				'Fri' => 0, 'Sat' => 0, 'Sun' => 0)
	);
	
	foreach($histories as $person_id => $person_shifts) {
	    $ps = explode(',',$person_shifts);
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


?>
