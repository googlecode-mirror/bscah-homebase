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
     * add a person to person table: if already there, return false
     */

    function add_person(person $person) {
        connect();

        $result = mysql_query("SELECT * FROM PERSON WHERE ID = '" . $person->get_ID() . "'");
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
        $avail = implode(",",$person->get_availability());
        $schedule = implode(",", $person->get_schedule());
        $query = "INSERT INTO PERSON VALUES ('" .
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
            $schedule . "','" .
            $person->get_notes() . "','" .
            $person->get_skills() . "','" .
            $person->get_reason_interested() . "','" .
            $person->get_date_added() . "','" .
            $person->get_password() . "','" .
            $avail . "','" .
            $person->get_contact_preference() . "');";
        error_log('query is ' . $query);
        $result = mysql_query($query);

        if (!$result) {
            error_log("error doing insert in add_person " . mysql_error());
            echo mysql_error() . " - Unable to insert in PERSON: " . $person->get_ID() . "\n";
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
        $query = 'SELECT * FROM PERSON WHERE ID = "' . $id . '"';
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
        $query = 'DELETE FROM PERSON WHERE ID = "' . $id . '"';
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on delete in remove_person() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return true;
    }

    /*
     * @return a Person from PERSON table matching a particular id.
     * if not in table, return false
     */

    function retrieve_person($id) {
        connect();
        $query = "SELECT * FROM PERSON WHERE ID = '" . $id . "'";
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
        if (!isset($name) || $name == "" || $name == null) { die("<br>Please enter a first and last name<br>"); }
        connect();
        $name = explode(" ", $name);
        $first_name = $name[0];
        $last_name = $name[1];
        $query = "SELECT * FROM PERSON WHERE NAMEFIRST = '" . $first_name . "' AND NAMELAST = '" . $last_name . "'";
    
        if (!mysql_fetch_assoc(mysql_query($query)))
        {       
            if ($first_name == "" || $last_name == "") { die("<br>Please enter a first and last name<br>"); }
            
            else {
                    error_log("There is no such person by the name " . $first_name . " " . $last_name);
                    die("<br>There is no such person by the name " . $first_name . " " . $last_name . "<br>");        
                 }
        }
        
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
        $query = 'UPDATE PERSON SET PASSWORD = "' . $newPass . '" WHERE ID = "' . $id . '"';
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
        $query = "SELECT * FROM PERSON ORDER BY NAMELAST,NAMEFIRST";
        error_log('in dbpersons.getall_persons query is '.$query);
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
        $query = "SELECT NAMEFIRST, NAMELAST FROM PERSON ORDER BY NAMELAST,NAMEFIRST";
        error_log('in dbPersons getall_volunteer_names query is '.$query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('SQL query error in getall_volunteer_names()'. mysql_error());
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
            $names[] = $result_row['NAMEFIRST'] . ' ' . $result_row['NAMELAST'];
        }
        mysql_close();

        return $names;
    }

    function make_a_person($result_row) {
        $thePerson = new Person(
            $result_row['NAMEFIRST'],
            $result_row['NAMELAST'],
            $result_row['BIRTHDAY'],
            $result_row['GENDER'],
            $result_row['ADDRESS'],
            $result_row['CITY'],
            $result_row['STATE'],
            $result_row['ZIP'],
            // $result_row['County'],
            $result_row['PHONE1'],
            $result_row['PHONE2'],
            $result_row['EMAIL'],
            $result_row['TYPE'],
            $result_row['STATUS'],
            $result_row['SCHEDULE'],
            $result_row['NOTES'],
            $result_row['SKILLS'],
            $result_row['REASONINTERESTED'],
            $result_row['DATEADDED'],
            $result_row['PASSWORD'],
            $result_row['AVAILABILITY'],
            $result_row['CONTACTPREFERENCE']
        );

        return $thePerson;
    }

    // what??
    function getall_names($status, $type) {
        connect();
        $result = mysql_query("SELECT ID,NAMEFIRST,NAMELAST,TYPE FROM PERSON " .
                              "WHERE STATUS = '" . $status . "' AND TYPE LIKE '%" . $type .
                              "%' ORDER BY NAMELAST,NAMEFIRST");
        if (!$result) {
            error_log('sql error in getall_names ' . mysql_error());
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
        $query = "SELECT * FROM PERSON WHERE (TYPE LIKE '%" . $t .
            "%' OR TYPE LIKE '%sub%') AND STATUS = 'active'  ORDER BY NAMELAST,NAMEFIRST";
        error_log('in dbPersons.getall_type query is '.$query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('sql error in getall_type ' . mysql_error());
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
        $query = "SELECT * FROM PERSON WHERE (TYPE LIKE '%" . $type . "%' OR TYPE LIKE '%sub%')" .
            " AND AVAILABILITY LIKE '%" . $day . ":" . $shift .
            "%' AND STATUS = 'approved' ORDER BY NAMELAST,NAMEFIRST";
        error_log('in dbPersons.getall_available query is '.$query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('sql error in available ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return $result;
    }

    // get all volunteer applicants
    // returns the result array from the query
    //No more applicants
    function getall_applicants() {
        connect();
        $query = "SELECT NAMEFIRST,NAMELAST,ID FROM PERSON WHERE STATUS LIKE '%applicant%' order by NAMELAST";
        error_log("in dbpersons.getall_applicants, query is " . $query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('sql error in getall_applicants ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
        mysql_close();

        return $result;
    }

    // retrieve only those persons that match the criteria given in the arguments
    function getonlythose_persons($type, $status, $name, $day, $shift) {
        connect();
      
        $query = "SELECT * FROM PERSON WHERE TYPE LIKE '%" . $type . "%'" .
            " AND STATUS LIKE '%" . $status . "%'" .
            " AND (NAMEFIRST LIKE '%" . $name . "%' OR NAMELAST LIKE'%" . $name . "%')" . "AND AVAILABILITY LIKE '%" . $day .
               "%'" . "AND AVAILABILITY LIKE '%" . $shift . "%'" . "ORDER BY NAMELAST,NAMEFIRST";
        error_log("in dbPersons.getonlythose_persons, query is " . $query);
        $result = mysql_query($query);
        if (!$result) {
            error_log('sql error in getonlythose_persons ' . mysql_error());
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
        $query = "SELECT " . $attr . " FROM PERSON WHERE
    			NAMEFIRST REGEXP " . $first_name .
            " and NAMELAST REGEXP " . $last_name .
            " and (GENDER REGEXP " . $gender . ")" .
            " and (TYPE REGEXP " . $type_query . ")" .
            " and STATUS REGEXP " . $status .
            " and (START_DATE REGEXP " . $start_date . ")" .
            " and CITY REGEXP " . $city .
            " and ZIP REGEXP " . $zip .
            " and (PHONE1 REGEXP " . $phone . " or PHONE2 REGEXP " . $phone . " )" .
            " and (EMAIL REGEXP " . $email . ") ORDER BY NAMELAST, NAMEFIRST";
        error_log("Querying PERSON table for exporting");
        error_log("query = " . $query);
        $result = mysql_query($query);
        if (!$result) {
            error_log("sql error in getpeople_for_export, query is " . mysql_error());
            die('Invalid query: ' . mysql_error());
        }

        return $result;

    }
    
     


?>
