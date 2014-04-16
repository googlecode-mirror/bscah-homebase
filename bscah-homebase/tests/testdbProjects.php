<?php
include_once(dirname(__FILE__) . '/../domain/project.php');
include_once(dirname(__FILE__) . '/../database/dbProjects.php');
echo 'testing dbProjectsphp</br>';
error_log("in test db projects");

define("PROJID","03-12-14-UnloadDelivery");
//test_create_dbProjects();
test_insert_dbProjects();
testSelectProject();
echo("test complete</br>");


function test_insert_dbProjects() {
   
   $newProject= new Project("03-12-14", "Address", "10-13", 10, 13, 15, "malcom1234567890+Malcom+Jones", "hiya");
    echo 'will test insert_dbProjects </br>';
    $result = insert_dbProjects ($newProject);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbProjects succeeded </br>";
    else
        echo "insert_dbProjects failed</br>";
    
     $res = delete_dbProjects($newProject);
    if ($res == null)
        echo 'delete failed</br>';
}

// tests the retrieve_person() function in dbPersons.php
function testSelectProject() {
   
    $newProject= new Project(PROJID, "03-12-14","Main Building", "UnloadDelivery",10, 13, 15, "", "notes");
    echo 'will test select_dbProject </br>';
    $result = insert_dbProjects ($newProject);
    echo 'result is ' . $result;
    if ($result)
        echo "add_person inserted </br>";
    else
        echo "add_person not inserted</br>";


    $p = select_dbProjects(PROJID);
    if ($p == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($p->get_id(), PROJID);
        checkEquals($p->get_name(),"UnloadDelivery");
    }

    $res = delete_dbProjects($newProject);
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the retrieve_persons_by_name() function in dbPersons.php
function testRetrieve_persons_by_name() {
   //  $m = new Person("John", "Smith", "Male", "555 Main Street", "Flushing", "NY", "11111", "Queens", PHONE, "2072654046", "john.smith@stjohns.edu", "volunteer", "applicant","Schedule", "I like helping out", "55555", "03-14-14");
    $newProject= new Project(PROJID, "03-12-14","Main Building", "UnloadDelivery",10, 13, 15, "", "notes");
    echo 'will test retrieve_persons_by_name </br>';
    $result = add_person($m);
    
    if ($result)
        echo "add_person - person was inserted </br>";
    else
        echo "add_person - person not inserted </br>";

    echo "test retrieve_persons_by_name</br>";
    $personList = retrieve_persons_by_name("John Smith");
    if ($personList == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($personList[0]->get_id(), ID);
        checkEquals($personList[0]->get_phone1(), PHONE);
        checkEquals($personList[0]->get_email(), "john.smith@stjohns.edu");
    }

    $res = remove_person(ID);
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
?>