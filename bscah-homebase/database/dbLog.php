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
     * dbLog table in the database.  dbLog is not linked to an object
     * class.
     * @version May 1, 2008
     * @author Maxwell Palmer
     */
    include_once('dbinfo.php');

    /**
     * Sets up a new dbLog table by dropping and recreating
     * id - auto increment
     * time - timestamp time()
     * message - text
     */

    

    /**
     * adds a new log entry, using the current time for the timestamp
     */
    function add_log_entry($message) {
        connect();

        $query = sprintf("INSERT INTO DBLOG (`time`, `message`) VALUES ('%s', '%s')",
            time(),
            str_replace("'", '"', $message) // Replace all single-quotes with double-quotes
        );

        $result = mysql_query($query);
        if (!$result) {
            echo mysql_error();
        }
        mysql_close();
    }

    /**
     * deletes a log entry
     */
    function delete_log_entry($id) {
        connect();
        $query = "DELETE FROM DBLOG WHERE ID=\"" . $id . "\"";
        $result = mysql_query($query);
        if (!$result) {
            error_log('sql error in delete_log_entry ' .mysql_error());
        }
        mysql_close();
    }

    /**
     * deletes log entries with ids specified in array $ids
     *
     * @param $ids an array of log ids
     */
    function delete_log_entries($ids) {
        connect();
        for ($i = 0; $i < count($ids); ++$i) {
            $query = "DELETE FROM DBLOG WHERE ID=\"" . $ids[$i] . "\"";
            $result = mysql_query($query);
            if (!$result) {
                error_log('sql error in delete_log_entries ' . mysql_error());
            }
        }
        mysql_close();
    }

    /**
     * returns all entries in the log, sorted by timestamp
     * @return returns array of id, time, and text
     */
    function get_full_log() {
        connect();
        $query = "SELECT * FROM DBLOG ORDER BY TIME";
        $result = mysql_query($query);
        mysql_close();
        if (!$result) {
            error_log('could not get the full log in dbLog.get_full_log');
            die("error getting log");
        }
        else {
            for ($i = 0; $i < mysql_num_rows($result); ++$i) {
                $result_row = mysql_fetch_row($result);
                if ($result_row) {
                    $log[] = [$result_row[0], date("n/j/y g:ia", $result_row[1]), $result_row[2]];
                }
            }
        }

        return $log;
    }

    /**
     * returns the last $num log entries
     * @return array of log entries
     */
    function get_last_log_entries($num) {
        $l = get_full_log();
        $c = count($l);
        if ($num > $c) {
            $num = $c;
        }
        for ($i = $c - $num; $i < $c; ++$i) {
            $log[] = $l[$i];
        }

        return $log;
    }

?>
