<?php

/*
 * Created on Mar 17, 2014
 * @author Derek and Ka Ming
 */

include_once(dirname(__FILE__) . '/../domain/Project.php');
include_once('dbPersons.php');
include_once('dbDates.php');
include_once('dbinfo.php');

/**
 * Drops the dbProjects table if it exists, and creates a new one
 * Table fields:
 * 0 id: "mm-dd-yy-ss-ee" is a unique key for this project
 * 1 start_time: Integer: e.g. 10 (meaning 10:00am)
 * 2 end_time: Integer: e.g. 13 (meaning 1:00pm)
 * 3 venue = "weekly"
 * 4 vacancies: # of vacancies for this shift
 * 5 persons: list of people ids, followed by their name, ie "max1234567890+Max+Palmer"
 * 6 Project Desciption: 
     */
    function create_dbProjects() {
        connect();
        mysql_query("DROP TABLE IF EXISTS project");
        $result = mysql_query("CREATE TABLE project (id CHAR(20) NOT NULL, " .
                              "start_time INT, end_time INT, venue TEXT, vacancies INT, " .
                              "persons TEXT, removed_persons TEXT, Project Description TEXT, PRIMARY KEY (id))");
        if (!$result) {
            echo mysql_error();

        return false;
    }
    mysql_close();

    return true;
}

/**
 * Inserts a project into the db
 *
 * @param $p the project to insert
 */
function insert_dbProjects($p) {
    if (!$p instanceof Project) {
        die("Invalid argument for insert_dbProjects function call" . $p);
    }
    connect();
    $query = 'SELECT * FROM project WHERE ProjectID ="' . $p->get_id() . '"';
    $result = mysql_query($query);
    if (!$result) {
        error_log('ERROR on select in insert_dbProjects() ' . mysql_error());
        die('Invalid query: ' . mysql_error());
    }
    if (mysql_num_rows($result) != 0) {
        delete_dbProjects($p);
        connect();
    }
        $query = "INSERT INTO project (ProjectID,Address,Date,Type,Vacancies,StartTime,EndTime,DayOfWeek,Name,Persons,AgeRequirement,ProjectDescription)"
            . " VALUES ('" . $p->get_id() . "','" .
            $p->get_address() . "','" .
            $p->get_mm_dd_yy() . "','" .
            $p->get_type(). "','" .
            $p->num_vacancies() . "','" .
            $p->get_start_time() . "','" .
            $p->get_end_time() . "','" .
            $p->get_dayOfWeek() . "','" .
            $p->get_name() . "','" .
            implode("*", $p->get_persons()) . "','" .
            $p->get_age() . "','" .
            $p->get_project_description() . "')";
    error_log("in insert_dbProjects, insert query is " . $query);
    $result = mysql_query($query);
    if (!$result) {
        echo "unable to insert into project " . $p->get_id() . mysql_error();
        mysql_close();

        return false;
    }
    mysql_close();

    return true;
}

/**
 * Deletes a project from the db
 *
 * @param $p the project to delete
 */
function delete_dbProjects($p) {
    if (!$p instanceof Project) {
        die("Invalid argument for delete_dbProjects function call");
    }
    connect();
    $query = "DELETE FROM project WHERE ProjectID=\"" . $p->get_id() . "\"";
    $result = mysql_query($query);
    if (!$result) {
        error_log('ERROR on DELETE in delete_dbProjects() ' . mysql_error());
        die('Invalid query: ' . mysql_error());
    }
    if (!$result) {
        echo "unable to delete from project " . $p->get_id() . mysql_error();
        mysql_close();

        return false;
    }
    mysql_close();

    return true;
}

/**
 * Updates a project in the db by deleting it (if it exists) and then replacing it
 *
 * @param $p the project to update
 */
function update_dbProjects($p) {
    error_log("updating project in database");
    if (!$p instanceof Project) {
        die("Invalid argument for project->replace_project function call");
    }
    delete_dbProjects($p);
    insert_dbProjects($p);

    return true;
}

/**
 * Selects a project from the database
 *
 * @param $id a project id
 *
 * @return Project or null
 */
