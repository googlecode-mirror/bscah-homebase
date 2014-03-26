<?php
/*
 * Created on Mar 18, 2014
 * Updated 3/26
 * @author Derek and Ka Ming
 */
include_once(dirname(__FILE__) . '/../domain/Project.php');
echo 'testing dbProjects.php</br>';
testAddProject();
testRetrieveProject();

//testGetall_dbProjects();

echo("testdbProjects complete</br>");

// tests the add_project() function in dbProjects.php
function testAddProject() {
    $m = new Project("Project 1" , "01-12-13", "13", "18");

    echo 'will test add_project </br>';
    $result = add_project($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_project succeeded </br>";
    else
        echo "add_project failed</br>";

    $res = remove_project("Project1");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the retrieve_project() function in dbProjects.php
function testRetrieveProject() {
    $m = new Project("Project 1", "01-12-13", "13", "18");

    echo 'will test retrieve_project </br>';
    $result = add_project($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_project succeeded </br>";
    else
        echo "add_project failed</br>";


    $p = retrieve_project("Project1");
    if ($p == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($p->get_status(), "active");
       
  
    }

    $res = remove_project("Project1");
    if ($res == null)
        echo 'Retrieve failed</br>';
}

// tests the retrieve_projects_by_name() function in dbProjects.php
function testRetrieve_projects_by_name() {
    $m = new Project("Project1" , "01-12-13", "13", "18");

    echo 'will test retrieve_projects_by_name </br>';
    $result = add_project($m);
    echo 'result is ' . $result;
    if ($result)
        echo "add_project succeeded </br>";
    else
        echo "add_project failed</br>";

    echo "test retrieve_projects_by_name</br>";
    $projectList = retrieve_projects_by_name("Project1");
    if ($projectList == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($projectList[0]->get_status(), "active");
     
    }

    $res = remove_project("Project1");
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
