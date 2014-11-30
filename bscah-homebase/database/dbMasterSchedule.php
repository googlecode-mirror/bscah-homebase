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


    include_once(dirname(__FILE__) . '/../domain/MasterScheduleEntry.php');
    include_once('dbinfo.php');

   

    function insert_dbMasterSchedule(MasterScheduleEntry $entry) {
        connect();
        $result = mysql_query("SELECT * FROM MASTERSCHEDULE WHERE MS_ID = '" . $entry->get_MS_ID() . "'");
        if (!$result) {
            error_log('ERROR on select in insert_dbMasterSchedule() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (mysql_num_rows($result) != 0) {
            delete_dbMasterSchedule($entry->get_MS_ID());
            connect();
        }


        $query = "INSERT INTO MASTERSCHEDULE VALUES ('" .
            $entry->get_MS_ID() . "','" .
            $entry->get_Schedule_type() . "','" .
            $entry->get_day() . "','" .
            $entry->get_start_time() . "','" .
            $entry->get_end_time() . "','" .
            $entry->get_slots() . "','" .
            $entry->get_persons() . "','" .
            $entry->get_notes() . "','" .
            $entry->get_Shifts() .
            "');";
        //TODO: Log in a separate file
        //error_log("in insert into master schedule, query is " . $query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in insert_dbMasterSchedule() ' . mysql_error() . " - Unable to insert in MASTERSCHEDULE: " . $entry->get_MS_ID() );
            mysql_close();

            return false;
        }
        mysql_close();

        return true;
    }

    function retrieve_dbMasterSchedule($MS_ID) {
        connect();
        $query = "SELECT * FROM MASTERSCHEDULE WHERE MS_ID LIKE '%" . $MS_ID . "%'";
        //TODO: Log in a separate file
        //error_log('in retrieve_dbMasterSchedule, query is ' . $query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in retrieve_dbMasterSchedule() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (mysql_num_rows($result) != 1) {
            mysql_close();

            return false;
        }
        $result_row = mysql_fetch_assoc($result);
        $theEntry = new MasterScheduleEntry($result_row['SCHEDULE_TYPE'], $result_row['DAY'],
                                            $result_row['START_TIME'], $result_row['END_TIME'], $result_row['SLOTS'],
                                            $result_row['PERSONS'],
                                            $result_row['NOTES'], $result_row['SHIFTS']);
        mysql_close();

        return $theEntry;
    }

    function update_dbMasterSchedule($entry) {
        connect();
        if (!$entry instanceof MasterScheduleEntry) {
            error_log("Invalid argument for update_masterschedule function call");

            return false;
        }
        if (delete_dbMasterschedule($entry->get_MS_ID())) {
            return insert_dbMasterschedule($entry);
        }
        else {
            error_log(mysql_error() . " - Unable to update MASTERSCHEDULE: " . $entry->get_MS_ID() );

            return false;
        }
        mysql_close();

        return true;
    }

    function delete_dbMasterSchedule($MS_ID) {
        connect();
        $query = "DELETE FROM MASTERSCHEDULE WHERE MS_ID = '" . $MS_ID . "'";
        error_log('in delete_dbMasterSchedule query is '.$query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on DELETE in delete_dbMasterSchedule() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (!$result) {
            error_log(mysql_error() . " - Unable to delete from MASTERSCHEDULE: " . $MS_ID );

            return false;
        }
        mysql_close();

        return true;
    }

    // this checks if the shift & project overlaps another, and if it does not, it inserts it into the database
    function insert_nonoverlapping($shift) {
        $other_shifts = get_master_shifts($shift->get_schedule_type(), $shift->get_day());

        foreach ($other_shifts as $other_shift) {
            if (masterslots_overlap($shift->get_start_time(), $shift->get_end_time(), $other_shift->get_start_time(),
                                    $other_shift->get_end_time())) {
                return false;
            }
        }
        insert_dbMasterSchedule($shift);

        return true;
    }


    /**
     * @result == true if $s1's timeslot overlaps $s2's timeslot, and false otherwise.
     */
    function masterslots_overlap($s1_start, $s1_end, $s2_start, $s2_end) {
        if ($s1_start == "overnight" && $s2_start == "overnight") {
            return true;
        }
        else {
            if ($s1_start == "overnight" || $s2_start == "overnight") {
                return false;
            }
        }
        if ($s1_end > $s2_start) {
            if ($s1_start >= $s2_end) {
                return false;
            }
            else {
                return true;
            }
        }
        else {
            return false;
        }
    }

    /*
     * Each row in the array is a MasterScheduleEntry
     * If there are no entries, return an empty array
     * @return MasterScheduleEntry[] all master schedule entries for a particular venue and day for shifts
     */
    function get_master_shifts($type, $day) {
        connect();
        $query = "SELECT * FROM MASTERSCHEDULE WHERE DAY = '" . $day .
            "' AND schedule_type = '" . $type . "'";
        error_log('in get_master_shifts  query is '.$query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in get_master_shifts ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();
        $outcome = [];
        if (mysql_num_rows($result) == 0) {
            return $outcome;
        }
        for ($i = 0; $i < mysql_num_rows($result); $i++) {
            $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
            // problem - something about this call is faulty - it does not seem to be going through
            // to the constructor.
            $testVar = new MasterScheduleEntry($result_row['SCHEDULE_TYPE'], $result_row['DAY'],
                                               $result_row['START_TIME'], $result_row['END_TIME'], $result_row['SLOTS'],
                                               $result_row['PERSONS'],
                                               $result_row['NOTES'], $result_row['SHIFTS']);
            $outcome[] = $testVar;
        }

        return $outcome;
    }

    /* schedule a person for a given day and time and venue in group One or Two
     * update that persons schedule in the dbPersons table
     *
     */

    function schedule_person($venue, $day, $time, $person_id) {
        connect();
        $query1 = "SELECT * FROM MASTERSCHEDULE WHERE MS_ID = '" .
            $venue . $day . "-" . $time . "'";
        $query2 = "SELECT * FROM PERSON WHERE MS_ID = '" . $person_id . "'";
        error_log('in schedule_person query is '.$query1);
        error_log('in schedule_person second query is '.$query2);
        $result = mysql_query($query1);
        $resultp = mysql_query($query2);
        if (!$result || !$resultp) {
            die("schedule_person could not query the database");
        }
        // be sure the master project and person both exist
        if (mysql_num_rows($result) !== 1 || mysql_num_rows($resultp) !== 1) {
            mysql_close();
            die("schedule_person couldnt retrieve 1 person and 1 dbScheduleEntry");
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
        $resultp_row = mysql_fetch_array($resultp, MYSQL_ASSOC);
        $persons = explode(',', $result_row['PERSONS']);    // get an array of scheduled person id's
        $schedule = explode(',', $resultp_row['SCHEDULE']); // get an array of person's scheduled times
        $availability = explode(',', $resultp_row['AVAILABILITY']);     // and their availabiltiy
        if (// in_array(substr($day,0,3).$chrtime, $availability) &&
            !in_array($person_id, $persons) &&
            !in_array($day . $time, $schedule)
        ) {
            $persons[] = $person_id;             // add the person to the array, and
            $schedule[] = $venue . $day . "-" . $time; // add the time to the person's schedule
            $result_row['PERSONS'] = implode(',', $persons);     // and update one row in each table
            $resultp_row['SCHEDULE'] = implode(',', $schedule);  // in the database
            mysql_query("UPDATE MASTERSCHEDULE SET PERSONS = '" . $result_row['persons'] .
                        "' WHERE ID = '" . $venue . $day . "-" . $time . "'");
            mysql_query("UPDATE persons SET schedule = '" . $resultp_row['schedule'] .
                        "' WHERE id = '" . $person_id . "'");
            mysql_close();

            return "";
        }
        mysql_close();

        return "Error: can't schedule a person not available or already scheduled";
    }

    /* unschedule a volunteer from a venue and group at a given day and time
     * update that person's schedule in the dbPersons table
     *
     */

    function unschedule_person($venue, $day, $time, $person_id) {
        connect();
        $query = "SELECT * FROM MASTERSCHEDULE WHERE ID = '" .
            $venue . $day . "-" . $time . "'";
        error_log('in unschedule_person query is '.$query);
        $queryp = "SELECT * FROM PERSON WHERE ID = '" . $person_id . "'";
        error_log('in unschedule_person second query is '.$queryp);
        $result = mysql_query($query);
        $resultp = mysql_query($queryp);
        // be sure the person exists and is scheduled
        if (!$result || mysql_num_rows($result) !== 1) {
            mysql_close();
            die("Error: group-day-time not valid");
        }
        else {
            if (!$resultp || mysql_num_rows($resultp) !== 1) {
                $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
                $persons = explode(',', $result_row['PERSONS']);    // get an array of scheduled person id's
                if (in_array($person_id, $persons)) {
                    $index = array_search($person_id, $persons);
                    array_splice($persons, $index, 1);               // remove the person from the array, and
                    $result_row['PERSONS'] = implode(',', $persons); // and update one row in the schedule
                    mysql_query("UPDATE MASTERSCHEDULE SET PERSONS = '" . $result_row['PERSONS'] .
                                "' WHERE ID = '" . $venue . $day . "-" . $time . "'");
                }
                mysql_close();
                die("Error: person not in database" . $person_id);
            }
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
        $resultp_row = mysql_fetch_array($resultp, MYSQL_ASSOC);
        $persons = explode(',', $result_row['PERSONS']);    // get an array of scheduled person id's
        $schedule = explode(',', $resultp_row['SCHEDULE']); // get an array of person's scheduled times
        if (in_array($person_id, $persons) /* && in_array($venue . $day . "-" . $time, $schedule)*/) {
            $index = array_search($person_id, $persons);
            $indexp = array_search($venue . $day . "-" . $time, $schedule);
            array_splice($persons, $index, 1);   // remove the person from the array, and
            if (in_array($venue . $day . "-" . $time, $schedule)) {
                array_splice($schedule, $indexp, 1);
            } // remove the time from the person's schedule
            $result_row['PERSONS'] = implode(',', $persons);     // and update one row in each table
            $resultp_row['SCHEDULE'] = implode(',', $schedule);  // in the database
            mysql_query("UPDATE MASTERSCHEDULE SET PERSONS = '" . $result_row['PERSONS'] .
                        "' WHERE ID = '" . $venue . $day . "-" . $time . "'");
            mysql_query("UPDATE PERSONS SET SCHEDULE = '" . $resultp_row['SCHEDULE'] .
                        "' WHERE ID = '" . $person_id . "'");
            mysql_close();

            return "";
        }
        mysql_close();
        die("Error: can't unschedule a person not scheduled");
    }

    /* insert a note in the schedule for a given venue, group, day, and time.
     *
     */

    function make_notes($venue, $day, $time, $notes) {
        connect();
        $query = "SELECT * FROM MASTERSCHEDULE WHERE SCHEDULE_TYPE = '" .
            $venue . "' AND DAY = '" .
            $day . "' AND TIME = '" . $time . "'";
        error_log('in make_notes query is '.$query);
        $result = mysql_query($query);
        if (!$result) {
            die("make_notes could not query the database");
        }
        // be sure the person exists and is scheduled
        if (mysql_num_rows($result) !== 1) {
            mysql_close();

            return "Error: group-day-time not valid";
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
        $result_row['notes'] = $notes;
        mysql_query("UPDATE MASTERSCHEDULE SET NOTES = '" . $result_row['NOTES'] . "' WHERE SCHEDULE_TYPE = '" .
                    $venue .
                    "' AND DAY = '" . $day . "' AND TIME = '" . $time . "'");
        mysql_close();

        return "";
    }

    /*
     * @return whether or not a person is scheduled in a given venue, group, day and time
     *
     */

    function is_scheduled($venue, $day, $time, $person_id) {
        connect();
        $query = "SELECT * FROM MASTERSCHEDULE WHERE SCHEDULE_TYPE = '" .
            $venue .
            "' AND DAY = '" .
            $day . "' AND TIME = '" . $time . "'";
        error_log('in is_scheduled query is '.$query);
        $result = mysql_query($query);
        if (!$result) {
            die("is_scheduled could not query the database");
        }
        if (mysql_num_rows($result) !== 1) {
            mysql_close();

            return "Error: group-day-time not valid";
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
        $persons = explode(',', $result_row['PERSONS']);    // get array of scheduled person id's
        mysql_close();
        if (in_array($person_id, $persons)) {
            return true;
        }
        else {
            return false;
        }
    }

    /*
     * @return all persons scheduled for a particular venue, group, day, and time
     * as an array of associative arrays.  Each associative array has
     * entries indexed by the field names of a person in dbPersons.
     */

    function get_persons($Schedule_type, $day, $time) {
        connect();
        $query1 = "SELECT * FROM MASTERSCHEDULE WHERE MS_ID = '" .
            $Schedule_type . $day . "-" . $time . "'";
        error_log('in get_persons query is '.$query1);
        $result = mysql_query($query1);
        if (!$result) {
            die("get_persons could not query the database");
        }
        $out = [];
        if (mysql_num_rows($result) !== 1) {
            mysql_close();
            $out[] = "Error: group-day-time not valid";

            return $out;
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
        $person_ids = explode(',', $result_row['PERSONS']);    // get an array of scheduled person id's
        foreach ($person_ids as $person_id) {
            if ($person_id != "") {
                $query2 = "SELECT * FROM PERSON WHERE ID = '" . $person_id . "'";
                $resultp = mysql_query($query2);
                if (!$resultp) {
                    die("get_persons could not query the database");
                }
                if (mysql_num_rows($resultp) !== 1) {
                    mysql_close();
                    $out[] = $person_id;

                    return $out;
                }
                $out[] = mysql_fetch_array($resultp, MYSQL_ASSOC);
            }
        }
        mysql_close();

        return $out;
    }

    /*
     * @return ids of all persons scheduled for a particular schedule_type, Week_no, day, and time
     */

    function get_person_ids($Schedule_type, $day, $time) {
        connect();
        $query1 = "SELECT * FROM MASTERSCHEDULE WHERE MS_ID = '" .
            $Schedule_type . $day . "-" . $time . "'";
        error_log('in get_person_ids query is '.$query1);
        $result = mysql_query($query1);
        if (!$result) {
            die("get_person_ids could not query the database");
        }
        if (mysql_num_rows($result) !== 1) {
            mysql_close();

            return ["Error: group-day-time not valid"];
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
        $person_ids = explode(',', $result_row['PERSONS']);
        mysql_close();

        return $person_ids;
    }

    /*
     * @return number of slots for a particular schedule_type, Week_no, day, and time
     * this is fixed with a kluge.
     */

    function get_total_slots($Schedule_type, $day, $time) {
        connect();
        $query1 = "SELECT * FROM MASTERSCHEDULE WHERE MS_ID = '" .
            $Schedule_type . $day . "-" . $time . "'";
        error_log('in get_total_slots query is '.$query1);
        $result = mysql_query($query1);
        if (!$result) {
            die("get_total_slots could not query the database");
        }
        if (mysql_num_rows($result) !== 1) {
            mysql_close();

            return "Error: group-day-time not valid";
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);

        return $result_row['slots'];
    }

    /*
     * @return number of vacancies for a particular schedule_type, Week_no, day, and time
     */
    function get_total_vacancies($Schedule_type, $day, $time) {
        $slots = get_total_slots($Schedule_type, $day, $time);
        $persons = count(get_persons($Schedule_type, $day, $time));

        return $slots - $persons;
    }

    function check_valid_schedule($Schedule_type, $day, $time) {
        connect();
        $query1 = "SELECT * FROM MASTERSCHEDULE WHERE MS_ID = '" .
            $Schedule_type . $day . "-" . $time . "'";
        error_log('in check_valid_schedule query is '.$query1);
        $result = mysql_query($query1);
        mysql_close();
        if (!$result) {
            die("check_valid_schedule could not query the database");
        }
        if (mysql_num_rows($result) !== 1) {
            return false;
        }

        return true;
    }

    /*
     * @return number of vacancies for a particular venue, group, day, and time
     */

    function edit_schedule_vacancy($Schedule_type, $day, $time, $change) {
        connect();
        $query1 = "SELECT * FROM MASTERSCHEDULE WHERE MS_ID = '" .
            $Schedule_type . $day . "-" . $time . "'";
        error_log('in edit_schedule_vacancy query is '.$query1);
        $result = mysql_query($query1);
        if (!$result) {
            die("edit_schedule_vacancy could not query the database");
        }
        if (mysql_num_rows($result) !== 1) {
            mysql_close();

            return false;
        }
        $result_row = mysql_fetch_array($result, MYSQL_ASSOC);
        $result_row['slots'] = $result_row['SLOTS'] + $change;
        // id = schedule_type.day.Week_no.start_time."-".end_time
        mysql_query("UPDATE MASTERSCHEDULE SET SLOTS = '" . $result_row['SLOTS'] .
                    "' WHERE MS_ID = '" . $Schedule_type . $day . "-" . $time . "'");
        mysql_close();

        return true;
    }

?>
