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
     * class Shift characterizes a time interval in a day new Shift
     * for scheduling volunteers
     * @version May 1, 2008, modified 9/15/08, 2/14/10
     * @author Allen Tucker and Maxwell Palmer
     */

    include_once(dirname(__FILE__) . '/../database/dbShifts.php');
    include_once(dirname(__FILE__) . '/../database/dbPersons.php');

    class Shift {

        private $mm_dd_yy;      // String: "mm-dd-yy".
        // TODO: $name never actually gets set
        private $name;          // String: 'ss-ee' or 'overnight', where ss = start time and ee = end time e.g., '9-12'
        private $start_time;    // Integer: e.g. 10 (meaning 10:00am)
        private $end_time;      // Integer: e.g. 13 (meaning 1:00pm)
        private $venue;         //  "garden" or "pantry"
        private $vacancies;     // number of vacancies in this shift
        private $persons;       // array of person ids filling slots, followed by their name, ie "malcom1234567890+Malcom+Jones"
        private $removed_persons; // array of persons who have previously been removed from this shift.
        private $day;         // string name of day "Monday"...
        private $id;            // "mm-dd-yy-ss-ee" is a unique key for this shift
        private $notes;  // notes written by the manager

        /*
         * construct an empty shift with a certain number of vacancies
         */

        function __construct($date, $start_time, $end_time, $venue, $vacancies, $persons, $removed_persons, $notes) {
            $this->mm_dd_yy = str_replace("-", "/", $date); // Remember that '-' are for european dates (dd-mm-yyyy) and '/' are for american (mm/dd/yyy), the timestamp gets confused when we mix them up - GIOVI
            $this->start_time = $start_time;
            $this->end_time = $end_time;
            $this->venue = $venue;
            // TODO: generate_venue is broken, it references "$this" outside of an object context
//            generate_venue($venue);
            $this->vacancies = $vacancies;
            $this->persons = $persons;
            $this->removed_persons = $removed_persons;
            $this->day = date("D", mktime(0, 0, 0, substr($this->mm_dd_yy, 0, 2), substr($this->mm_dd_yy, 3, 2),
                                          "20" . substr($this->mm_dd_yy, 6, 2)));
            $this->id = str_replace("/", "-", $this->mm_dd_yy) . '-' . $start_time . '-' . $end_time . '-' . $this->venue;
            $this->notes = $notes;
        }

        /**
         * This function (re)sets the start and end times for a shift
         * and corrects its $id accordingly
         * Precondition:  0 <= $st && $st < $et && $et < 24
         *          && the shift is not "chef" or "night"
         * Postcondition: $this->start_time == $st && $this->end_time == $et
         *          && $this->id == $this->mm_dd_yy .  "-"
         *          . $this->start_time . "-" . $this->end_time . $this->venue
         *          && $this->name == substr($this->id, 9)
         */
        function set_start_end_time($st, $et) {
            if (0 <= $st && $st < $et && $et < 24 &&
                strpos(substr($this->id, 9), "-") !== false
            ) {
                $this->start_time = $st;
                $this->end_time = $et;
                $this->id = $this->mm_dd_yy . "-" . $this->start_time
                    . "-" . $this->end_time;
                $this->name = substr($this->id, 9);

                return $this;
            }
            else {
                return false;
            }
        }

        /*
         * @return the number of vacancies in this shift.
         */

        function num_vacancies() {
            return $this->vacancies;
        }

        function ignore_vacancy() {
            if ($this->vacancies > 0) {
                --$this->vacancies;
            }
        }

        function add_vacancy() {
            ++$this->vacancies;
        }

        function num_slots() {
            if (!$this->persons[0]) {
                array_shift($this->persons);
            }

            return $this->vacancies + count($this->persons);
        }

        /*
         * getters and setters
         */
        function get_mm_dd_yy() {
            return $this->mm_dd_yy;
        }

        function get_name() {
            return $this->name;
        }

        function get_start_time() {
            return $this->start_time;
        }

        function get_end_time() {
            return $this->end_time;
        }

        function get_time_of_day() {
            if ($this->start_time == 0) {
                return "Overnight";
            }
            else {
                if ($this->start_time <= 10) {
                    return "Morning(9-12)";
                }
                else {
                    if ($this->start_time <= 13) {
                        return "EarlyPM(12-3)";
                    }
                    else {
                        if ($this->start_time <= 16) {
                            return "LatePM(3-6)";
                        }
                        else {
                            return "Evening(6-9)";
                        }
                    }
                }
            }
        }

        function get_date() {
            return $this->mm_dd_yy;
        }

        function get_venue() {
            return $this->venue;
        }

        function get_num_of_persons() 
        {
            $peoparr = explode('*', $this->persons);
            $numberofpeople = count($peoparr);
            return $numberofpeople;
        }
        
        function get_persons() {
            return $this->persons;
        }

        function get_removed_persons() {
            return $this->removed_persons;
        }

        function get_id() {
            return $this->id;
        }

        function get_day() {
            return $this->day;
        }

        function get_notes() {
            return $this->notes;
        }

        function get_remaining_vacancies($id) //This returns the remaining vacancies a project has depending on how many people are already part of it - GIOVI
        {
            error_log("The id is " . $id);
            $shift = select_dbShifts($id);
            $peoparr = $shift->get_persons();
            $numofpeople = count($peoparr);
 
            $vacancies = $shift->get_vacancies() - $numofpeople;
            
            error_log("The remaining number of vacancies is $vacancies ----------------------------------------");
            
            return $vacancies;
        }
        
        function get_vacancies() {
            return $this->vacancies;
        }


        function set_notes($notes) {
            $this->notes = $notes;
        }

        function assign_persons($p) {
            foreach ($this->persons as $person) {
                if (!in_array($person, $p)) {
                    error_log("adding " . $person . " to removed persons");
                    $this->removed_persons[] = $person;
                }
            }
            $this->persons = $p;
        }

    function duration() {
        $time = [0, 0];
        $st = ConvertTimeToHrMin($this->start_time);
        $et = ConvertTimeToHrMin($this->end_time);
           
        if ($st[0] > $et[0]) //If start time is greater than end time, the result will be negative so add to 24 - GIOVI
        {
            $diff = $et[0] - $st[0];
            $time[0] = 24 + $diff;
        }
        
        if ($st[0] <= $et[0]) //If start time is less, then subtract as normal - GIOVI
        {
            $time[0] = $et[0] - $st[0];
        }
        
        if ($st[1] > $et[1]) //These are for minutes - GIOVI
        {
            $diff = $et[1] - $st[1];
            $time[1] = 60 + $diff;
            --$time[0];
        }
        
        if ($st[1] <= $et[1]) //These are for minutes - GIOVI
        {
            $time[1] = $et[1] - $st[1];
        }
        
            $padtime[0] = str_pad($time[0], 2, 0, STR_PAD_LEFT); //These are to ensure the time will be 4 digits (00:00) - GIOVI
            $padtime[1] = str_pad($time[1], 2, 0, STR_PAD_LEFT);
            
            $dur = implode('', $padtime);

                return $dur;
            
    }  

        /**
         * @return int the total number of slots (sum of available vacancies and the number of people currently registered)
         */
        function get_total_slots() {
            return $this->vacancies + count($this->persons);
        }

    }

    function report_shifts_staffed_vacant($from, $to) {
        $from_date = setFromDate($from);
        $to_date = setToDate($to);
        
        $reports = [];
        $all_shifts = get_all_shifts();
        $count = 0;
        
        foreach ($all_shifts as $s) 
        {
            $shift_date = date_create_from_mm_dd_yyyy($s->get_mm_dd_yy());
            
            if ($shift_date >= $from_date && $shift_date <= $to_date && $s->get_vacancies() != 0)
            {
                if (!isset($reports[$s->get_id()][0])) { $reports[$s->get_id()][0] = NULL; }
                
                error_log("Getting the number of remaining vacancies--------------------------------------------");
                
               $reports[$s->get_id()][0] += $s->get_remaining_vacancies($s->get_id());
               $count++;
            }
        }
        error_log("------- " . $count . " vacancy(ies) recorded-----------");    
        return $reports;
    }
    function generate_venue($venue)
    {
             if (is_int($venue))
            {
                if($venue == 0)
                $this->venue = "garden";

                elseif ($venue == 1)
                $this->venue = "pantry";

                else
                {
                    error_log("Not a valid entry for Venue");
                   
                }

            }

            if(is_string($venue))
            {
                if(strtolower($venue) == "garden" || strtolower($venue) == "pantry" )
                $this->venue = $venue;

                else
                {
                    error_log("Not a valid entry for Venue");
                   
                }

            }
    }




?>