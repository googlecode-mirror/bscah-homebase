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
        private $MS_ID;            // unique string for each entry = schedule_type.day.start_time."-".end_time eg: monthlyWed14-17
        private $Schedule_type; // pantry or garden
        private $day;           // "Mon", "Tue", ... "Sun"
        private $start_time;    // start time for the shift (9 - 21) eg: 10 means 10am, 13 means 1pm
        private $end_time;      //end time for the shift & project(9 - 21) eg: 10 means 10am, 13 means 1pm
        private $slots;         // the number of slots to be filled for this shift & project
        private $notes;         // notes to be displayed for this shift & project on the schedule
        private $Shifts;        // text that explains what shift is within the slot

        /**
         * constructor for all MasterScheduleEntries
         */
        function __construct($Schedule_type, $day, $start_time, $end_time, $slots, $notes,
            $Shifts) {
            //   error_log('in MSE constructor');
            $this->MS_ID = $Schedule_type . $day . $start_time . "-" . $end_time;
            $this->Schedule_type = $Schedule_type;
            //        error_log('schedule type is ' . $Schedule_type);
            $this->day = $day;
            //        error_log('day '.$day);
            $this->start_time = $start_time;
            //        error_log('start time '.$start_time);
            $this->end_time = $end_time;
            //      error_log('end time '.$end_time);
            $this->slots = $slots;
            //         error_log('slots '.$slots);
            $this->notes = $notes;
            // error_log('notes '.$notes);
            $this->Shifts = $Shifts;
            //   error_log('shifts '.$Shifts);
        }

        /**
         *  getter functions
         */

        function get_MS_ID() {
            return $this->MS_ID;
        }

        function get_Schedule_type() {
            return $this->Schedule_type;
        }

        function get_day() {
            return $this->day;
        }

        function get_start_time() {
            return $this->start_time;
        }

        function get_end_time() {
            return $this->end_time;
        }

        function get_time() {
            if ($this->start_time != "overnight") {
                return $this->start_time . "-" . $this->end_time;
            }
            else {
                return "overnight";
            }
        }

        function get_slots() {
            return $this->slots;
        }

        function get_notes() {
            return $this->notes;
        }

        function get_Shifts() {
            return $this->Shifts;
        }

        function set_notes($notes) {
            $this->notes = $notes;
        }

        function set_end_time($time) {
            $this->end_time = $time;
        }

    }

?>