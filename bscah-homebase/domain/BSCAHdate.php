<?php
    /*
     * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,
     * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan,
     * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.
     * This program is part of BSCAH Homebase, which is free software.  It comes with
     * absolutely no warranty. You can redistribute and/or modify it under the terms
     * of the GNU General Public License as published by the Free Software Foundation
     * (see <http://www.gnu.org/licenses/ for more information).
     *
     */


    include_once("Shift.php");
    include_once("Project.php"); // James Loeffler and Eric
    include_once(dirname(__FILE__) . '/../database/dbMasterSchedule.php');
    include_once(dirname(__FILE__) . '/../database/dbProjects.php');
    

    /* A class to manage an BSCAHDate
     * @version May 1, 2008
     * @author Taylor and Maxwell Palmer
     */

    class BSCAHdate {

        private $id;    // "mm-dd-yy" form of this date: used as a key
        private $month;       // Textual month of the year  (e.g., Jan)
        private $day;         // Textual day of the week (Mon - Sun)
        private $dom;    // Numerical day of month
        private $month_num;   // Numberical month
        private $day_of_week; // Numerical day of the week (1-7, Mon = 1)
        private $day_of_year; // Numerical day of the year (1-366)
        private $year;        // Numerical year (e.g., 2008)
        private $shifts;      // array of Shifts
        private $mgr_notes;   // notes on night/weekend manager
        private $projects;    // array of Projects created by James Loeffler

        /*
         * Construct an BSCAHdate and initialize its vacant shifts
         * Test that arguments $mm, $dd, $yy are valid, using the
         * function checkdate
         */

        //edited by James Loeffler and Eric
        function __construct($id, $shifts, $mgr_notes, $projects) {
            $mm = substr($id, 0, 2);
            $dd = substr($id, 3, 2);
            $yy = substr($id, 6, 2);
            if (!checkdate($mm, $dd, $yy)) {
                error_log("Error: invalid date for BSCAHdate constructor " . $mm . $dd . $yy);
                return null;
            }
            $my_date = mktime(0, 0, 0, $mm, $dd, $yy);
          
            $this->id = date("m-d-y", $my_date);
            $this->month = date("M", $my_date);
            $this->day = date("D", $my_date);
            $this->year = date("Y", $my_date);
            $this->day_of_week = date("N", $my_date);
            $this->day_of_year = date("z", $my_date) + 1;
            $this->dom = date("d", $my_date);
            $this->month_num = date("m", $my_date);
            if (sizeof($shifts) !== 0) {
                $this->shifts = $shifts;
            }
            else {
                $this->generate_shifts($this->day_of_week);
            }
            //created by James Loeffler
            $this->generate_projects($this->id);
            
            $this->mgr_notes = $mgr_notes;
        }

        /*
         * Generate all shifts for all venues and groups on a given date,
         * using the master schedule as a template
         */

        function generate_shifts($day) {
            $venues = ["weekly"];
            $days = [1 => "Mon", 2 => "Tue", 3 => "Wed", 4 => "Thu", 5 => "Fri", 6 => "Sat", 7 => "Sun"];
            $this->shifts = [];
            /* $master[$i] is an array of
             * (venue, my_group, day, time, start, end, slots, persons, notes)
             */
            foreach ($venues as $venue) {
                    $master = get_master_shifts($venue, $days[$day]);
                    for ($i = 0; $i < sizeof($master); $i++) {
                        $t = $master[$i]->get_time();
                        $this->shifts[$t] = new Shift(
                            $this->id . "-" . $t, $venue, $master[$i]->get_slots(), null, null, "", "");
                }
            }
        }

        //Coppied from generate_shifts but changed to be generate projects by James Loeffler and Eric

        function generate_projects($id) {
            $this->projects = implode("*", select_dbProjects_by_date($id));
        }

        

        /*
         * @return "mm-dd-yy"
         */

        function get_id() {
            return $this->id;
        }

        function get_dom() {
            return $this->dom;
        }

        /*
         * @return the textual day of the week
         */

        function get_day() {
            return $this->day;
        }

        /*
         * @return the numerical day of the week
         */

        function get_day_of_week() {
            return $this->day_of_week;
        }

        /*
         * @return the numerical day of the year (starting at 1)
         */

        function get_day_of_year() {
            return $this->day_of_year;
        }

        /*
         * @return the year
         */

        function get_year() {
            return $this->year;
        }

        /*
         * @return the shifts
         */

        function get_shifts() {
            return $this->shifts;
        }


        //added by James Loeffler and Eric
        function get_projects() {
            return $this->projects;
        }

        /*
         * @return the number of shifts for this day
         */

        function get_num_shifts() {
            return count($this->shifts);
        }

        //added by James Loeffler and Eric
        function get_num_projects() {
            return count($this->projects);
        }

        /*
         * @return a shift
         * @param the shift's key
         */

        function get_shift($key) {
            return $this->shifts[$key];
        }

        //added by James Loeffler and Eric
        function get_project($key) {
            return $this->projects[$key];
        }

        /**
         * if there's a shift starting at $shift_start for the given venue, return its id.
         * Otherwise, return false
         */
        function get_shift_id($shift_start, $venue) {
            if ($shift_start == 21) {
                $candidate = $this->get_id() . "-overnight";
                foreach ($this->shifts as $shift) {
                    if ($shift->get_id() == $candidate) {
                        return $shift->get_id();
                    }
                }
            }
            else {
                for ($i = $shift_start + 1; $i < 22; $i++) {
                    $candidate = $this->get_id() . "-" . $shift_start . "-" . $i;
                    foreach ($this->shifts as $shift) {
                        if ($shift->get_id() == $candidate) {
                            return $shift->get_id();
                        }
                    }
                }
            }

            return false;
        }

        //added by James Loeffler and Eric
        /**function get_project_id($date) {
           
        }
**/
        /*
         * replace a shift by a new shift in a date's associative array of shifts
         * @param the shift, the new shift
         */

        function replace_shift($shift, $newshift) {
            $newshifts = [];
            foreach ($this->shifts as $key => $value) {
                if ($this->get_shift($key)->get_id() === $shift->get_id()) {
                    $newshifts[$newshift->get_id()] = $newshift;
                }
                else {
                    $newshifts[$key] = $value;
                }
            }
            $this->shifts = $newshifts;

            return $this;
        }

        // added by James Loeffler and Eric
       /** function replace_project($project, $newproject) {
            $newprojects = [];
            foreach ($this->projects as $key => $value) {
                if ($this->get_project($key)->get_id() === $project->get_id()) {
                    $newprojects[$newproject->get_id()] = $newproject;
                }
                else {
                    $newprojects[$key] = $value;
                }
            }
            $this->projects = $newprojects;

            return $this;
        }
        **/
        /**
         * @return a string name of the date
         */
        function get_name() {
            return date("F j, Y", mktime(0, 0, 0, $this->month_num, $this->dom, $this->year));
        }

        function get_end_time() {
            return mktime(23, 59, 59, $this->month_num, $this->dom, $this->year);
        }

        function get_mgr_notes() {
            return $this->mgr_notes;
        }

        function set_mgr_notes($s) {
            $this->mgr_notes = $s;
        }
        }
    
?>