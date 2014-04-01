<?php
include_once(dirname(__FILE__) . '/../domain/BSCAHdate.php');
include_once(dirname(__FILE__) . '/../database/dbDates.php');
echo 'testing dbDates.php</br>';
error_log("in test db dates");

test_insert_dbDates();
test_update_dbDates();
test_replace_dbDates();
test_select_dbDates();
test_get_shifts_text();
// need more tests!

echo("test complete</br>");

// tests the insert_dbDates() function in dbDates.php
function test_insert_dbDates() {
    // note - I do not know what the date ids are going to look like. Change this when
    // you know how they will be formatted
   $newDate = new BSCAHdate("02-24-14", "test", "notes", "p1*p2");
   echo 'test</br>';
    echo 'will test insert_dbDates </br>';
    $result = insert_dbDates($newDate);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbDate succeeded </br>";
    else
        echo "insert_dbDate failed</br>";

    $res = delete_dbDates($newDate);
    if ($res == null)
        echo 'Delete failed</br>';
}
//Created by James Loeffler
function test_update_dbDates(){
    $newDate = new BSCAHdate("02-24-14", "test", "notes", "p1*p2");
    $nd = insert_dbDates($newDate);
    
    echo 'will test update_dbDates </br>';
    $result = update_dbDates($nd);
    echo 'result is ' . $result;
    if ($result)
        echo "update_dbDate succeeded </br>";
    else
        echo "update_dbDate failed</br>";

    $res = delete_dbDates($newDate);
    if ($res == null)
        echo 'Delete failed</br>';
}
//Created by James Loeffler
function test_replace_dbDates(){
    $newDate = new BSCAHdate("02-24-14", "test", "notes", "p1*p2");
    $nd = insert_dbDates($newDate);
    
    $old_s = "02-24-14";
    $new_s = "02-25-14";
    echo 'will test replace_dbDates </br>';
    $result = replace_dbDates($old_s, $new_s);
    
    if ($result != true)
        echo 'replace_dbDates failed</br>';
    else
        echo 'replace_dbDates succeeded</br>';
    
    $res = delete_dbDates($newDate);
    if ($res == null)
        echo 'Delete failed</br>';
}
//Created by James Loeffler
function test_select_dbDates(){
    $newDate = new BSCAHdate("02-24-14", "test", "notes", "p1*p2");
    $nd = insert_dbDates($newDate);
    $id = "02-24-14";
    echo 'will test select_dbDates</br>';
    $result = select_dbDates($id);
    
    if (result != null)
        echo'select_dbDates failed</br>';
    
    $res = delete_dbDates($newDate);
    if ($res == null)
        echo 'Delete failed</br>';
}

function test_get_shifts_text(){
    $newDate = new BSCAHdate("02-24-14", "test", "notes", "p1*p2");
    $nd = insert_dbDates($newDate);
    
    echo 'will test get_shifts_text</br>';
    $result = get_shifts_text($newDate);
    
    if (result != null)
        echo'select_dbDates failed</br>';
    else
        echo'select_dbDates succeeded</br>';
    
    $res = delete_dbDates($newDate);
    if ($res == null)
        echo 'Delete failed</br>';
}