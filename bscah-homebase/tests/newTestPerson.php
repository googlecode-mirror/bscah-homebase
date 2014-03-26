<?php
/*
 * This class will test the person class.
 * It is similar in design the existing testPerson class but, will not require the use of 'UnitTestCase' 
 * The design is also derived from newTestDBPerson
 */

include_once(dirname(__FILE__) . '/../domain/Person.php');
echo 'testing Persons.php</br>';
// person construct is copied from testPerson.php 
$m = new Person("Taylor","Talmage","male","928 SU","Brunswick","ME",04011, "",
      2074415902,2072654046,"ttalmage@bowdoin.edu", "email", "Mother", 2077758989, "volunteer",
      "","","active", "programmer", "Steve_2071234567,John_1234567890","yes","I like helping out","cooking",
      "Mon:morning,Tue:morning,Wed:earlypm", "", "", "02-19-89", "03-14-08",
      "this is a note","Taylor2074415902");


echo testFirstName();
echo testLastName();

//return a message if the test past or fails 
function testFirstName()
{
    if($m->get_firstname==="Taylor")
    {   
    return 'First name test succeeded';  
    } 
    else
    {
    return 'First name test failed';
    }
}

function testLastName()
{
   if($m->get_lasttname==="Talmage")
       {   
    echo 'Last name test succeeded';  
    } 
    else
    {
    echo 'Last name test failed';
    }
}







