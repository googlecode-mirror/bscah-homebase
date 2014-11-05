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
     * Functions to create, update, and retrieve information from the
     * dbDates table in the database.  This table is used with the RMHDate
     * class.  Dates are generated using the master schedule (through the
     * addWeek.php form), and retrieved by the calendar forms.
     * @version May 1, 2008
     * @author Maxwell Palmer
     */

    include_once(dirname(__FILE__) . '/../domain/BSCAHdate.php');
    include_once('dbShifts.php');
    include_once(dirname(__FILE__) . '/../domain/Shift.php');
    include_once('dbinfo.php');

    /**
     * Drops dbDates table and creates a new one.
     * Elements of dbDates:
     *  id: mm-dd-yy
     *  shifts - * delimited list of shift ids
     *  manager notes
     */
    function create_dbDates() {
        connect();
        mysql_query("DROP TABLE IF EXISTS date");
        //Edited by James Loeffler by adding projects as a parameter
        $result = mysql_query("CREATE TABLE date (id CHAR(8) NOT NULL, shifts TEXT,
								mgr_notes TEXT, projects TEXT, PRIMARY KEY (id))");
        if (!$result) {
            echo mysql_error();
        }
        mysql_close();
    }

    /**
     * Adds a RMHDate to the table
     * If the date already exists, the date is deleted and replaced.
     */
    function insert_dbDates($d) {
        if (!$d instanceof BSCAHdate) {
            die("Invalid argument for date->insert_dbdates function call");
        }
        connect();
        $query = "SELECT * FROM date WHERE DATE_ID =\"" . $d->get_id() . "\"";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in insert_dbDates() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (mysql_num_rows($result) != 0) {
            delete_dbDates($d);
            connect();
        }
        $query = "INSERT INTO date VALUES
				(\"" . $d->get_id() . "\",\"" .
            get_shifts_text($d) . "\",\"" . $d->get_mgr_notes() . "\",\"" . $d->get_projects()."\")";
        error_log("in insert_dbDates, query is" . $query);
        $result = mysql_query($query);

        if (!$result) {
            echo("unable to insert into date: " . $d->get_id() . mysql_error());
            mysql_close();

            return false;
        }
        mysql_close();
        $shifts = $d->get_shifts();
        foreach ($shifts as $key => $value) {
            insert_dbShifts($d->get_shift($key));
        }

        return true;
    }

    /**
     * deletes a date from the table
     */
    function delete_dbDates($d) {
        if (!$d instanceof BSCAHdate) {
            die("Invalid argument for shift->remove_date function call");
        }
        connect();
        $query = "DELETE FROM date WHERE DATE_ID=\"" . $d->get_id() . "\"";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in delete_dbDates() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (!$result) {
            echo("unable to delete from date: " . $d->get_id() . mysql_error());
            mysql_close();

            return false;
        }
        mysql_close();
        $shifts = $d->get_shifts();
        foreach ($shifts as $key => $value) {
            $s = $d->get_shift($key);
            delete_dbShifts($s);
        }

        return true;
    }

    /**
     * updates a date in the dbDates table
     */
    function update_dbDates($d) {
        if (!$d instanceof BSCAHdate) {
            die("Invalid argument for date->update_dbDates function call");
        }
        delete_dbDates($d);
        insert_dbDates($d);

        return true;
    }

    /**
     * replaces a date in the dbDates table by a new one (with a different shift);
     * makes no changes to the dbShifts table
     */
    function replace_dbDates($old_s, $new_s) {
        if (!$old_s instanceof Shift || !$new_s instanceof Shift) {
            die("Invalid argument for date->replace_dbDates function call");
        }
        $d = select_dbDates(substr($old_s->get_id(), 0, 8));
        $d = $d->replace_shift($old_s, $new_s);
        update_dbDates($d);

        return true;
    }

    /**
     * selects a date from the table
     * @return RMHDate
     */
    function select_dbDates($id) {
        if (strlen($id) != 8) {
            die("Invalid argument for date->select_dbDates call =" . $id);
        }
        connect();
        $query = "SELECT * FROM date WHERE date_id =\"" . $id . "\"";
        error_log("in select_dbDates, query is " . $query);
        $result = mysql_query($query);
        mysql_close();
        if (!$result) {
            echo 'Could not select from date: ' . $id;
            error_log('Could not select from date: ' . $id);

            return null;
        }
        else {
            $result_row = mysql_fetch_row($result);
            if ($result_row) {
                $shifts = $result_row[1];
                $shifts = explode("*", $shifts);
                $s = [];
                foreach ($shifts as $i) {
                    $temp = select_dbShifts($i);
                    if ($temp instanceof Shift) {
                        $s[$temp->get_name()] = $temp;
                    }
                }
                $d = new BSCAHdate($result_row[0], $s, "", $result_row[2]); // TODO: This constructor is malformed somehow

                return $d;
            }
            else {
                error_log("Could not fetch from date " . $id);

                return null;
            }
        }
    }

    /**
     * @return a * delimited list of the ids of the shifts for the specified day
     */
    function get_shifts_text($d) {
        $shifts = $d->get_shifts();
        $shift_text = "";
        foreach ($shifts as $key => $value) {
            $shift_text = $shift_text . "*" . $d->get_shift($key)->get_id();
        }
        $shift_text = substr($shift_text, 1);

        return $shift_text;
    }
    
    function update_dbDates_projects($date)
    {
        $db_date = select_dbDates($date);
        $db_date->generate_projects($date);
        update_dbDates($db_date);
        
    }                        
   
    


?>