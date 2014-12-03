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

    session_start();
    session_cache_expire(30);
?>
<!-- page generated by the BowdoinRMH software package -->
<html>
<head>
    <title>
        BSCAH Homebase
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <style>
        #appLink:visited {
            color: gray;
        }
    </style>
</head>
<body>
<div id="container">
<?PHP include('header.php');
      include('accessController.php');  
?>
<div id="content">
<?PHP
    error_log('***********************************index.php***********************');
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    include_once('database/dbLog.php');
    include_once('domain/Shift.php');
    include_once('database/dbShifts.php');

    $person = null;
    error_log('user id is ' . $_SESSION['_id']);
    if ($_SESSION['_id'] != "guest") {
        error_log('in index.php, will retrieve person');
        // need error checking here to make sure _id is set
        $person = retrieve_person($_SESSION['_id']);
        // should really check to make sure a person was retrieved!
        echo "<p>Welcome, " . $person->get_first_name() . ", to Homebase!";
    }
    else {
        echo "<p>Welcome to Homebase!";
    }
    $today = time();
    echo "   Today is " . date('l F j, Y', $today) . ".<p>";
?>

<!-- your main page data goes here. This is the place to enter content -->
<p>
    <?PHP
        if ($_SESSION['access_level'] == 1) {
            echo('<p>
							This is your personal homepage:
							your upcoming scheduled shifts will always be posted here.
						');
        }
        if ($_SESSION['access_level'] == 0) {
            echo('<p> To apply for a volunteer position at the BedStuy Campaign Against Hunger , select <a href="' .
                $path . 'personEdit.php?id=' . 'new' . '">apply</a>.');
        }
    ?>

    <br>If you just want an overview of Homebase, select <a href="<?php echo($path); ?>dataSearch.php">about</a>.
    <?PHP
        if ($person) {
            echo('<p>If you want to learn the details of using this system, select <a href="' . $path .
                'help.php">help</a>.');
        }
    ?>
</p>

<p> When you are finished, please remember to <a href="<?php echo($path); ?>logout.php">logout</a>.</p>

<?PHP
    if ($person) {
        /*
         * Check type of person, and display home page based on that.
         * all: password check
         * guests: show link to application form
         * applicants: show status of application form
         * Volunteers, subs: show upcoming schedule
         * Managers: show vacancies, birthdays, anniversaries, applicants
         */

        //DEFAULT PASSWORD CHECK
        if (md5($person->get_id()) == $person->get_password()) {
            if (!isset($_POST['_rp_submitted'])) {
                echo('<div class="warning"><form method="post"><p><strong>We recommend that you change your password, which is currently default.</strong><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="right" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></td></tr></table></p></form></div>');
            }
            else {
                //they've submitted
                if (($_POST['_rp_newa'] != $_POST['_rp_newb']) || (!$_POST['_rp_newa'])) {
                    echo('<div class="warning"><form method="post"><p>Error with new password. Ensure passwords match.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
                }
                else {
                    if (md5($_POST['_rp_old']) != $person->get_password()) {
                        echo('<div class="warning"><form method="post"><p>Error with old password.</p><br /><table class="warningTable"><tr><td class="warningTable">Old Password:</td><td class="warningTable"><input type="password" name="_rp_old"></td></tr><tr><td class="warningTable">New password</td><td class="warningTable"><input type="password" name="_rp_newa"></td></tr><tr><td class="warningTable">New password<br />(confirm)</td><td class="warningTable"><input type="password" name="_rp_newb"></td></tr><tr><td colspan="2" align="center" class="warningTable"><input type="hidden" name="_rp_submitted" value="1"><input type="submit" value="Change Password"></form></td></tr></table></div>');
                    }
                    else {
                        if ((md5($_POST['_rp_old']) == $person->get_password()) &&
                            ($_POST['_rp_newa'] == $_POST['_rp_newb'])
                        ) {
                            $newPass = md5($_POST['_rp_newa']);
                            change_password($person->get_id(), $newPass);
                        }
                    }
                }
            }
            echo('<br clear="all">');
        }

        //NOTES OUTPUT
        echo('<div class="infobox"><p class="notes"><strong>Notes:</strong><br />');
        echo($person->get_notes() . '</p></div><br>');

        //APPLICANT CHECK
        if ($person->get_first_name() != 'guest' && $person->get_status() == 'applicant') {
            //SHOW STATUS
            echo('<div class="infobox"><p><strong>Your application has been filed.</strong><br><br /><table><tr><td><strong>Step</strong></td><td><strong>Completed?</strong></td></tr><tr><td>Background Check</td><td>' .
                $person['background_check'] . '</td></tr><tr><td>Interview</td><td>' . $person['interview'] .
                '</td></tr><tr><td>Shadow</td><td>' . $person['shadow'] . '</td></tr></table></p></div>');
        }

        //VOLUNTEER CHECK
        if ($_SESSION['access_level'] == 1) {
            //we need to populate their schedule.
            $shifts = selectScheduled_dbShifts($person->get_id());

            $scheduled_shifts = [];
            foreach ($shifts as $shift) {
                $shift_month = get_shift_month($shift);
                $shift_day = get_shift_day($shift);
                $shift_year = get_shift_year($shift);

                $shift_time_s = get_shift_start($shift);
                $shift_time_e = get_shift_end($shift);

                $cur_month = date("m");
                $cur_day = date("d");
                $cur_year = date("y");

                if ($shift_year > $cur_year) {
                    $upcoming_shifts[] = $shift;
                }
                else {
                    if ($shift_year == $cur_year) {
                        if ($cur_month < $shift_month) {
                            $upcoming_shifts[] = $shift;
                        }
                        else {
                            if ($shift_month == $cur_month) {
                                if ($cur_day <= $shift_day) {
                                    $upcoming_shifts[] = $shift;
                                }
                            }
                        }
                    }
                }
            }
            if ($upcoming_shifts) {
                echo('<div class="scheduleBox"><p><strong>Your Upcoming Schedule:</strong><br /></p><ul>');
                foreach ($upcoming_shifts as $tableId) {
                    echo ('<li type="circle">' . get_shift_name_from_id($tableId)) . '</li>';
                }
                echo('</ul><p>If you need to cancel an upcoming shift, please contact House Manager (207-980-6282 or <a href="mailto:housemgr@rmhportland.org>">housemgr@rmhportland.org</a>).</p></div>');
            }
        }

        if ($_SESSION['access_level'] == 2) {
            //We have a manager authenticated
            //log box

            // echo('<div class="logBox"><p><strong>Recent Schedule Changes:</strong><br />');
            // echo('<table class="searchResults">');
            //echo('<tr><td class="searchResults"><u>Time</u></td><td class="searchResults"><u>Message</u></td></tr>');
            // $log = get_last_log_entries(5);
            //for ($i = 4; $i >= 0; --$i) {
            //    echo('<tr><td class="searchResults">' . $log[$i][1] . '</td>' .
            //    '<td class="searchResults">' . $log[$i][2] . '</td></tr>');
            //}
            //echo ('</table><br><a href="' . $path . 'log.php">View full log</a></p></div><br>');

            //beginning of vacancy box
            //For checking time
            $today = mktime(0, 0, 0, date('m'), date('d'), date('y'));
            $two_weeks = $today + 14 * 86400;

            // put into dbShift!
            connect();
            $vacancy_query = "SELECT SHIFTID,VACANCIES FROM SHIFT " .
                "WHERE VACANCIES > 0 ORDER BY SHIFTID;";
            error_log("in index.php, will retrieve shift vacancies with this query: " . $vacancy_query);
            $vacancy_list = mysql_query($vacancy_query);
            if (!$vacancy_list) {
                error_log('sql error while retrieving shifts with vacancies ' . mysql_error());
                echo mysql_error();
            }
            //upcoming vacancies

            if (mysql_num_rows($vacancy_list) > 0) {
                error_log("will display vacancies");
                echo('<div class="vacancyBox">');
                echo('<p><strong>Upcoming Vacancies:</strong><ul>');
                while ($thisRow = mysql_fetch_array($vacancy_list, MYSQL_ASSOC)) {
                    $shift_date = mktime(0, 0, 0, substr($thisRow['SHIFTID'], 0, 2), substr($thisRow['SHIFTID'], 3, 2),
                                         substr($thisRow['SHIFTID'], 6, 2));
                    if ($shift_date > $today && $shift_date < $two_weeks) {
                        echo('<li type="circle"><a href="' . $path . 'editShift.php?shift=' . $thisRow['SHIFTID'] . '">' .
                            get_shift_name_from_id($thisRow['SHIFTID']) . '</a></li>');
                    }
                }
                echo('</ul></p></div><br>');
            }
            //active applicants
       //     connect();

            $applicants_tab = getall_applicants();
            $numLines = 0;
            if (mysql_num_rows($applicants_tab) > 0) {
                echo('<div class="applicantsBox"><p><strong>Open Volunteer Applications:</strong><ul>');
                while ($thisRow = mysql_fetch_array($applicants_tab, MYSQL_ASSOC)) {
                    echo('<li type="circle"><a href="' . $path . 'personEdit.php?id=' . $thisRow['ID'] .
                        '" ID = "appLink">' . $thisRow['NAMEFIRST'] . ' ' . $thisRow['NAMELAST'] . '</a></li>');
                }
                echo('</ul></p></div><br>');
            }
            
            //mysql_close(); This is giving the warning PHP Warning:  mysql_close(): no MySQL-Link resource supplied - GIOVI
            
            //volunteer birthdays and anniversary days
            /*   connect();
               $anniv_query = "SELECT id,NameFirst,NameLast,birthday,start_date FROM person WHERE status LIKE '%active%'";
               $anniversaries = mysql_query($anniv_query);
               if (!$anniversaries)
                   echo mysql_error();
               if (mysql_num_rows($anniversaries) > 0) {
                   echo('<div class="anniversaryBox">');
                   echo('<p><strong>Upcoming Birthdays and Anniversaries:</strong>');

                   echo('<table class="searchResults"><tr><td class="searchResults"><u>Name</u></td><td class="searchResults"><u>Birthday</u></td><td class="searchResults"><u>Start Date</u></td></tr>');
                   while ($thisRow = mysql_fetch_array($anniversaries, MYSQL_ASSOC)) {
                       if ($thisRow['birthday'] != null && $thisRow['start_date'] != null) {
                           $birthday_val = mktime(0, 0, 0, (int) substr($thisRow['birthday'], 0, 2), (int) substr($thisRow['birthday'], 3, 2), date('y'));
                           $startdate_val = mktime(0, 0, 0,(int) substr($thisRow['start_date'], 0, 2), (int) substr($thisRow['start_date'], 3, 2), date('y'));
                           if (($birthday_val >= $today && $birthday_val <= $two_weeks) || ($startdate_val >= $today && $startdate_val <= $two_weeks))
                               echo('<tr><td class="searchResults"><a href="personEdit.php?id=' . $thisRow['id'] . '">' . $thisRow['first_name'] . ' ' . $thisRow['last_name'] . '</a></td><td class="searchResults">' . $thisRow['birthday'] . '</td><td class="searchResults">' . $thisRow['start_date'] . '</td></tr>');
                       }
                   }
                   echo('</table></p></div><br>');
               }
               mysql_close();  */

            // active volunteers who haven't worked recently
            /*      $everyone = getall_names("active", "volunteer");
                  if ($everyone && mysql_num_rows($everyone) > 0) {
                      //active volunteers who haven't worked for the last two months
                      $two_months_ago = $today - 60 * 86400;
                      echo('<div class="inactiveBox">');
                      echo('<p><strong>Unscheduled active house volunteers who haven\'t worked during the last two months:</strong>');
                      echo('<table class="searchResults"><tr><td class="searchResults"><u>Name</u></td><td class="searchResults"><u>Date Last Worked</u></td></tr>');
                      while ($thisRow = mysql_fetch_array($everyone, MYSQL_ASSOC)) {
                          if (!preg_match("/manager/", $thisRow['type'])) {
                              $shifts = selectScheduled_dbShifts($thisRow['id']);
                              $havent_worked = true;
                              $last_worked = "";
                              for ($i = 0; $i < count($shifts) && $havent_worked; $i++) {
                                  $date_worked = mktime(0, 0, 0, get_shift_month($shifts[$i]), get_shift_day($shifts[$i]), get_shift_year($shifts[$i]));
                                  $last_worked = substr($shifts[$i], 0, 8);
                                  if ($date_worked > $two_months_ago)
                                      $havent_worked = false;
                              }
                              if ($havent_worked)
                                  echo('<tr><td class="searchResults"><a href="personEdit.php?id=' . $thisRow['id'] . '">' . $thisRow['first_name'] . ' ' . $thisRow['last_name'] . '</a></td><td class="searchResults">' . $last_worked . '</td></tr>');
                          }
                      }
                      echo('</table></p></div><br>');
                  }  */

        }
    }
?>
</div>
<?PHP include('footer.inc'); ?>
</div>
</body>
</html>
