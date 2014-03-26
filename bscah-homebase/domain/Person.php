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
   
    private $first_name;    // first name as a string
    private $last_name;     // last name as a string
    private $gender;        // gender - string
    private $address;       // address - string
    private $city;          // city - string
    private $state;         // state - string
    private $zip;           // zip code - integer
    private $county;        // county of residence
    private $phone1;        // main phone
    private $phone2;        // alternate phone
    private $email;         // email address as a string
    private $type;          // coordinator or volunteer 
    private $schedule;      // dates scheduled for volunteering
    private $notes;         // notes or this person 
    private $password;      // password for calendar and database access: default = $id
    private $id;            // id (unique key) = first_name . phone1
    private $availability;  // format: 03-24-14
    

    /**
     * constructor for all persons
     * matches the format in the database
     */

    function __construct($f, $l, $g, $a, $c, $s, $z, $p1, $p2, $e, $t, $sch, $n, $p, $id, $ava ) {
        $this->first_name = $f;
        $this->last_name = $l;
        $this->gender = $g;
        $this->address = $a;
        $this->city = $c;
        $this->state = $s;
        $this->zip = $z;
        $this->county = $this->compute_county();
        $this->phone1 = $p1;
        $this->phone2 = $p2;
        $this->email = $e;
        $this->type = $t;
        $this->schedule = $sch;
        $this->notes = $n;
        $this->password = $p;
        $this->id = $id;
        $this->availability = $ava;
       
    }

    function get_id() {
        return $this->id;
    }

    function get_first_name() {
        return $this->first_name;
    }

    function get_last_name() {
        return $this->last_name;
    }

    function get_gender() {
        return $this->gender;
    }

    function get_address() {
        return $this->address;
    }

    function get_city() {
        return $this->city;
    }

    function get_state() {
        return $this->state;
    }

    function get_zip() {
        return $this->zip;
    }

    function get_county() {
        return $this->county;
    }

    function get_phone1() {
        return $this->phone1;
    }

    function get_phone2() {
        return $this->phone2;
    }

    function get_email() {
        return $this->email;
    }

    function get_type() {
        return $this->type;
    }

    function get_schedule() {
        return $this->schedule;
    }

    function get_password() {
        return $this->password;
    }
    
    function get_notes()   {
        return $this->notes; 
    }
    
    function get_availabity(){
        return $this->availability;
    }
    function set_county ($county){
        $this->county = $county;
    }
    
    function compute_county () {
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
    }
    
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
