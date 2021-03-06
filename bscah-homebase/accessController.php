<?PHP
 /*
  * Purpose for creation was to partition the old header.php file so that the new header.php would only focus on the 
  * setup/design of a given page while this page (accessController.php) would handle all the access for any given page 
  * that calls upon it.
  * 
  * @author Rocco J. Sacramone
  * @version 11/5/2014
  */
?>

<div align="center" id="navigationLinks">

<?PHP
        //Log-in security
        //If they aren't logged in, display our log-in form.
   /*if(empty($_SESSION['exists'])){
       //session_start();
       include('homepageMain.php');
    }
    else{
    $_SESSION['exists'] = true;
    {*/
        if (!isset($_SESSION['logged_in'])) {
            error_log('in accessController.php, not logged in, will call login form');
            include('homepageMain.php');    //calls the newhomepage
            //include('projectInfo.php');
            die();
        }
         
        //}
        else {
            if ($_SESSION['logged_in']) {
                error_log('in accessController.php, _logged_in is set');
                /*         * Set our permission array.
                 * anything a guest can do, a volunteer and house manager can also do
                 * anything a volunteer can do, a house manager can do.
                 *
                 * If a page is not specified in the permission array, anyone logged into the system
                 * can view it. If someone logged into the system attempts to access a page above their
                 * permission level, they will be sent back to the home page.
                 */
                //pages guests are allowed to view
                //$permission_array['index.php'] = 0;
                //$permission_array['about.php'] = 0;
                //$permission_array['personEdit.php'] = 0;
                //$permission_array['projectInfo.php'] = 0;
                //pages volunteers can view
                $permission_array['help.php'] = 1;
                $permission_array['view.php'] = 1;
                 $permission_array['personSearch.php'] = 1;
                $permission_array['calendar_new.php'] = 1;
                //$permission_array['projectInfo.php'] = 1;
                $permission_array['projectTimeInfo.php'] = 1;
                 $permission_array['projectSearch.php'] = 1;
                //pages only managers can view
                $permission_array['projectEdit.php'] = 2;
                $permission_array['viewSchedule.php'] = 2;
                $permission_array['addWeek.php'] = 2;
                //$permission_array['rmh.php'] = 2;
                $permission_array['log.php'] = 2;
                $permission_array['dataSearch.php'] = 2;
                $permission_array['reports.php'] = 2;
                $permission_array['editMasterSchedule.php'] = 2;
                //$permission_array['projectInfo.php'] = 2;
                $permission_array['projectTimeInfo.php'] = 2;
                $permission_array['projectLeaderInfo.php'] = 2;

                //Check if they're at a valid page for their access level.
                //   $current_page = substr($_SERVER['PHP_SELF'], 1);
                $current_page = basename($_SERVER['PHP_SELF']);

                error_log('access level is ' . $_SESSION['access_level']);
                error_log('$current_page is ' . $current_page);
                error_log('permission for current page is set to ' . $permission_array[$current_page]);
                //  echo "current page = ".$current_page;
                if ($permission_array[$current_page] > $_SESSION['access_level']) {
                    error_log("in header.php, want to redirect back to index.php");
                    //in this case, the user doesn't have permission to view this page.
                    //we redirect them to the index page.
                    echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
                    //note: if javascript is disabled for a user's browser, it would still show the page.
                    //so we die().
                    die();
                }

                //This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
                $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));


                //they're logged in and session variables are set.
                /*if ($_SESSION['access_level'] >= 0) {
                    echo('<a href="' . $path . 'index.php"><b>home</b></a> | ');
                    //echo('<a href="' . $path . 'projectEdit.php?id=' . 'new' . '"><b>projects</b></a> | ');
                    echo('<a href="' . $path . 'about.php"><b>about</b></a>');

                }*/
                /*if ($_SESSION['access_level'] == 0) {
                    echo(' | <a href="' . $path . 'personEdit.php?id=' . 'new' . '"><b>apply</b></a>');
                }*/              
                if ($_SESSION['access_level'] == 1) {
                    echo('  <strong>calendars:</strong> <a href="' . $path .
                        'calendar_new.php?venue=house">current, </a>');
                    echo('<strong>projects :</strong> <a href="' . $path . 'projectSearch.php?id=' . 'none' . '">search</a> |');
                    echo(' | <a href="' . $path . 'help.php?helpPage=' . $current_page .
                        '" target="_BLANK"><b>help</b></a>');
                    echo(' | <a href="' . $path . 'logout.php"><b>logout</b></a>');
                    //echo('<strong>projects :</strong> <a href="' . $path . 'projectSearch.php">search</a>,
                    //    <a href="projectEdit.php?id=' . 'new' . '">add </a>');

                    //        echo('<a href="' . $path . 'calendar.php?venue=guestchef">guest chef, </a>');
                    //         echo('<a href="' . $path . 'calendar.php?venue=parking">parking, </a>');
                    //        echo('<a href="' . $path . 'calendar.php?venue=activities">activities | </a>');
                    //         echo('<a href="https://sites.google.com/site/rmhvolunteersite"><strong>around the house</strong> </a>');
                }
                
             
                
                if ($_SESSION['access_level'] == 1.5) {
                    echo('<br>');
                    echo('<strong>volunteers :</strong> <a href="' . $path . 'personSearch.php">');
                    echo(' | <a href="' . $path . 'logout.php"><b>logout</b></a>');
                }
                if ($_SESSION['access_level'] >= 2) {
                    echo('  <strong> master schedules</strong> : '
                            . '<a href=" ' . $path . 'viewSchedule.php?frequency=garden ">garden, </a>'
                            . '<a href=" ' . $path . 'viewSchedule.php?frequency=pantry">pantry </a> | '); 

                    echo('<strong>volunteers :</strong> <a href="' . $path . 'personSearch.php">search</a>,
			        <a href="personEdit.php?id=' . 'new' . '">add </a> | ');
                    
                    echo('<strong>projects :</strong> <a href="' . $path . 'projectSearch.php?id=' . 'none' . '">search</a>,
                                <a href="' . $path . 'calendar_new.php">project calendar</a>,
			        <a href="projectEdit.php?id=' . 'new' . '">add, </a>
                                <a href=" ' . $path . 'projectInfo.php">project information, </a>
                                <a href=" ' . $path . 'specialProject.php">special project </a>');

                    echo(' | <strong><a href="' . $path . 'reports.php">reports</a> </strong>');
                    echo(' | <strong><a href="' . $path . 'log.php">logs</a></strong>');
                    echo(' | <a href="' . $path . 'help.php?helpPage=' . $current_page .
                        '" target="_BLANK"><b>help</b></a>');
                    echo(' | <a href="' . $path . 'logout.php"><b>logout</b></a>');
                    //    echo(' | <strong>data :</strong> <a href="' . $path . 'dataSearch.php">search and export</a> ');
                }
                
            }
        }
    ?>
</div>


