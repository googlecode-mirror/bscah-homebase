<?php
/*
* This class will test the project class.
*/
include_once(dirname(__FILE__) . '/../domain/Project.php');
echo "testing Projects.php".'</br>';
testConstructor();
 
//return a message if the first test past or fails 
function testConstructor()
{ 
$test_project = new Project("03-12-14", "overnight", 10, 13, "weekly",15, "malcom1234567890+Malcom+Jones","matt1234567899+Matt+Smith", "Monday", "11-22-33-44-55", "notes");
        
echo "Testing mm-dd-yy".'</br>';
if($test_project->get_mm_dd_yy()=="03-12-14") 
echo 'mm-dd-yy test succeeded </br>'; 
else
echo 'mm-dd-yy test failed </br>';

if($test_project->get_name()=="overnight") 
echo 'name test succeeded </br>'; 
else
echo 'name test failed </br>';

}