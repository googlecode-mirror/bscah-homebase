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
     * Adds a RMHDate to the table
     * If the date already exists, the date is deleted and replaced.
     */
    function insert_dbDates(BSCAHdate $d) {
        connect();
        $query = "SELECT * FROM DATE WHERE DATE_ID =\"" . $d->get_id() . "\"";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in insert_dbDates() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (mysql_num_rows($result) != 0) {
            delete_dbDates($d);
            connect();
        }
        $query = sprintf(
            'INSERT INTO DATE VALUES ("%s", "%s", "%s", "%s")',
            $d->get_id(),
            get_shifts_text($d),
            $d->get_mgr_notes(),
            $d->get_projects()// TODO: What are projects and what do we have to put them into the DB as?
        );
        $result = mysql_query($query);

        if (!$result) {
            echo("unable to insert into DATE: " . $d->get_id() . mysql_error());
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
            error_log("Invalid argument for shift->remove_date function call");
            die("Invalid argument for shift->remove_date function call");
        }
        connect();
        $query = "DELETE FROM DATE WHERE DATE_ID=\"" . $d->get_id() . "\"";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in delete_dbDates() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (!$result) {
            error_log("unable to delete from DATE: " . $d->get_id() . mysql_error());
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
     * @return BSCAHdate
     */
    function select_dbDates($id) {
        if (strlen($id) != 8) {
            error_log('in select_dbDates,  Invalid argument for date->select_dbDates call = '. $id);
            die("Invalid argument for date->select_dbDates call =" . $id);
        }
        connect();
        $query = "SELECT * FROM DATE WHERE DATE_ID =\"" . $id . "\"";
        error_log('in select_dbDates query is ' . $query);
        $result = mysql_query($query);
        mysql_close();
        if (!$result) {
           // echo 'Could not select from date: ' . $id;
            error_log('Could not select from DATE: ' . $id);

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

                $d = new BSCAHdate($result_row[0], $s, "", []);


                error_log($d->get_projects());

                return $d;
            }
            else {
                error_log("Could not fetch from DATE " . $id);

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

    function update_dbDates_projects($date) {
        $db_date = select_dbDates($date);
        if($db_date != null) {
            insert_dbDates_project($db_date);
        }
        else {
            error_log("Date is currently not in DATE table");
        }
        return $db_date != null;
    }

    function insert_dbDates_project(BSCAHdate $d) {
        connect();

        $query = sprintf(
            'UPDATE DATE SET PROJECTS = "%s" WHERE DATE_ID = "%s"',
            $d->get_projects(),
            $d->get_id()
        );
        error_log("in insert_dbDates, query is" . $query);
        $result = mysql_query($query);

        if (!$result) {
            echo("unable to insert into DATE: " . $d->get_id() . mysql_error());
            mysql_close();

            return false;
        }
        mysql_close();
        return true;
    }
?>