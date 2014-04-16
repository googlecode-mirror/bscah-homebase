<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * 	projectEdit.php
 *  oversees the editing of a project to be added, changed, or deleted from the database
 * 	@author Oliver Radwan and Allen Tucker
 * 	@version 9/1/2008 revised 4/1/2012
 */
session_start();
session_cache_expire(30);
include_once('database/dbProjects.php');
include_once('domain/Project.php');
include_once('database/dbPersons.php');
include_once('domain/Person.php');
include_once('database/dbApplicantScreenings.php');
include_once('domain/ApplicantScreening.php');
include_once('database/dbLog.php');
$id = str_replace("_"," ",$_GET["id"]);


if ($id == 'new') {
    $project = new Project(null, null, 'project', null, null, null, null, null, null, null);
} 
else {
    $project = retrieve_project($id);
    if (!$project) { // try again by changing blanks to _ in id
        $id = str_replace(" ","_",$_GET["id"]);
        $project = retrieve_project($id);
        if (!$project) {
            echo('<p id="error">Error: there\'s no projects with this id in the database</p>' . $id);
            die();
        }
    }
}
?>
<html>
    <head>
        <title>
             Editing <?PHP echo($project->get_name()); ?>
        </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
    </head>
    <body>
        <div id="container">
            <?PHP include('header.php'); ?>
            <div id="content">
                <?PHP
                include('projectValidate.inc');
                if ($_POST['_form_submit'] != 1)
                //in this case, the form has not been submitted, so show it
                    include('projectForm.inc');
                else {
                    //in this case, the form has been submitted, so validate it
                    $errors = validate_form();  //step one is validation.
                    // errors array lists problems on the form submitted
                    if ($errors) {
                        // display the errors and the form to fix
                        show_errors($errors);
                        if ($_POST['availability'] == null)
                            $ima = null;
                        else
                            $ima = implode(',', $_POST['availability']);
                       
                        $project = new Project($_POST['mm_dd_yy'], $_POST['address'], $_POST['name'], $_POST['start_time'], $_POST['end_time'], $_POST['dayOfWeek'], $_POST['vacancies'],
                                        $_POST['persons'], $_POST['id'], $_POST['notes'],$ima);
                        include('projectForm.inc');
                    }
                    // this was a successful form submission; update the database and exit
                    else
                        process_form($id);
                        echo "</div>";
                    include('footer.inc');
                    echo('</div></body></html>');
                    die();
                }

            /**
                 * process_form sanitizes data, concatenates needed data, and enters it all into a database
                 */
                function process_form($id) {
                    //echo($_POST['first_name']);
                    //step one: sanitize data by replacing HTML entities and escaping the ' character
                    $mm_dd_yy = trim(str_replace('\\\'', '', htmlentities(str_replace('&', 'and', $_POST['mm_dd_yy']))));
                    $address = trim(str_replace('\\\'', '\'', htmlentities($_POST['address'])));
                    $name = trim(htmlentities($_POST['name']));
                    $start_time = ereg_replace("[^0-9]", "", $start_time);
                    $end_time = ereg_replace("[^0-9]", "", $end_time);
                    $dayOfWeek = trim(htmlentities($_POST['dayOfWeek']));
                    $vacancies = ereg_replace("[^0-9]", "", $vacancies);
                    $persons = trim(htmlentities($_POST['persons']));
                    // $id = trim(htmlentities($_POST['id']));
                    $notes = trim(htmlentities($_POST['notes']));
                 
                    $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
                    //step two: try to make the deletion, password change, addition, or change
                    if ($_POST['deleteMe'] == "DELETE") {
                        $result = retrieve_project($id);
                        if (!$result)
                            echo('<p>Unable to delete. ' . $name . ' is not in the database. <br>Please report this error to the House Manager.');
                        else {
                            //What if they're the last remaining manager account?
                            if (strpos($type, 'manager') !== false) {
                                //They're a manager, we need to check that they can be deleted
                                $managers = getall_type('manager');
                                if (!$managers || mysql_num_rows($managers) <= 1)
                                    echo('<p class="error">You cannot remove the last remaining manager from the database.</p>');
                                else {
                                    $result = remove_project($id);
                                    echo("<p>You have successfully removed " . mm_dd_yy . " from the database.</p>");
                                    if ($id == $_SESSION['_id']) {
                                        session_unset();
                                        session_destroy();
                                    }
                                }
                            } else {
                                $result = remove_project($id);
                                echo("<p>You have successfully removed " . $name . " from the database.</p>");
                                if ($id == $_SESSION['_id']) {
                                    session_unset();
                                    session_destroy();
                                }
                            }
                        }
                    }
                    
                    // try to add a new project to the database
                    else if ($_POST['old_id'] == 'new') {
                        $id = $mm_dd_yy;
                        //check if there's already an entry
                        $dup = retrieve_project($id);
                        if ($dup)
                            echo('<p class="error">Unable to add ' . $mm_dd_yy . ' to the database. <br>Another project with the same name is already there.');
                        else {
                            
                            $newproject= new Project($mm_dd_yy, $address, $name, $start_time, $end_time, $dayOfWeek, $vacancies, $persons, $id, $notes);
                                        
                                        
                            $result = add_project($newproject);
                            if (!$result)
                                echo ('<p class="error">Unable to add " .$mm_dd_yy." in the database. <br>Please report this error to the House Manager.');
                            else if ($_SESSION['access_level'] == 0)
                                echo("<p>Your application has been successfully submitted.<br>  The House Manager will contact you soon.  Thank you!");
                            else
                                echo("<p>You have successfully added " . $mm_dd_yy . " to the database.</p>");
                        }
                    }

                    // try to replace an existing project in the database by removing and adding
                    else {
                        $id = $_POST['old_id'];
                        
                        $result = remove_project($id);
                        if (!$result)
                            echo ('<p class="error">Unable to update ' . $mm_dd_yy. '. <br>Please report this error to the House Manager.');
                        else {
                        $newproject= new Project($mm_dd_yy, $address, $name, $start_time, $end_time, $dayOfWeek, $vacancies, $persons, $id, $notes);
                            if (!$result)
                                echo ('<p class="error">Unable to update ' . $mm_dd_yy .' <br>Please report this error to the House Manager.');
                           
                            else
                                echo('<p>You have successfully edited <a href="' . $path . 'projectEdit.php?id=' . $id . '"><b>' . $mm_dd_yy . ' </b></a> in the database.</p>');
                            add_log_entry('<a href=\"projectEdit.php?id=' . $id . '\">' . $mm_dd_yy . ' </a>\'s Project Edit Form has been changed.');
                        }
                    }
                }
                ?>
            </div>
            <?PHP include('footer.inc'); ?>
        </div>
    </body>
</html> 
