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
$test_project = new Project("03-12-14-10-13","10-13", 10, 13, "weekly",15, "malcom1234567890+Malcom+Jones","matt1234567899+Matt+Smith", "Monday", "11-22-33-44-55", "notes");
    
        
echo "Testing mm_dd_yy".'</br>';
if($test_project->get_mm_dd_yy()=="03-12-14") 
echo 'mm_dd_yy test succeeded </br>'; 
else
echo 'mm_dd_yy test failed </br>';

if($test_project->get_name()=="10-13") 
echo 'name test succeeded </br>'; 
else
echo 'name test failed </br>';

if($test_project->get_start_time() == 10)
    echo 'start time test succeeded </br>';
else
    echo 'start time test failed </br>';

if ($test_project->get_end_time()==13)
    echo 'end time test succeeded </br>';
else
    echo 'end time test failed </br>';

if($test_project->get_venue() == "weekly")
    echo 'venue test succeeded </br>';
else
    echo 'venue test failed </br>';
if($test_project->get_vacancies() == 15)
    echo 'vacancies test succeeded </br>';
else
    echo 'vacancies test failed </br>';

if($test_project->get_persons() == "malcom1234567890+Malcom+Jones")
    echo 'persons test succeeded </br>';
else
    echo 'persons test failed </br>';

if($test_project->get_removed_persons() == "matt1234567899+Matt+Smith")
    echo 'removed persons test succeeded </br>';
else 
    echo 'removed persons test failed </br>';

}