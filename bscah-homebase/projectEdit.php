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
    $id = str_replace("_", " ", $_GET["id"]);
    //See what is in the $_GET["id"] array
    error_log("id is ". $_GET["id"]);


    if ($id == 'new') 
    {
        $project = new Project(null, null, 'new', null, null, null, null, null, null, null);
    }
    
    else 
    {
        $project = select_dbProjects($id);
        if (!$project) 
        { // try again by changing blanks to _ in id
            $id = str_replace(" ", "_", $_GET["id"]);
            error_log("The current id is " . $id);
            $project = select_dbProjects($id);
            error_log("The project is". $project);
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
        Editing <?PHP echo($project->get_id()); ?>
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>
</head>
<body>
<div id="container">
    <?PHP include('header.php'); ?>
    <div id="content">
        <?PHP        
            include('projectValidate.inc');
            
            //if(!(isset($_POST["Submit Edits"]))) //in this case, the form has not been submitted, so show it
            //{
                //include('projectForm.inc');
            //}
            if(isset($_POST['name']) && isset($_POST['address']) && isset($_POST['vacancies']) && isset($_POST['date'])&& isset($_POST['start_time']) && isset($_POST['end_time']) )
            {
                //in this case, the form has been submitted, so validate it
                $errors = validate_form();  //step one is validation.
                // errors array lists problems on the form submitted
                if ($errors) {
                    // display the errors and the form to fix
                    show_errors($errors);
                   include('projectForm.inc');
                }
            
                // this was a successful form submission; update the database and exit
                else 
                {
                    process_form($id);
                }
                echo "</div>";
                include('footer.inc');
                echo('</div></body></html>');
                die();
            }
            
            
            else 
            {
                include('projectForm.inc');
            }

            /**
             * process_form sanitizes data, concatenates needed data, and enters it all into a database
             */
            function process_form($id) 
            {
                //echo($_POST['first_name']);
                //step one: sanitize data by replacing HTML entities and escaping the ' character
                $mm_dd_yy = $_POST['date'];// trim(str_replace('\\\'', '', htmlentities(str_replace('&', 'and', $_POST['date']))));
                error_log("In process form this is ".$mm_dd_yy);
                $address = $_POST['address']; //trim(str_replace('\\\'', '\'', htmlentities($_POST['address'])));
                $name = $_POST['name']; //trim(htmlentities($_POST['name']));
                $start_time = $_POST['start_time']; //ereg_replace("[^0-9]", "", $_POST['start_time']);
                $end_time = $_POST['end_time']; //ereg_replace("[^0-9]", "", $_POST['end_time']);
                //$dayOfWeek = trim(htmlentities($_POST['dayOfWeek']));
                $vacancies = $_POST['vacancies']; //ereg_replace("[^0-9]", "", $_POST['vacancies']);
                //$persons = trim(htmlentities($_POST['persons']));_log("In process form this is ".$mm_dd_yy);
                $id = $_POST['old_id']; //trim(htmlentities($_POST['old_id']));
                $notes = $_POST['notes']; //trim(htmlentities($_POST['notes']));

                $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
                //step two: try to make the deletion, password change, addition, or change
                if ($_POST['deleteMe'] == "DELETE") 
                {
                    $result = select_dbProjects($id);
                    if (!$result) {
                        echo('<p>Unable to delete. ' . $mm_dd_yy .
                            ' is not in the database. <br>Please report this error to the House Manager.');
                    }
                    else 
                    {
                        //What if they're the last remaining manager account?
                        if (strpos($type, 'manager') !== false) {
                            //They're a manager, we need to check that they can be deleted
                            $managers = getall_type('manager');
                            if (!$managers || mysql_num_rows($managers) <= 1) 
                            {
                                echo('<p class="error">You cannot remove the last remaining manager from the database.</p>');
                            }
                            else 
                            {
                                $result = delete_dbProjects($id);
                                echo("<p>You have successfully removed " . mm_dd_yy . " from the database.</p>");
                                if ($id == $_SESSION['_id']) 
                                {
                                    session_unset();
                                    session_destroy();
                                }
                            }
                        }
                        else 
                        {
                            $result = delete_dbProjects($id);
                            echo("<p>You have successfully removed " . $mm_dd_yy . " from the database.</p>");
                            if ($id == $_SESSION['_id'])
                            {
                                session_unset();
                                session_destroy();
                            }
                        }
                    }
                }

                // try to add a new project to the database
                //else {
                    if ($_POST['old_id'] == 'new')
                   {
                        $id = $mm_dd_yy;
                        //check if there's already an entry
                        $dup = select_dbProjects($id);
                        if ($dup)
                        {
                            echo('<p class="error">Unable to add ' . $mm_dd_yy .
                                ' to the database. <br>Another project with the same name is already there.');
                        }
                        else 
                        {

                            $newproject =
                                new Project($mm_dd_yy, $address, $name, $start_time, $end_time, //$dayOfWeek,
                                 $vacancies, //$persons, //$id, 
                                 $notes);
                                $result = insert_dbProjects($newproject);
                            if (!$result) 
                            {
                                echo('<p class="error">Unable to add " .$mm_dd_yy." in the database. <br>Please report this error to the House Manager.');
                            }
                            else 
                            {
                                if ($_SESSION['access_level'] == 0) 
                                {
                                    echo("<p>Your application has been successfully submitted.<br>  The House Manager will contact you soon.  Thank you!");
                                }
                                else 
                                {
                                    echo("<p>You have successfully added ". $id . " to the database.</p>");
                                }
                            }
                        }
                    }

                    // try to replace an existing project in the database by removing and adding
                    else 
                    {
                        $id = $_POST['old_id'];

                        $result = delete_dbProjects($id);
                        if (!$result) 
                        {
                            echo('<p class="error">Unable to update ' . $mm_dd_yy .
                                '. <br>Please report this error to the House Manager.');
                        }
                        else
                        {
                            $newproject =
                                new Project($mm_dd_yy, $address, $name, $start_time, $end_time, //$dayOfWeek, 
                                $vacancies, //$persons, //$id, 
                                $notes);
                                echo('<p>You have successfully edited <a href="' . $path . 'projectEdit.php?id=' . $id .
                                    '"><b>' . $mm_dd_yy . ' </b></a> in the database.</p>');
                            }
                            add_log_entry('<a href=\"projectEdit.php?id=' . $id . '\">' . $mm_dd_yy .
                                          ' </a>\'s Project Edit Form has been changed.');
                        }
                    }
                
            //}

        ?>
    </div>
    <?PHP include('footer.inc'); ?>
</div>
</body>
</html> 
