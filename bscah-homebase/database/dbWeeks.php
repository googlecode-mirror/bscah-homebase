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
     * Drops the dbWeeks table if it exists, and creates a new one slots =
     * Table fields:
     * [0] id: mm-dd-yy
     * [1] dates: array of RMHDate ids
     * [2] weekday_group: which weekday group is working this week
     * [3] weekend_group: which weekend group is working this week
     * [4] status: "unpublished", "published" or "archived"
     * [5] name: name of the week
     * [6] end: timestamp of the end of the week
     */

    //edited by James Loeffler but still unsure about the parameters in the query
    function create_dbWeeks() {
        connect();
        mysql_query("DROP TABLE IF EXISTS WEEKS");
        $result = mysql_query("CREATE TABLE WEEKS (id CHAR(8) NOT NULL, dates TEXT,
								status TEXT,
								name TEXT, end INT, PRIMARY KEY (id))");
        if (!$result) {
            echo mysql_error();
        }
        mysql_close();
    }

    /**
     * Inserts a week into the db
     *
     * @param $w the week to insert
     */
    function insert_dbWeeks($w) {
        if (!$w instanceof Week) {
            die("Invalid argument for week->add_week function call");
        }
        connect();
        $query = sprintf(
            'SELECT * FROM DBBSCAH.WEEKS WHERE id=\'%s\'',
            $w->get_id()
        );
        $result = mysql_query($query);
        if (mysql_num_rows($result) != 0) {
            delete_dbWeeks($w);
            connect();
        }

        $query = sprintf(
            'INSERT INTO DBBSCAH.WEEKS VALUES("%s", "%s", "%s", %d)',
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
     * Deletes a week from the db
     *
     * @param $w the week to delete
     */
    function delete_dbWeeks($w) {
        if (!$w instanceof Week) {
            die("Invalid argument for delete_dbWeeks function call");
        }
        connect();
        $query = "DELETE FROM weeks WHERE id=\"" . $w->get_id() . "\"";
        $result = mysql_query($query);
        mysql_close();
        if (!$result) {
            echo("unable to delete from week: " . $w->get_id() . mysql_error());

            return false;
        }
        else {
            foreach ($w->get_dates() as $i) {
                delete_dbDates($i);
            }
        }

        return true;
    }

    /**
     * Updates a week in the db by deleting it and re-inserting it
     *
     * @param $w the week to update
     */
    function update_dbWeeks($w) {
        if (!$w instanceof Week) {
            die("Invalid argument for week->replace_week function call");
        }
        if (delete_dbWeeks($w)) {
            return insert_dbWeeks($w);
        }
        else {
            return false;
        }
    }

    /**
     * Selects a week from the database
     *
     * @param $id week id --
     *
     * @return mysql entry corresponding to id
     */
    function select_dbWeeks($id) {
        if (strlen($id) != 8) {
            die("Invalid week id." . $id);
        }
        else {
            $timestamp = mktime(0, 0, 0, substr($id, 0, 2), substr($id, 3, 2), substr($id, 6, 2));
            $dow = date("N", $timestamp);
            $id2 = date("m-d-y", mktime(0, 0, 0, substr($id, 0, 2), substr($id, 3, 2) - $dow + 1, substr($id, 6, 2)));
        }
        connect();
        $query = "SELECT * FROM weeks WHERE id =\"" . $id2 . "\"";
        $result = mysql_query($query);
        if (!$result || mysql_numrows($result) == 0) {
            $query = "SELECT * FROM weeks WHERE id =\"" . $id . "\"";
            $result = mysql_query($query);
            if (!$result) {
                echo '<br>Could not run query: ' . mysql_error();
                $result_row = false;
            }
            else {
                $result_row = mysql_fetch_assoc($result);
            }
        }
        else {
            $result_row = mysql_fetch_assoc($result);
        }
        mysql_close();

        return $result_row;
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
            $dates = explode("*", $result_row['dates']);
            $d = [];
            foreach ($dates as $date) {
                $temp = select_dbDates($date);
                $d[] = $temp;
            }
            $w = new Week($d, $result_row['status']);
            error_log("3");
            return $w;
        }
        else {
            return null;
        }
    }

    /**
     * the full contents of dbWeeks, used by addWeek to list all scheduld weeks
     * @return mysql result array of weeks
     */
    function get_all_dbWeeks() {
        connect();
        $query = "SELECT * FROM weeks ORDER BY end";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in get_all_dbWeeks ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();
        $weeks = [];
        while ($result_row = mysql_fetch_assoc($result)) {
            error_log($result_row['id']);
            $w = get_dbWeeks($result_row['id']);
            $weeks[] = $w;
        }
        return $weeks;
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
