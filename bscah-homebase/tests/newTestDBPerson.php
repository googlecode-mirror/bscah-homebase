

<?php
// test script for dbPersons.php

include_once(dirname(__FILE__) . '/../domain/Person.php');
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
    $m = new Person("Gabrielle", "Booth", "female", "14 Way St", "Harpswell", "ME", "04079", "", 1112345678, 2071112345, "ted@bowdoin.edu", "email", "Mother", 2077758989, "manager", "", "", "active", "programmer", "Steve_2077291234", "yes", "", "", "Mon:morning,Tue:morning", "", "", "02-19-89", "03-14-08", "", "");

    echo 'will test add_person </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";

    $res = remove_person("Gabrielle1112345678");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the retrieve_person() function in dbPersons.php
function testRetrievePerson() {
    $m = new Person("Gabrielle", "Booth", "female", "14 Way St", "Harpswell", "ME", "04079", "", 1112345678, 2071112345, "ted@bowdoin.edu", "email", "Mother", 2077758989, "manager", "", "", "active", "programmer", "Steve_2077291234", "yes", "", "", "Mon:morning,Tue:morning", "", "", "02-19-89", "03-14-08", "", "");

    echo 'will test retrieve_person </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";


    $p = retrieve_person("Gabrielle1112345678");
    if ($p == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($p->get_status(), "active");
        checkEquals($p->get_occupation(), "programmer");
        checkEquals($p->get_refs(), array("Steve_2077291234"));
    }

    $res = remove_person("Gabrielle1112345678");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the retrieve_persons_by_name() function in dbPersons.php
function testRetrieve_persons_by_name() {
    $m = new Person("Gabrielle", "Booth", "female", "14 Way St", "Harpswell", "ME", "04079", "", 1112345678, 2071112345, "ted@bowdoin.edu", "email", "Mother", 2077758989, "manager", "", "", "active", "programmer", "Steve_2077291234", "yes", "", "", "Mon:morning,Tue:morning", "", "", "02-19-89", "03-14-08", "", "");

    echo 'will test retrieve_persons_by_name </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";

    echo "test retrieve_persons_by_name</br>";
    $personList = retrieve_persons_by_name("Gabrielle Booth");
    if ($personList == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($personList[0]->get_status(), "active");
        checkEquals($personList[0]->get_occupation(), "programmer");
        checkEquals($personList[0]->get_refs(), array("Steve_2077291234"));
    }

    $res = remove_person("Gabrielle1112345678");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the change_password() function in dbPersons.php
function testChange_password() {
    $m = new Person("Gabrielle", "Booth", "female", "14 Way St", "Harpswell", "ME", "04079", "", 1112345678, 2071112345, "ted@bowdoin.edu", "email", "Mother", 2077758989, "manager", "", "", "active", "programmer", "Steve_2077291234", "yes", "", "", "Mon:morning,Tue:morning", "", "", "02-19-89", "03-14-08", "", "");

    echo 'will test change_password </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";

    $result = change_password('Gabrielle1112345678', 'newpass.');
    if ($result)
        echo "change_password succeeded </br>";
    else
        echo "change_password failed</br>";

    $p = retrieve_person("Gabrielle1112345678");
    if ($p == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($p->get_password(), "newpass");
    }

    $res = remove_person("Gabrielle1112345678");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// test if the actual result equals the expected result
function checkEquals($result, $expected) {
    if ($result == $expected) {
        echo 'result ' . $result . ' is the same as expected value ' . $expected . '</br>';
        return true;
    } else {
        echo 'result ' . $result . ' does not equal the  expected value ' . $expected . '</br>';
        return false;
    }
}
