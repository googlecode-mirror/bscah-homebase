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
     * @version March 1, 2012
     * @author Oliver Radwan and Allen Tucker
     */
    include_once('dbinfo.php');
    include_once(dirname(__FILE__) . '/../domain/Person.php');
    /*
    function create_persons()
    {
        connect();
        mysql_query("DROP TABLE IF EXISTS person");
        $result = mysql_query("CREATE TABLE person(ID varchar(25) NOT NULL, NameFirst varchar(20) NOT NULL, NameLast varchar(25) NOT NULL, "
                . "Gender varchar(1) NOT NULL, Address varchar(40) NOT NULL, city TEXT, state VARCHAR(2), zip TEXT, "
                . "county TEXT, phone1 VARCHAR(12) NOT NULL, phone2 VARCHAR(12), email TEXT, "
                . "type TEXT, schedule TEXT, notes TEXT, password TEXT, availability TEXT)");

        if (!$result)
            echo mysql_error() . "Error creating person table<br>";
    }
    /
    /*
     * add a person to person table: if already there, return false
     */

    function add_person($person) {
        if (!$person instanceof person) {
            return false;
            die("Error: add_person type mismatch");
        }
        connect();

        $result = mysql_query("SELECT * FROM person WHERE id = '" . $person->get_ID() . "'");
        if (!$result) {
            error_log('ERROR on select in add_person() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }

        // the function get_MS_ID does not exist in the original Homebase code
        // this code causes and error and should be deleted
        // not clear what the logic was
        /*   if (mysql_num_rows($result) != 0)
           {
               delete_dbMasterSchedule($person->get_MS_ID());
               connect();
           } */

        error_log('will insert person id= ' . $person->get_id() . ' avail= ' . $person->get_availability());
        $query = "INSERT INTO person VALUES ('" .
            $person->get_id() . "','" .
            $person->get_first_name() . "','" .
            $person->get_last_name() . "','" .
            $person->get_birthday() . "','" .
            $person->get_gender() . "','" .
            $person->get_address() . "','" .
            $person->get_city() . "','" .
            $person->get_state() . "','" .
            $person->get_zip() . "','" .
            $person->get_phone1() . "','" .
            $person->get_phone2() . "','" .
            $person->get_email() . "','" .
            $person->get_type() . "','" .
            $person->get_status() . "','" .
            $person->get_schedule() . "','" .
            $person->get_notes() . "','" .
            $person->get_password() . "','" .
            $person->get_availability() . "','" .
            $person->get_contact_preference() . "');";
        error_log('query is ' . $query);
        $result = mysql_query($query);

        if (!$result) {
            error_log("error doing insert in add_person " . mysql_error());
            echo mysql_error() . " - Unable to insert in person: " . $person->get_ID() . "\n";
            mysql_close();

            return false;
        }
        mysql_close();

        return true;
    }

    /*
     * remove a person from person table.  If already there, return false
     */

    function remove_person($id) {
        error_log('in remove_person, id is ' . $id);
        connect();
        $query = 'SELECT * FROM person WHERE id = "' . $id . '"';
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in remove_person() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if ($result == null || mysql_num_rows($result) == 0) {
            error_log('in remove_person, the record was not found ');
            mysql_close();

            return false;
        }
        $query = 'DELETE FROM person WHERE id = "' . $id . '"';
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on delete in remove_person() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return true;
    }

    /*
     * @return a Person from person table matching a particular id.
     * if not in table, return false
     */

    function retrieve_person($id) {
        error_log('in retrieve_person id is ' . $id);
        connect();
        $query = "SELECT * FROM person WHERE id = '" . $id . "'";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in retrieve_person ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        if (mysql_num_rows($result) !== 1) {
            mysql_close();

            return false;
        }
        $result_row = mysql_fetch_assoc($result);
        // var_dump($result_row);
        $thePerson = make_a_person($result_row);
//    mysql_close();
        error_log('in retrieve_person id is ' . $thePerson->get_id());
        error_log('in retrieve_person password is ' . $thePerson->get_password());
        error_log('in retrieve_person type is ' . $thePerson->get_type());

        return $thePerson;
    }

    // Name is first concat with last name. Example 'James Jones'
    // return array of Persons.
    function retrieve_persons_by_name($name) {
        $persons = [];
        if (!isset($name) || $name == "" || $name == null) {
            return $persons;
        }
        connect();
        $name = explode(" ", $name);
        $first_name = $name[0];
        $last_name = $name[1];
        $query = "SELECT * FROM person WHERE NameFirst = '" . $first_name . "' AND NameLast = '" . $last_name . "'";
        error_log("in retrieve_persons_by_name, query is " . $query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in retrieve_persons_by_name ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        while ($result_row = mysql_fetch_assoc($result)) {
            $the_person = make_a_person($result_row);
            error_log('in retrieve_person_by_name id is ' . $the_person->get_id());
            error_log('in retrieve_person_by_name phone1 is ' . $the_person->get_phone1());
            error_log('in retrieve_person_by_name type is ' . $the_person->get_type());
            $persons[] = $the_person;
        }

        return $persons;
    }

    function change_password($id, $newPass) {
        connect();
        $query = 'UPDATE person SET Password = "' . $newPass . '" WHERE id = "' . $id . '"';
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return $result;
    }

    /*
    function set_county($id, $county) {
        connect();
        $query = 'UPDATE person SET county = "' . $county . '" WHERE id = "' . $id . '"';
        $result = mysql_query($query);
          if (!$result)
            die('Invalid query: ' . mysql_error());
        mysql_close();
        return $result;
    }
     *
     */

    /*
     * @return all rows from person table ordered by last name
     * if none there, return false
     */

    function getall_persons() {
        connect();
        $query = "SELECT * FROM person ORDER BY NameLast,NameFirst";
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        if ($result == null || mysql_num_rows($result) == 0) {
            mysql_close();

            return false;
        }
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        $thePersons = [];
        while ($result_row = mysql_fetch_assoc($result)) {
            $thePerson = make_a_person($result_row);
            $thePersons[] = $thePerson;
        }

        return $thePersons;
    }

    function getall_volunteer_names() {
        connect();
        $query = "SELECT NameFirst, NameLast FROM person ORDER BY NameLast,NameFirst";
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        if ($result == null || mysql_num_rows($result) == 0) {
            mysql_close();

            return false;
        }
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        $names = [];
        while ($result_row = mysql_fetch_assoc($result)) {
            $names[] = $result_row['NameFirst'] . ' ' . $result_row['NameLast'];
        }
        mysql_close();

        return $names;
    }

    function make_a_person($result_row) {
        $thePerson = new Person(
            $result_row['NameFirst'],
            $result_row['NameLast'],
            $result_row['Birthday'],
            $result_row['Gender'],
            $result_row['Address'],
            $result_row['City'],
            $result_row['State'],
            $result_row['Zip'],
            // $result_row['County'],
            $result_row['Phone1'],
            $result_row['Phone2'],
            $result_row['Email'],
            $result_row['Type'],
            $result_row['Status'],
            $result_row['Schedule'],
            $result_row['Notes'],
            $result_row['Password'],
            $result_row['Availability'],
            $result_row['ContactPreference']
        );

        return $thePerson;
    }

    // what??
    function getall_names($status, $type) {
        connect();
        $result = mysql_query("SELECT id,NameFirst,NameLast,type FROM person " .
                              "WHERE status = '" . $status . "' AND TYPE LIKE '%" . $type .
                              "%' ORDER BY NameLast,NameFirst");
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return $result;
    }

    /*
     * @return all active people of type $t or subs from person table ordered by last name
     */

    function getall_type($t) {
        connect();
        $query = "SELECT * FROM person WHERE (type LIKE '%" . $t .
            "%' OR type LIKE '%sub%') AND status = 'active'  ORDER BY NameLast,NameFirst";
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        if ($result == null || mysql_num_rows($result) == 0) {
            mysql_close();

            return false;
        }
        mysql_close;

        return $result;
    }

    /*
     *   get all active volunteers and subs of $type who are available for the given $frequency,$week,$day,and $shift
     */

    function getall_available($type, $day, $shift) {
        connect();
        $query = "SELECT * FROM person WHERE (type LIKE '%" . $type . "%' OR type LIKE '%sub%')" .
            " AND availability LIKE '%" . $day . ":" . $shift .
            "%' AND status = 'active' ORDER BY NameLast,NameFirst";
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return $result;
    }

    // get all volunteer applicants
    // returns the result array from the query
    function getall_applicants() {
        connect();
        $query = "SELECT NameFirst,NameLast,id FROM person WHERE status LIKE '%applicant%' order by NameLast";
        error_log("in getall_applicants, query is " . $query);
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return $result;
    }

    // retrieve only those persons that match the criteria given in the arguments
    function getonlythose_persons($type, $status, $name, $day, $shift) {
        connect();
        if ($type == "manager") {
            $string1 = " = '";
            $string2 = "'";
        }
        else {
            $string1 = " LIKE '%";
            $string2 = "%'";
        }
        $query = "SELECT * FROM person WHERE type " . $string1 . $type . $string2 .
            " AND status LIKE '%" . $status . "%'" .
            " AND (NameFirst LIKE '%" . $name . "%' OR NameLast LIKE'%" . $name . "%')" .
            " ORDER BY NameLast,NameFirst";
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }
        $thePersons = [];
        while ($result_row = mysql_fetch_assoc($result)) {
            $thePerson = make_a_person($result_row);
            $thePersons[] = $thePerson;
        }

//    mysql_close();
        return $thePersons;
    }

    function phone_edit($phone) {
        if ($phone != "") {
            return substr($phone, 0, 3) . "-" . substr($phone, 3, 3) . "-" . substr($phone, 6);
        }
        else {
            return "";
        }
    }

    function get_people_for_export($attr, $first_name, $last_name, $gender, $type, $status, $start_date, $city, $zip,
        $phone, $email) {
        $first_name = "'" . $first_name . "'";
        $last_name = "'" . $last_name . "'";
        $gender = "'" . $gender . "'";
        $status = "'" . $status . "'";
        $start_date = "'" . $start_date . "'";
        $city = "'" . $city . "'";
        $zip = "'" . $zip . "'";
        $phone = "'" . $phone . "'";
        $email = "'" . $email . "'";
        $select_all_query = "'.'";
        if ($gender == $select_all_query) {
            $gender = $gender . " or gender=''";
        }
        if ($start_date == $select_all_query) {
            $start_date = $start_date . " or start_date=''";
        }
        if ($email == $select_all_query) {
            $email = $email . " or email=''";
        }

        $type_query = "";
        if (!isset($type) || count($type) == 0) {
            $type_query = "'.'";
        }
        else {
            $type_query = implode("|", $type);
            $type_query = "'.*($type_query).*'";
        }

        error_log("query for start date is " . $start_date);
        error_log("query for gender is " . $gender);
        error_log("query for type is " . $type_query);

        connect();
        $query = "SELECT " . $attr . " FROM person WHERE
    			NameFirst REGEXP " . $first_name .
            " and NameLast REGEXP " . $last_name .
            " and (gender REGEXP " . $gender . ")" .
            " and (type REGEXP " . $type_query . ")" .
            " and status REGEXP " . $status .
            " and (start_date REGEXP " . $start_date . ")" .
            " and city REGEXP " . $city .
            " and zip REGEXP " . $zip .
            " and (phone1 REGEXP " . $phone . " or phone2 REGEXP " . $phone . " )" .
            " and (email REGEXP " . $email . ") ORDER BY NameLast, NameFirst";
        error_log("Querying database for exporting");
        error_log("query = " . $query);
        $result = mysql_query($query);
        if (!$result) {
            die('Invalid query: ' . mysql_error());
        }

        return $result;

    }


?>
