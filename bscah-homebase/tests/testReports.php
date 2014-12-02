<?php
// test script for reportsAjax.php

include_once(dirname(__FILE__) . '/../database/dbShifts.php');
include_once(dirname(__FILE__) . '/../database/dbPersons.php');
include_once(dirname(__FILE__) . '/../domain/Person.php');
include_once(dirname(__FILE__) . '/../domain/Shift.php');
include_once(dirname(__FILE__) . '/../reportsAjax.php');
define("personID", "John7188475582"); //Manipulate these to 
define("shiftID", "09-18-14-10-13"); //Search, add, or remove
define("projectID","10-31-14-10-16");
define("NameFirst", "John");         //A person, project, or shift from the
define("NameLast", "Smith");         //Table; First check to see if
                                     //John Smith is already in the table - GIOVI
        
        echo 'testing reportsAjax.php</br>';
        error_log('testing reportsAjax.php</br>');
        
        createPerson();
        createShift();
        createProject();
        addPersontoShift();
        addPersontoProject();
        getReport();
        deletePerson();
        deleteShift();
        deleteProject();
        echo 'reportsAjax.php testing complete</br>';
        error_log('testing reportsAjax.php</br>');

function createPerson()//Creates a person in the person table - GIOVI
{
    $m = new Person("John", "Smith", "10-12-87", "Male", "555 Main Street", "Flushing", "NY", "11111", "7188475582",
                        "2072654046", "john.smith@stjohns.edu", "volunteer", " ", "Schedule", "I like helping out",
                        "55555", "03-14-14", "email");
        $result = add_person($m);
        echo 'result is ' . $result . '</br>';
        if ($result) {
            echo "person was added </br>";
        }
        else {
            echo "person already exists in db, not added</br>";
        }
}

function deletePerson()//Removes a person from the person table - GIOVI
{
    $res = remove_person(personID);
        
        if ($res == null) { echo 'Remove failed</br>'; }
        else { echo "</br>" . personID . " has been removed sucessfully.</br>"; }
}

function createShift() //At the moment I can't get insert_dbShifts($s) to work so this is custom - GIOVI
{ 
    connect();
    
    $query = "INSERT INTO shift (id, start_time, end_time, venue, vacancies, persons, removed_persons, notes) 
              VALUES('09-18-14-10-13', '10', '13', 'garden', '3', null, null, null)"; //Remember that the difference of 10 and 13(1pm) is 3 hours so John Smith's work time is 3 hours on a Thursday - GIOVI
    $result = mysql_query($query);
        if (!$result) {
            echo "unable to insert into shift " . $result->id. mysql_error();
            mysql_close();

            return false;
        }
        error_log("The shift is " . $query);
        mysql_close();

        return true;
}

function deleteShift()//At the moment I can't get delete_dbShifts($s) to work so this is custom - GIOVI
{
   connect();
        
    $query = "DELETE FROM shift WHERE id=\"" . shiftID . "\"";
    $result = mysql_query($query);
        
        if (!$result) {
            echo "unable to delete from shift " . shiftID . mysql_error();
            mysql_close();

            return false;
        }
        
        else { echo shiftID . " has been removed sucessfully.</br>"; }
        
        mysql_close();

        return true;
}

function addPersontoShift() //This will add a person to the persons column in the shift table; They will be added as personID+NameFirst+NameLast+
{
    $arr = array(personID, NameFirst, NameLast);
    $addper2shift = (implode('+', $arr)) . '+';
    echo "The shift's person is $addper2shift </br>";
    
    connect();
    
    $query = "UPDATE shift SET persons = '$addper2shift' WHERE id = '" . shiftID . "'";
    error_log("The query is $query");
    
    $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select from person' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
    
    mysql_close();
    
    return true;
}

function createProject() //This creates a new project - GIOVI
{ 
    connect();
    
    $query = "INSERT INTO project (ProjectID, Address, Date, Vacancies, StartTime, EndTime, DayOfWeek, Name, Persons, Notes) 
              VALUES('10-31-14-10-16', '4025 Douglas Dairy Road Comers Rock', '10-31-14', '5', '10', '16', 'Fri', '10-16', '', '')";
    $result = mysql_query($query);
        if (!$result) {
            echo "unable to insert into project " . $result->id. mysql_error();
            mysql_close();

            return false;
        }
        error_log("The project is " . $query);
        mysql_close();

        return true;
}

function deleteProject()//This deletes a new project - GIOVI
{
   connect();
        
    $query = "DELETE FROM project WHERE ProjectID=\"" . projectID . "\"";
    $result = mysql_query($query);
        
        if (!$result) {
            echo "unable to delete from project " . projectID . mysql_error();
            mysql_close();

            return false;
        }
        
        else { echo projectID . " has been removed sucessfully.</br>"; }
        
        mysql_close();

        return true;
}

function addPersontoProject() //This will add a person to the Persons column in the project table; They will be added as personID+NameFirst+NameLast+
{
    $arr = array(personID, NameFirst, NameLast);
    $addper2project = (implode('+', $arr)) . '+';
    echo "The project's person is $addper2project </br>";
    
    connect();
    
    $query = "UPDATE project SET Persons = '$addper2project' WHERE ProjectID = '" . projectID . "'";
    error_log("The query is $query");
    
    $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select from person' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }
    
    mysql_close();
    
    return true;
}

function getReport()//The main tester, this will display the three tables that ought to be generated on the website
{
    $allshifthistories = get_all_peoples_histories_in_shifts(); // This returns a key sorted list of everyone's names that are or were in shifts; 
                                             //The key being the the person's id and the associated value being the id of every shift s/he is in separated by commas. - GIOVI
    $allprojecthistories = get_all_peoples_histories_in_proj();//Same as above but for projects - GIOVI
    $namearr = array(NameFirst, NameLast);
    $name = implode(' ', $namearr);
    $nameinarr = array($name); //Remember that the name(s) must be an array in order for it to be able to be passed through the foreach in the following method
    error_log("The name is " . $name);
    
    //You can add a from/to date in the two blanks('') to have a specified range; Format mm/dd/yyyy  - GIOVI
    report_by_volunteer_names($nameinarr, $allshifthistories, '', '');//This method takes an array of name(s) and the histories and should display the days for each individual and the number of hours they work for each day with a total - GIOVI
    
    report_shifts_totalhours_by_day($allshifthistories, '', ''); //This method takes all the histories from everyone and displays the total hours everyone works for each day and timeshift as well as the total - GIOVI
    
    report_shifts_staffed_vacant_by_day('', ''); //This method will take in a time range or will use the default (01/01/2000 to 12/31/2020) and will display all the shifts and vacancies for each day and timeshift as well as the total - GIOVI
    
    report_projects_totalhours_by_day($allprojecthistories, '', '');
    
     report_project_vacancies('', '');
}
