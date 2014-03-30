<?php

include_once(dirname(__FILE__) . '/../domain/MasterScheduleEntry.php');
include_once(dirname(__FILE__) . '/../database/dbMasterSchedule.php');
echo 'testing dbMasterScheduleEntry.php</br>';
error_log("in test db master schedule");
test_insert_dbMasterSchedule();
test_retrieve_dbMasterSchedule();
test_update_dbMasterSchedule();


echo("test complete</br>");

// tests the add_person() function in dbPersons.php
function test_insert_dbMasterSchedule() {
    $new_MasterScheduleEntry = new MasterScheduleEntry("monthly","Wed", "1st", 14, 17, 2,
		"joe2071234567,sue2079876543", "This is a super fun shift.","id1"); // not sure what the id looks like
   
    echo 'will test insert_dbMasterSchedule </br>';
    $result = insert_dbMasterSchedule($new_MasterScheduleEntry);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbMasterSchedule succeeded </br>";
    else
        echo "insert_dbMasterSchedule failed</br>";

    $res = delete_dbMasterSchedule("id1");
    if ($res == null)
        echo 'Delete failed</br>';
}

// tests the retrieve_person() function in dbPersons.php
function test_retrieve_dbMasterSchedule() {
  //  $m = new person("Gabrielle", "Booth", "female", "14 Way St", "Harpswell", "ME", "04079", "", 1112345678, 2071112345, "ted@bowdoin.edu", "email", "Mother", 2077758989, "manager", "", "", "active", "programmer", "Steve_2077291234", "yes", "", "", "Mon:morning,Tue:morning", "", "", "02-19-89", "03-14-08", "", "");
  $new_MasterScheduleEntry = new MasterScheduleEntry("monthly","Wed", "1st", 14, 17, 2,
		"joe2071234567,sue2079876543", "This is a super fun shift.","id1"); // not sure what the id looks like
  
    echo 'will test rretrieve_dbMasterSchedule </br>';
    
     $result = insert_dbMasterSchedule($new_MasterScheduleEntry);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbMasterSchedule succeeded </br>";
    else
        echo "insert_dbMasterSchedule failed</br>";

    $mse = retrieve_dbMasterSchedule("id1");
    if ($mse == null)
        echo 'Retrieve failed</br>';
    else {
        checkEquals($mse->get_notes(), "This is a super fun shift.");
        checkEquals($mse->get_persons(), "joe2071234567,sue2079876543");
        checkEquals($mse->get_start_time(), 14);
    }

    $res =  delete_dbMasterSchedule("id1");
    if ($res == null)
        echo 'delete failed</br>';
}

// tests the retrieve_persons_by_name() function in dbPersons.php
function test_update_dbMasterSchedule() {
    $new_MasterScheduleEntry = new MasterScheduleEntry("monthly","Wed", "1st", 14, 17, 2,
		"joe2071234567,sue2079876543", "This is a super fun shift.","id1"); // not sure what the id looks like
  
    echo 'will test update_dbMasterSchedule </br>';
   $new_MasterScheduleEntry = new MasterScheduleEntry("monthly","Wed", "1st", 14, 17, 2,
		"joe2071234567,sue2079876543", "This is a super fun shift.","id1"); // not sure what the id looks like
  
    echo 'will test update_dbMasterSchedule </br>';
    
     $result = insert_dbMasterSchedule($new_MasterScheduleEntry);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbMasterSchedule succeeded </br>";
    else
        echo "insert_dbMasterSchedule failed</br>";
    
    // removed one person
    $updated_MasterScheduleEntry = new MasterScheduleEntry("monthly","Wed", "1st", 14, 17, 2,
		"sue2079876543", "This is a super fun shift.","id1"); // not sure what the id looks lik
    $mse = update_dbMasterSchedule($updated_MasterScheduleEntry);
    if ($mse == false)
        echo 'update failed</br>';
    else
    {
        checkEquals($mse->get_notes(), "This is a super fun shift.");
        checkEquals($mse->get_persons(), "sue2079876543");
        checkEquals($mse->get_start_time(), 14);
    }

     $res =  delete_dbMasterSchedule("id1");
    if ($res == null)
        echo 'delete failed</br>';
}
