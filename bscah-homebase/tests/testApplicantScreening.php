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
     * Test suite for ApplicantScreening
     * Created on Feb 15, 2012
     * @author Jackson Moniaga
     */

//first I include the php file I'm testing
    include_once(dirname(__FILE__) . '/../domain/ApplicantScreening.php');
    echo("test");
    testApplicantScreeningModule();
//class testApplicantScreening extends UnitTestCase {

    function testApplicantScreeningModule() {

        $myApplicantScreening =
            new ApplicantScreening("volunteer", "Gabrielle1111234567", "Background_Check,Interview", "unpublished");

        //first assertion - check that a getter is working from the superconstructor's initialized data
        $this->assertTrue($myApplicantScreening->get_type() == "volunteer");
        echo("test");
        $this->assertTrue($myApplicantScreening->get_creator() == "Gabrielle1111234567");
        $this->assertEqual($myApplicantScreening->get_steps(), ["Background_Check", "Interview"]);
        $this->assertTrue($myApplicantScreening->get_status() == "unpublished");
        echo("testApplicantScreening complete");
    }

//}
?>