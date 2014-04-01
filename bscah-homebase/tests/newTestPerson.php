<?php
/*
 * This class will test the person class.
 * It is similar in design the existing testPerson class but, will not require the use of 'UnitTestCase' 
 * The design is also derived from newTestDBPerson
 */

include_once(dirname(__FILE__) . '/../domain/Person.php');
echo "testing Persons.php".'</br>';
// person construct is copied from testPerson.php 

echo testFirstName().'</br>';
echo testLastName().'</br>';



//return a message if the first test past or fails 
function testFirstName()
{ 
    $test_person = new Person("John", "Smith", "Male", "555 Main Street", "Flushing", "NY", 11111, "Queens", 20724415902, 2072654046, "john.smith@stjohns.edu", "volunteer", "Schedule",  "I like helping out", "55555", "03-14-14");
    echo "Testing first name".'</br>';
    if($test_person->get_firstname==="John")   
     return 'First name test succeeded';  
    else
     return 'First name test failed';
}

//return a message if the last test past or fails 
function testLastName()
{
   if($m->get_lasttname==="Smith")
       {   
    echo 'Last name test succeeded';  
    } 
    else
    {
    echo 'Last name test failed';
    }
}