function select_dbProjects($id) {
    connect();
    $p = null;
    $query = "SELECT * FROM project WHERE ProjectID =\"" . $id . "\"";
    error_log("in select_dbProjects, query is " . $query);
    $result = mysql_query($query);
    mysql_close();
    if (!$result) {
        error_log('ERROR on select in select_dbProjects() ' . mysql_error());
        die('Invalid query: ' . mysql_error());
        }

        $result_row = mysql_fetch_assoc($result);//Was fetch_assoc - GIOVI

        if ($result_row != null) {
            $persons = [];
            //$removed_persons = []; Unnecessary - GIOVI
            if ($result_row[8] != "") {
                $persons = explode("*", $result_row[8]);
            }
            $p = make_a_project($result_row); 
            //Before - GIOVI
            //$p = new Project($result_row[0], $result_row[2], $result_row[1], $result_row[7], $result_row[4], $result_row[5], $result_row[3], $persons, $result_row[9]);
        }
        
        return $p;
    }
    
    function select_dbProjects_by_date($date) {
        connect();
        $projects = [];
        $query = "SELECT ProjectID FROM project WHERE DATE =\"" . $date . "\"";
        $result = mysql_query($query);
        if (!$result) {
            error_log('ERROR on select in get_dbProjects() ' . mysql_error());
            die('Invalid query: ' . mysql_error());
        }

        while ($row = mysql_fetch_array($result, MYSQL_NUM)) 
        {
            error_log($row[0]);
            $projects[] = $row[0];
            
        }
        
        return $projects;
    }

function search_dbProjects_By_Name($name) {
    connect();
    $query = "SELECT * FROM project WHERE name like '" . $name . "%'";
    $recordsProject = mysql_query($query);
    if (!$recordsProject) {
        error_log('ERROR in search_dbProjects_By_Name. Query is ' . $query);
        die('Invalid query: ' . mysql_error());
    }
    $projects = [];
    while ($results = mysql_fetch_assoc($recordsProject)) {
        $tempProject = make_a_project($results);
        $projects[] = $tempProject;
    }
    return $projects;
}

/**
 * Returns an array of $ids for all projects scheduled for the person having $person_id
 */
function selectScheduled_dbProjects($person_id) {
    connect();
    $project_ids = mysql_query("SELECT id FROM project WHERE persons LIKE '%" . $person_id . "%' ORDER BY id");
    $projects = [];
    if ($project_ids) {
        while ($thisRow = mysql_fetch_array($project_ids, MYSQL_ASSOC)) {
            $projects[] = $thisRow['id'];
        }
    }
    mysql_close();

    return $projects;
}

/**
 * Returns the month, day, year, start, end, or venue of a project from its id
 */
function get_project_month($id) {
    return substr($id, 0, 2);
}

function get_project_day($id) {
    return substr($id, 3, 2);
}

function get_project_year($id) {
    return substr($id, 6, 2);
}

function get_project_start($id) {
    if (substr($id, 9) == "overnight") {
        return 0;
    } else {
        if (substr($id, 11, 1) == "-") {
            return substr($id, 9, 2);
        } else {
            return substr($id, 9, 1);
        }
    }
}

function get_project_end($id) {
    if (substr($id, 9) == "overnight") {
        return 1;
    } else {
        if (substr($id, 11, 1) == "-") {
            return substr($id, 12, 2);
        } else {
            return substr($id, 11, 2);
        }
    }
}

/*
 * Creates the $project_name of a project, e.g. "Sunday, February 14, 2010 2pm to 5pm"
 *         from its $id, e.g. "02-14-10-14-17"
 */

/* function get_project_name_from_id($id) {
  $project_name = date("l F j, Y", mktime(0, 0, 0, get_project_month($id), get_project_day($id), get_project_year($id)));
  $project_name = $project_name . " ";
  $st = get_project_start($id);
  $et = get_project_end($id);
  if ($st==0)
  $project_name = $project_name . "overnight";
  else {
  $st = $st < 12 ? $st . "am" : $st - 12 . "pm";
  if ($st == "0pm")
  $st = "12pm";
  $et = $et < 12 ? $et . "am" : $et - 12 . "pm";
  if ($et == "0pm")
  $et = "12pm";
  $project_name = $project_name . $st . " to " . $et;
  }
  return $project_name;
  } */

/**
 * Tries to move a project to a new start and end time.  New times must
 * not overlap with any other project on the same date and venue
 * @return false if project doesn't exist or there's an overlap
 * Otherwise, change the project in the database and @return true
 */
