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
 * MasterScheduleEntry class for RMH homebase.
 * @author Johnny Coster
 * @version February 15, 2012, revised April 11, 2012
 */

class MasterScheduleEntry {
    	private $MS_ID;	        // unique string for each entry = schedule_type.day.week."-".start_time."-".end_time
							//    or (for overnight shifts & project) = schedule_type.day.week."-"."overnight"   
	private $Schedule_type; // "monthly" (for guestchef type) or "weekly" (for weekday, weekend, and overnight types)
	private $day;           // "Mon", "Tue", ... "Sun"
	private $start_time;    // start time for the shift & project(9 - 21), or "overnight" or "any" (for any time of day)
	private $end_time;		// end time for the shift & project(9 - 21)
	private $slots;         // the number of slots to be filled for this shift & project
	private $persons;       // array of ids, eg ["alex2071234567", "jane1112345567"]
	private $notes;         // notes to be displayed for this shift & project on the schedule
        private $Shifts;        // text that explains what shift is within the slot
	
	/**
	* constructor for all MasterScheduleEntries
	*/
	function __construct($Schedule_type, $day,$start_time, $end_time, $slots, $persons, $notes, $Shifts){
		$this->Schedule_type = $Schedule_type;
		$this->day = $day;
		$this->start_time = $start_time;
		$this->end_time = $end_time;
		$this->slots = $slots;
		if ($persons !== "")
			$this->persons = explode(',',$persons);
		else
			$this->persons = array();
		$this->notes = $notes;
		if ($start_time!="overnight")
			$this->MS_ID = $Schedule_type.$day.$start_time."-".$end_time;
		else $this->MS_ID = $Schedule_type.$day."-".$start_time;
                $this->Shifts = $Shifts;
	}
	
	/**
	*  getter functions
	*/
	
        function get_MS_ID(){
		return $this->MS_ID;
	}
	
	function get_Schedule_type(){
		return $this->Schedule_type;
	}
	function get_day(){
		return $this->day;
	}
	
	function get_start_time(){ 
		return $this->start_time;
	}
	function get_end_time(){
		return $this->end_time;
	}
	function get_time(){
		if ($this->start_time!="overnight")
			return $this->start_time."-".$this->end_time;
		else return "overnight";
	}
	function get_slots(){
		return $this->slots;
	}
	function get_persons(){
		return $this->persons;
	}
	function get_notes(){
		return $this->notes; 
	}

        function get_Shifts(){
		return $this->Shifts;
	}
	
	function set_notes($notes){
		$this->notes = $notes; 
	}
	
	
}

?>