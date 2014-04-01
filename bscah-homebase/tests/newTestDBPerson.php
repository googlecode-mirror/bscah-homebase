

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
    $m = new Person("John", "Smith", "Male", "555 Main Street", "Flushing", "NY", "11111", "Queens", "20724415902", "2072654046", "john.smith@stjohns.edu", "volunteer", "Schedule", "I like helping out", "55555", "03-14-14");
    echo 'will test add_person </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";

    $res = remove_person("John20724415902");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the retrieve_person() function in dbPersons.php
function testRetrievePerson() {
    $m = new Person("John", "Smith", "Male", "555 Main Street", "Flushing", "NY", "11111", "Queens", "20724415902", "2072654046", "john.smith@stjohns.edu", "volunteer", "Schedule", "I like helping out", "55555", "03-14-14");
    
    echo 'will test retrieve_person </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";


    $p = retrieve_person("John20724415902");
    if ($p == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($p->get_id(), "John20724415902");
        checkEquals($p->get_phone1(), "20724415902");
        checkEquals($p->get_email(), "john.smith@stjohns.edu");
    }

    $res = remove_person("John20724415902");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the retrieve_persons_by_name() function in dbPersons.php
function testRetrieve_persons_by_name() {
     $m = new Person("John", "Smith", "Male", "555 Main Street", "Flushing", "NY", "11111", "Queens", "20724415902", "2072654046", "john.smith@stjohns.edu", "volunteer", "Schedule", "I like helping out", "55555", "03-14-14");
    
    echo 'will test retrieve_persons_by_name </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";

    echo "test retrieve_persons_by_name</br>";
    $personList = retrieve_persons_by_name("John Smith");
    if ($personList == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($personList[0]->get_id(), "John20724415902");
        checkEquals($personList[0]->get_phone1(), "20724415902");
        checkEquals($personList[0]->get_email(), "john.smith@stjohns.edu");
    }

    $res = remove_person("John20724415902");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the change_password() function in dbPersons.php
function testChange_password() {
    $m = new Person("John", "Smith", "Male", "555 Main Street", "Flushing", "NY", "11111", "Queens", "20724415902", "2072654046", "john.smith@stjohns.edu", "volunteer", "Schedule", "I like helping out", "55555", "03-14-14");
    
    echo 'will test change_password </br>';
    $result = add_person($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person succeeded </br>";
    else
        echo "add_person failed</br>";

    $result = change_password('John20724415902', 'newpassword.');
    if ($result)
        echo "change_password succeeded </br>";
    else
        echo "change_password failed</br>";

    $p = retrieve_person("John20724415902");
    if ($p == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($p->get_password(), "newpassword");
    }

    $res = remove_person("John20724415902");
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
