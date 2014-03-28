<?php
include_once(dirname(__FILE__) . '/../domain/BSCAHdate.php');
include_once(dirname(__FILE__) . '/../database/dbDates.php');
echo 'testing dbDates.php</br>';
error_log("in test db dates");
test_insert_dbDates();
// need more tests!


echo("test complete</br>");

// tests the add_person() function in dbPersons.php
function test_insert_dbDates() {
   
    // note - I do not know what the project ids are going to look like. Change this when
    // you know how they will be formatted
   $newDate = new BSCAHdate("02-24-14", array(), "notes", "p1*p2");
    echo 'will test insert_dbDates </br>';
    $result = insert_dbDates($newDate);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbDate succeeded </br>";
    else
        echo "insert_dbDate failed</br>";

    $res = delete_dbDates("id1");
    if ($res == null)
        echo 'Delete failed</br>';
}



