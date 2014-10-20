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


    /**
     * validate_form validates the form data, checking all legality.
     * it returns an array of the errors with the form (string warnings)
     * this array is null (aka false) if there are no errors
     */
    function validate_form() {
        if ($_POST['date'] == null || $_POST['date'] == 'new') {
            $errors[] = 'Please enter the date of this project';
        }
        if ($_POST['address'] == null) {
            $errors[] = 'Please enter an address';
        }
        if ($_POST['name'] == null) {
            $errors[] = 'Please enter a name';
        }
        if ($_POST['start_time'] == null) {
            $errors[] = 'Please enter a start time';
        }
        if ($_POST['end_time'] == null) {
            $errors[] = 'Please enter an end time';
        }
        //if ($_POST['dayOfWeek'] == null) {
           // $errors[] = 'Please enter a day of the week';
        //}
        if ($_POST['vacancies'] == null) {
            $errors[] = 'Please enter the amount of people that can join this project';
        }
        //if ($_POST['persons'] == null)
        //$errors[] = 'Please enter the amount of persons';
        //if ($_POST['notes'] == null)
        //$errors[] = 'Please enter notes';   
        return $errors;
    }

    function show_errors($e) {
        //this function should display all of our errors.
        echo('<div class="warning">');
        echo('<ul>');
        foreach ($e as $error) {
            echo("<li><strong><font color=\"red\">" . $error . "</font></strong></li>\n");
        }
        echo("</ul></div></p>");
    }

?>