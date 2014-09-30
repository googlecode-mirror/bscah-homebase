<?php
    // test script for dbPersons.php

    include_once(dirname(__FILE__) . '/../domain/Person.php');
    define("PHONE", "2072445902");
    define("ID", "John2072445902");

    echo 'testing dbPersons.php</br>';
    testAddPerson();
    testRetrievePerson();
    testRetrieve_persons_by_name();
    testChange_password();
    //testGetall_dbPersons();
    //testGetall_volunteer_names();
    //testGetall_type();
    //testGetall_available();
    echo("testdbPersons complete</br>");

    // tests the add_person() function in dbPersons.php
    function testAddPerson() {
        $m = new Person("John", "Smith", "10-12-87", "Male", "555 Main Street", "Flushing", "NY", "11111", PHONE,
                        "2072654046", "john.smith@stjohns.edu", "volunteer", " ", "Schedule", "I like helping out",
                        "55555", "03-14-14", "email");
        echo 'will test add_person </br>';

        $result = add_person($m);
        echo 'result is ' . $result . '</br>';
        if ($result) {
            echo "person was added </br>";
        }
        else {
            echo "person already exists in db, not added</br>";
        }

        $res = remove_person(ID);
        if ($res == null) {
            echo 'Remove failed</br>';
        }
    }

    // tests the retrieve_person() function in dbPersons.php
    function testRetrievePerson() {
        $m = new Person("John", "Smith", "10-12-87", "Male", "555 Main Street", "Flushing", "NY", "11111", PHONE,
                        "2072654046", "john.smith@stjohns.edu", "volunteer", " ", "Schedule", "I like helping out",
                        "55555", "03-14-14", "email");

        echo 'will test retrieve_person </br>';
        $result = add_person($m);
        echo 'result is ' . $result;
        if ($result) {
            echo "add_person inserted </br>";
        }
        else {
            echo "add_person not inserted</br>";
        }


        $p = retrieve_person(ID);
        if ($p == null) {
            echo 'Retrieve failed</br>';
        }
        else {
            checkEquals($p->get_id(), ID);
            checkEquals($p->get_phone1(), PHONE);
            checkEquals($p->get_email(), "john.smith@stjohns.edu");
        }

        $res = remove_person(ID);
        if ($res == null) {
            echo 'Remove failed</br>';
        }
    }

    // tests the retrieve_persons_by_name() function in dbPersons.php
    function testRetrieve_persons_by_name() {
        $m = new Person("John", "Smith", "10-12-87", "Male", "555 Main Street", "Flushing", "NY", "11111", PHONE,
                        "2072654046", "john.smith@stjohns.edu", "volunteer", " ", "Schedule", "I like helping out",
                        "55555", "03-14-14", "email");

        echo 'will test retrieve_persons_by_name </br>';
        $result = add_person($m);

        if ($result) {
            echo "add_person - person was inserted </br>";
        }
        else {
            echo "add_person - person not inserted </br>";
        }

        echo "test retrieve_persons_by_name</br>";
        $personList = retrieve_persons_by_name("John Smith");
        if ($personList == null) {
            echo 'Retrieve failed</br>';
        }
        else {
            checkEquals($personList[0]->get_id(), ID);
            checkEquals($personList[0]->get_phone1(), PHONE);
            checkEquals($personList[0]->get_email(), "john.smith@stjohns.edu");
        }

        $res = remove_person(ID);
        if ($res == null) {
            echo 'Remove failed</br>';
        }
    }

    // tests the change_password() function in dbPersons.php
    function testChange_password() {
        $m = new Person("John", "Smith", "10-12-87", "Male", "555 Main Street", "Flushing", "NY", "11111", PHONE,
                        "2072654046", "john.smith@stjohns.edu", "volunteer", " ", "Schedule", "I like helping out",
                        "55555", "03-14-14", "email");

        echo 'will test change_password </br>';
        $result = add_person($m);
        echo 'result is ' . $result;
        if ($result) {
            echo "add_person person was inserted </br>";
        }
        else {
            echo "add_person - person was not inserted</br>";
        }

        $result = change_password('John2072445902', 'newpassword');
        if ($result) {
            echo "change_password succeeded </br>";
        }
        else {
            echo "change_password failed</br>";
        }

        $p = retrieve_person(ID);
        if ($p == null) {
            echo 'Retrieve failed</br>';
        }
        else {
            checkEquals($p->get_password(), "newpassword");
        }

        $res = remove_person(ID);
        if ($res == null) {
            echo 'Retrieve failed</br>';
        }
    }

    // test if the actual result equals the expected result
    function checkEquals($result, $expected) {
        if ($result == $expected) {
            echo 'result ' . $result . ' is the same as expected value ' . $expected . '</br>';

            return true;
        }
        else {
            echo 'result ' . $result . ' does not equal the  expected value ' . $expected . '</br>';

            return false;
        }
    }
