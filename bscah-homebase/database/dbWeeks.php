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
     * dbWeeks table in the database.  This table is used with the week
     * class.  Weeks are generated using the master schedule (through the
     * addWeek.php form), and retrieved by the calendar form and addWeek.php.
     * @version May 1, 2008, modified September 15, 2008
     * @author Maxwell Palmer and Allen Tucker
     */

    include_once(dirname(__FILE__) . '/../domain/Week.php');
    include_once('dbinfo.php');
    include_once('dbDates.php');

    

    /**
     * Inserts a week into the db
     *
     * @param $w Week the week to insert
     */
    function insert_dbWeeks(Week $w) {
        if (!assert_week_format($w)) {
            error_log("ERROR: Your week object did not start on a Sunday or did not have a length of 7 days");
            return false;
        }
        connect();
        $query = sprintf(
            'SELECT * FROM WEEKS WHERE ID=\'%s\'',
            $w->get_id()
        );
        $result = mysql_query($query);
        if (mysql_num_rows($result) != 0) {
            delete_dbWeeks($w);
            connect();
        }

        $query = sprintf(
            'INSERT INTO WEEKS VALUES("%s", "%s", "%s", %d)',
            $w->get_id(),
            get_dates_text($w->get_dates()),
            $w->get_status(),
            $w->get_end() // This one is an integer, so we don't need quotes around it in the template above
        );

        $result = mysql_query($query);
        mysql_close();
        if (!$result) {
            echo("<br>unable to insert into week: " . $w->get_id() . get_dates_text($w->get_dates()) .
                $w->get_status() . $w->get_name() . $w->get_end());

            return false;
        }
        else {
            foreach ($w->get_dates() as $i) {
                insert_dbDates($i);
            }
        }

        return true;
    }

    /**
     * Use this method to sanity-check a Week object before it is inserted into the database
     * @param Week $w The week object to check
     *
     * @return bool true only if the week starts on a Sunday and has a length of 7 days, otherwise return false
     */
    function assert_week_format(Week $w) {
        $date = DateTime::createFromFormat("m-d-y", $w->get_id());
        $dow = $date->format("w");
        return $dow == 0 && count($w->get_dates()) == 7;
    }

    /**
     * Deletes a week from the db
     *
     * @param $w Week the week to delete
     */
    function delete_dbWeeks($w) {
        if (!$w instanceof Week) {
            die("Invalid argument for delete_dbWeeks function call");
        }
        connect();
        $query = "DELETE FROM WEEKS WHERE ID=\"" . $w->get_id() . "\"";
        error_log('in delete_dbWeeks query is '.$query);
        $result = mysql_query($query);
        mysql_close();
        if (!$result) {
            error_log("unable to delete from week: " . $w->get_id() . mysql_error());
            return false;
        }

        foreach ($w->get_dates() as $i) {
            delete_dbDates($i);
        }

        return true;
    }

    /**
     * Updates a week in the db by deleting it and re-inserting it
     *
     * @param $w Week the week to update
     */
    function update_dbWeeks(Week $w) {
        if (delete_dbWeeks($w)) {
            return insert_dbWeeks($w);
        }
        return false;
    }

    /**
     * Selects a week from the database
     *
     * @param $id id --
     *
     * @return array mysql entry corresponding to id
     */
    function select_dbWeeks($id) {
        if (!is_string($id)) {
            error_log("select_dbWeeks must have an id of string, but user provided a " . get_class($id));
            return false;
        }
        if (strlen($id) != 8) {
            die("Invalid week id." . $id);
        }
        $date = DateTime::createFromFormat("m-d-y", $id);
        $dow = $date->format("w");
        $sunday = $date->modify("-$dow day");


        connect();
        $query = "SELECT * FROM WEEKS WHERE ID =\"" . $sunday->format("m-d-y") . "\"";
        error_log('in select_dbWeeks query is '.$query);
        $result = mysql_query($query);

        if (!$result) {
            error_log("Could not select week " . $id);
        }
        mysql_close();

        return mysql_fetch_assoc($result);
    }

    /**
     * retrieves a Week from the database
     *
     * @param $id = mm-dd-yy of the week to retrieve
     *
     * @return Week desired week, or null
     */
    function get_dbWeeks($id) {
        $result_row = select_dbWeeks($id);

        if ($result_row != null) {
            $dates = explode("*", $result_row['DATES']);
            $d = [];
            foreach ($dates as $date) {
                $temp = select_dbDates($date);
                $d[] = $temp;
            }
            $w = new Week($d, $result_row['STATUS']);
            return $w;
        }
        else {
            return null;
        }
    }

    /**
     * the full contents of dbWeeks, used by addWeek to list all scheduld weeks
     * @return Week[] mysql result array of weeks
     */
    function get_all_dbWeeks() {
        connect();
        $query = "SELECT ID FROM WEEKS ORDER BY END";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in get_all_dbWeeks ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();
        $weeks = [];

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $weeks[] = get_dbWeeks($row['ID']);
        }

        return $weeks;
    }

    /**
     * @return Week[] all dbWeeks that are published
     */
    function get_all_published_dbWeeks() {
        connect();
        $query = "SELECT ID FROM WEEKS WHERE STATUS!='unpublished' ORDER BY END";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in get_all_dbWeeks ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();
        $weeks = [];

        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $weeks[] = get_dbWeeks($row['ID']);
        }

        return $weeks;
    }

    /**
     * @return int The number of weeks in WEEKS
     */
    function get_dbWeeks_count() {
        connect();
        $query = "SELECT COUNT(*) FROM WEEKS";
        $result = mysql_query($query);
        if (!$result) {
            $mysql_error = mysql_error();
            error_log("ERROR on count in get_dbWeeks_count $mysql_error");
            die ("Invalid query: $mysql_error");
        }
        mysql_close();
        return $result;
    }

    /**
     * generates a string of date ids
     *
     * @param $dates array of dates for a week
     *
     * @return string of date ids, * delimited
     */
    function get_dates_text($dates) {
        $d =$dates[0]->get_id();
        for ($i = 1; $i < 7; ++$i) {
            $d = $d . "*" . $dates[$i]->get_id();
        }

        return $d;
    }

?>
