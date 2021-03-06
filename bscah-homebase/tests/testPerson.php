<?php
    /*
    * This class will test the person class.
    * It is similar in design the existing testPerson class but, will not require the use of 'UnitTestCase'
    * The design is also derived from newTestDBPerson
    */
    include_once(dirname(__FILE__) . '/../domain/Person.php');
    echo "testing Persons.php" . '</br>';
// person construct is copied from testPerson.php
    testConstructor();

//return a message if the first test past or fails 
    function testConstructor() {
        $test_person =
            new Person("John", "Smith", "10-12-87", "Male", "555 Main Street", "Flushing", "NY", "11111", "20724415902",
                       "2072654046", "john.smith@stjohns.edu", "volunteer", " ", "Schedule", "I like helping out",
                       "55555", "03-14-14", "email");
        echo "Testing first name" . '</br>';
        if ($test_person->get_first_name() == "John") {
            echo 'First name test succeeded </br>';
        }
        else {
            echo 'First name test failed </br>';
        }

        if ($test_person->get_last_name() == "Smith") {
            echo 'last name test succeeded </br>';
        }
        else {
            echo 'last name test failed </br>';
        }


        if ($test_person->get_gender() == "Male") {
            echo 'gender test succeeded </br>';
        }
        else {
            echo 'gender test failed </br>';
        }

        if ($test_person->get_address() == "555 Main Street") {
            echo 'address test succeeded </br>';
        }
        else {
            echo 'address test failed </br>';
        }

        if ($test_person->get_city() == "Flushing") {
            echo 'city test succeeded </br>';
        }
        else {
            echo 'city test failed </br>';
        }

        if ($test_person->get_state() == "NY") {
            echo 'state test succeeded </br>';
        }
        else {
            echo 'state test failed </br>';
        }

        if ($test_person->get_zip() == "11111") {
            echo 'zip test succeeded </br>';
        }
        else {
            echo 'zip test failed </br>';
        }

        if ($test_person->get_phone1() == "20724415902") {
            echo 'phone1 test succeeded </br>';
        }
        else {
            echo 'phone1 test failed </br>';
        }

        if ($test_person->get_phone2() == "2072654046") {
            echo 'phone2 test succeeded </br>';
        }
        else {
            echo 'phone2 test failed </br>';
        }

        if ($test_person->get_email() == "john.smith@stjohns.edu") {
            echo 'email test succeeded </br>';
        }
        else {
            echo 'email test failed </br>';
        }

        if ($test_person->get_type() == "volunteer") {
            echo 'type test succeedeed  </br>';
        }
        else {
            echo 'type test failed  </br>';
        }

        if ($test_person->get_schedule() == "Schedule") {
            echo 'schedule test succeeded  </br>';
        }
        else {
            echo 'schedule test failed  </br>';
        }
        error_log($test_person->get_schedule());

        if ($test_person->get_notes() == "I like helping out") {
            echo 'notes test succeeded </br>';
        }
        else {
            echo 'notes test failed </br>';
        }
        if ($test_person->get_password() == "55555") {
            echo 'password test succeeded </br>';
        }
        else {
            echo 'password test failed </br>';
        }
        if ($test_person->get_availabiltiy() == "03-14-14") {
            echo 'availability test succeeded </br>';
        }
        else {
            echo ' availability test failed </br>';
        }
        if ($test_person->get_id() == "John20724415902") {
            echo 'id test succeeded </br>';
        }
        else {
            echo ' id test failed </br>';
        }
        if ($test_person->get_contact_preference() == "email") {
            echo 'contact preference test succeeded </br>';
        }
        else {
            echo ' contact preference test failed </br>';
        }

    }