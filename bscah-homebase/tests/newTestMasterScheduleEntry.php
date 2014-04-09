<?php
/*
* This class will test the MasterScheduleEntry class.
*/
include_once(dirname(__FILE__) . '/../domain/MasterScheduleEntry.php');
echo "testing MasterScheduleEntry.php".'</br>';
// person construct is copied from testPerson.php
testConstructor();
 
//return a message if the first test past or fails 
function testConstructor()
{ 
$test_MasterScheduleEntry = new MasterScheduleEntry("weekly", "Mon", 14, 17, 2 , "joe2071234567,sue2079876543", "I like pie.", "Night Shift");

echo "Testing first name".'</br>';
if($test_MasterScheduleEntry->get_MS_ID()=="weeklyMon14-17") 
    echo 'MS_ID test succeeded </br>'; 
else
    echo 'MS_ID test failed </br>';

if($test_MasterScheduleEntry->get_Schedule_type()=="weekly") 
    echo 'Schedule_type test succeeded </br>'; 
else
    echo 'Schedule_type test failed </br>';

if($test_MasterScheduleEntry->get_day() == "Mon")
    echo 'day test succeeded </br>';
else
    echo 'day test failed </br>';


if ($test_MasterScheduleEntry->get_start_time()==14)
    echo 'start time test succeeded </br>';
else
    echo 'start time test failed </br>';

if ($test_MasterScheduleEntry->get_end_time()==17)
    echo 'end time test succeeded </br>';
else
    echo 'end time test failed </br>';

if($test_MasterScheduleEntry->get_slots() == 2)
    echo 'slot test succeeded </br>';
else
    echo 'slot test failed </br>';

if($test_MasterScheduleEntry->get_persons() == "joe2071234567,sue2079876543")
    echo 'persons test succeeded </br>';
else 
    echo 'persons test failed </br>';

if($test_MasterScheduleEntry->get_notes() == "I like pie.")
    echo 'note test succeeded </br>';
else 
    echo 'note test failed </br>';

if($test_MasterScheduleEntry->get_Shifts() == "Night Shift")
    echo 'Shifts test succeeded </br>';
else 
    echo 'Shifts test failed </br>';
}

 






