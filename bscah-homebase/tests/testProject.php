<?php

/*
 * Created on Mar 17, 2014
 * Updated 3/26
 * @author Derek and Ka Ming
 */
include_once(dirname(__FILE__).'/../domain/Project.php');
class testProject extends UnitTestCase {
      function testProjectModule() {
         $m = new Project("03-28-08-12-15", "Rec", 3, array(), array(), "", "");
 

    echo 'will test ProjectModule </br>';
    $result = ProjectModule($m);
    echo 'result is ' . $result;
    if ($result)
        echo "ProjectModule succeeded </br>";
    else
        echo "ProjectModule failed</br>";
    }
         
// Test new function for resetting project's start/end time
       function resetTime() {
         $m = RrsetTime("11" , "13", array(), array(), "", "");
 

    echo 'will reset Projects start/end time</br>';
    $result = resetTime($m);
    echo 'result is ' . $result;
    if ($result)
        echo "Resetting project start/end time succeeded </br>";
    else
        echo "Resetting project start/end time failed</br>";
    }
       		 
// Test new function to catch invalid times
       function invalidTime() {
         $m = invalidTime("25" , "35", array(), array(), "", "");
 

    echo 'will catch an Invalid Time and give an error message</br>';
    $result = invalidTime($m);
    echo 'result is ' . $result;
    if ($result)
        echo "Invalid time was caught </br>";
    else
        echo "Invalid time was not caught </br>";
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
}

?>