function move_project($p, $new_start, $new_end) {
// first, see if it exists
    $old_s = select_dbProjects($p->get_id());
    if ($old_s == null) {
        return false;
    }
// now see if it can be moved by looking at all other projects for the same date and venue
    $new_s = $p->set_start_end_time($new_start, $new_end);
    $current_projects = selectDateVenue_dbProjects($p->get_date(), $p->get_venue());
    connect();
    for ($i = 0; $i < mysql_num_rows($current_projects); ++$i) {
        $same_day_project = mysql_fetch_row($current_projects);
        if ($old_s->get_id() == $same_day_project[0]) {  // skip its own entry
            continue;
        }
        if (proj_timeslots_overlap($same_day_project[1], $same_day_project[2], $new_s->get_start_time(), $new_s->get_end_time())) {
            $p = $old_s;
            mysql_close();

            return false;
        }
    }
    mysql_close();
// we're good to go
    replace_dbDates($old_s, $new_s);
    delete_dbProjects($old_s);

    return true;
}

/**
 * @result == true if $s1's timeslot overlaps $s2's timeslot, and false otherwise.
 */
function proj_timeslots_overlap($s1_start, $s1_end, $s2_start, $s2_end) {
    if ($s1_start == "overnight") {
        if ($s2_start == "overnight") {
            return true;
        } else {
            return false;
        }
    } else {
        if ($s2_start == "overnight") {
            return false;
        }
    }
    if ($s1_end > $s2_start) {
        if ($s1_start >= $s2_end) {
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

    function make_a_project($result_row) 
    {
        $the_project = new Project(
            //$result_row['ProjectID'],
            $result_row['Date'],
            $result_row['Address'],
            $result_row['Type'],
            $result_row['Name'],
            $result_row['StartTime'],
            $result_row['EndTime'],
            $result_row['Vacancies'],
            $result_row['Persons'],
            $result_row['AgeRequirement'],    
            $result_row['Project Description']
            //$result_row['DayOfWeek'],           
    );

    return $the_project;
}

function get_all_projects() {
    connect();
    $query = "SELECT * FROM project";
    $result = mysql_query($query);
    if ($result == null || mysql_num_rows($result) == 0) {
        mysql_close();

        return false;
    }
//Repeated line 332 on this line - GIOVI
    $projects = [];
    while ($result_row = mysql_fetch_assoc($result)) {
        $project = make_a_project($result_row);
        $projects[] = $project;
    }

    return $projects;
}

// this function is for exporting volunteer data
function get_all_people_in_past_projects() {
    $today = date('m-d-y');
    $people_in_projects = [];
    $all_projects = get_all_projects();
    foreach ($all_projects as $a_project) {
        if (substr($a_project->get_id(), 6, 2) >= substr($today, 6, 2) &&
                substr($a_project->get_id(), 0, 5) >= substr($today, 0, 5)
        ) {
            continue;
        } // skip present and future projects
        // okay, this is a past project, so add person-project pairs
        $persons = explode('*', $a_project->get_persons());
        //     if (!$persons[0])  // skip vacant projects
        //        array_project($persons);
        foreach ($persons as $a_person) {
            if (strpos($a_person, "+") > 0) {
                $people_in_projects[] = substr($a_person, 0, strpos($a_person, "+")) . "," . $a_project->get_id();
            }
        }
    }
    sort($people_in_projects);

    return $people_in_projects;
}

// this function is for reporting volunteer data
function get_all_peoples_histories_in_proj() {
    $today = date('m-d-y');
    $histories = [];
    $all_projects = get_all_projects();
    foreach ($all_projects as $a_project) {
        $persons = explode('*', $a_project->get_persons());
        if (!$persons[0]) {  // skip vacant projects
            array_shift($persons); //Was array_project, must have thought this was a user function - GIOVI
        }
        if (count($persons) > 0) {
            foreach ($persons as $a_person) {
                if (strpos($a_person, "+") > 0) {

                    $person_id = substr($a_person, 0, strpos($a_person, "+"));

                    if (array_key_exists($person_id, $histories)) {
                        $histories[$person_id] .= "," . $a_project->get_id();
                    } else {
                        $histories[$person_id] = $a_project->get_id();
                    }
                }
            }
        }
    }
    ksort($histories);

    return $histories;
}

// BKM- renamed this by putting proj on the front, but that is a bad fix
// most likely this should be removed, or refactored to a file of "useful" date functions
function proj_date_create_from_mm_dd_yyyy($mm_dd_yyyy) {
    if (strpos($mm_dd_yyyy, "/") > 0) {
        return mktime(0, 0, 0, substr($mm_dd_yyyy, 0, 2), substr($mm_dd_yyyy, 3, 2), substr($mm_dd_yyyy, 6, 4));
    } else {
        return mktime(0, 0, 0, substr($mm_dd_yyyy, 0, 2), substr($mm_dd_yyyy, 3, 2), "20" . substr($mm_dd_yyyy, 6, 2));
    }
}

//Gets all of the projects with the selected criteria
function get_Projects_By_All_Fields($projName, $projAddress, $projDay, $projType, $projVac, $projDate){
    connect();
    $query = "SELECT * FROM project WHERE name LIKE '%" . $projName . "%'" .
            " AND address LIKE '%" . $projAddress . "%'" .
            " AND DayOfWeek LIKE '%" . $projDay . "%'" .
            " AND type LIKE '%" . $projType . "%'" . 
            " AND vacancies LIKE '%" . $projVac . "%'" . 
            "AND date LIKE '%" . $projDate . "%'" ;
            //. "ORDER BY vacancies";
    $result = mysql_query($query);
    if(!$result) {
            die('Invalid query: ' . mysql_error());
    }
    
    $projects = [];
    while ($resultsAllProj = mysql_fetch_assoc($result)) {
        $tempProject = make_a_project($resultsAllProj);
        $projects[] = $tempProject;
    }
    return $projects;
}

//This method adds a person to an existing project. The field in the DB requires the person's ID, first name, and last name.
function add_A_Person($idProject, $idPerson, $fNamePerson, $lNamePerson) {
    //connect();
    //Counter to determine whether or not a person is found in the delimited string
    $counter = 0;
    $removedPersonConcatenated = "";

    //Get the current project so that you can get the current people in the project.
    $currentProject = select_dbProjects($idProject);
    $currentPeople = $currentProject->get_persons();

    //Use the * delimiter to separate multiple values in a single persons field. (Breaks 1NF)
    $allPeople = explode('*', $currentPeople);

    //Concatenate the Person credentials to make it look like the DB field.
    $concatenatedPerson = "*" . $idPerson . "+" . $fNamePerson . "+" . $lNamePerson . "+";
    $allPeopleConcatenated = $currentPeople . $concatenatedPerson;
    
    $formattedPerson = str_replace("*", "", $concatenatedPerson);
    //Checks each delimited string to see if it is equal to the current person trying to add/remove themselves
    foreach ($allPeople as $individualPerson) {
        if ($formattedPerson == $individualPerson) {
            $counter = 1;
        } else {
            //Concatenated string without person
            $removedPersonConcatenated = $removedPersonConcatenated . $individualPerson;
        }
    }
    //Checks if the counter came back as 1, in which case the person is already in the DB and needs to be removed.
    
    if ($counter == 1) {
        remove_Person_To_Person_Column($removedPersonConcatenated, $idProject);
    } else {
        add_Person_From_Person_Column($allPeopleConcatenated, $idProject);
    }
}

function remove_Person_To_Person_Column($removedPersonConcatenated, $idProject) {
    //echo($removedPersonConcatenated);
    connect();
    $query = "UPDATE project SET persons = \"" . $removedPersonConcatenated . "\" WHERE ProjectID = \"" . $idProject . "\"";
    error_log($query);

    $result = mysql_query($query);
    if (!$result) {
        error_log("Error on add_A_person function, remove update query:" . mysql_error());
        die();
    }
    echo("You were succesfully removed!");
}

function add_Person_From_Person_Column($allPeopleConcatenated, $idProject) {
    //Add new person to the end of the existing people in the DB (sql)
    connect();
    $query = "UPDATE project SET persons = \"" . $allPeopleConcatenated . "\" WHERE ProjectID = \"" . $idProject . "\"";
    error_log($query);
    $result = mysql_query($query);
    if (!$result) {
        error_log("Error on add_A_person function, add update query:" . mysql_error());
        die();
    }
    echo("You were successfully added!.");
}

?>
