<?php

include_once(dirname(__FILE__) . '/../database/dbWeeks.php');
include_once(dirname(__FILE__) . '/../domain/Week.php');

echo 'testing dbWeeks.php</br>';
error_log("in test db Weeks");

testcreate_dbWeeks();
testinsert_dbWeeks();
testdelete_dbWeeks();
testupdate_dbWeeks();
testselect_dbWeeks();
testget_dbWeeks();
testget_all_dbWeeks();
testget_dates_text($dates);

echo("test complete</br>");


function testcreate_dbWeeks(){
$newWeek= new Week("03-30-14", "Bscah", "Active");
         echo 'test</br>';
    echo 'will test create_dbWeeks </br>';
    $result = create_dbWeeks();
    echo 'result is ' . $result;
    if ($result)
        echo "create_dbWeeks succeeded </br>";
   
    
    $res = delete_dbweeks($newWeek);
    if ($res == null)
        echo 'Delete failed</br>';
}

function testinsert_dbWeeks(){
$newWeek= new Week("03-30-14", "Bscah", "Active");
         echo 'test</br>';
    echo 'will test insert_dbWeeks </br>';
    $result = insert_dbWeeks($newWeek);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbWeeks succeeded </br>";
    
    $res = delete_dbweeks($newWeek);
    if ($res == null)
        echo 'Delete failed</br>';
}

function testdelete_dbWeeks(){
$newWeek= new Week("03-30-14", "Bscah", "Active");
         echo 'test</br>';
    echo 'will test delete_dbWeeks </br>';
    $result = delete_dbWeeks($newWeek);
  if ($res == null)
        echo 'Delete failed</br>';
    else 
        echo 'delete successful';
}

function testupdate_dbweeks(){
    $newWeek= new Week("03-30-14", "Bscah", "Active");
         echo 'test</br>';
    echo 'will test update_dbWeeks </br>';
    $result = update_dbWeeks();
    echo 'result is ' . $result;
    if ($result)
    {echo "update_dbWeeks succeeded </br>";}
    
        
    $res = delete_dbWeeks($newWeek);
    if ($res == null)
        echo 'Delete failed</br>';
}
function testselect_dbWeeks()
{
    $newWeek= new Week("03-30-14", "Bscah", "Active");
    $nd = insert_dbWeeks($newWeek);
    $id = "03-30-14";
    echo 'will test select_dbWeeks</br>';
    $result = select_dbWeeks($id);
     if ($result != null)
    {echo'select_dbDates failed</br>';}
    
   $res = delete_dbWeeks($newWeek);
    if ($res == null)
    {echo 'Delete failed</br>';}
}
function testget_dbWeeks(){
    $newWeek= new Week("03-30-14", "Bscah", "Active");
    $nd = insert_dbWeeks($newWeek);
    $id = "03-30-14";
    echo 'will test get_dbWeeks</br>';
    $result = get_dbWeeks($id);
     if ($result != null)
    {echo'get_dbDates failed</br>';}
    
   $res = delete_dbWeeks($newWeek);
    if ($res == null)
    {echo 'Delete failed</br>';}
}
function testget_all_dbWeeks(){
    $newWeek= new Week("03-30-14", "Bscah", "Active");
    $nd = insert_dbWeeks($newWeek);
    $id = "03-30-14";
    echo 'will test select_dbWeeks</br>';
    $result = get_all_dbWeeks();
     if ($result != null)
    {echo'select_dbDates failed</br>';}
    
   $res = delete_dbWeeks($newWeek);
    if ($res == null)
    {echo 'Delete failed</br>';}
}
function testget_dates_test(){
    $newWeek= new Week("03-30-14", "Bscah", "Active");
    $nd = insert_dbWeeks($newDate);
    $id = "03-30-14";
    echo 'will test get_dates_test</br>';
    $result = get_dates_text($dates);
     if ($result != null)
    {echo'select_dbDates failed</br>';}
    
   $res = delete_dbWeeks($newWeek);
    if ($res == null)
    {echo 'Delete failed</br>';}
}

?>
