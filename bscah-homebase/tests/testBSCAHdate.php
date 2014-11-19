<?php
    /*
    * This class will test the person class.
    * It is similar in design the existing testPerson class but, will not require the use of 'UnitTestCase'
    * The design is also derived from newTestDBPerson
    */
    include_once(dirname(__FILE__) . '/../domain/BSCAHdate.php');
    echo "testing BSCAHdate.php" . '</br>';
// person construct is copied from testPerson.php
    testConstructor();

//return a message if the first test past or fails 
    function testConstructor() {
       $my_shifts[] = new Shift("02-28-10-9-13", "Garden", 1, [], [], "");
       $my_project[] = new Project("02-28-10", null, "Food Delivery", 8, 11, 3, null, "notes");
       $test_date = new BSCAHdate("02-28-10", $my_shifts, "manager notes", $my_project);
       $replacement_project = new Project("02-28-14", null, "Truck Delivery", 9, 12, 3, null, "new notes");
       echo "Testing get shifts and get projects" . '</br>';
            $shifts = $test_date->get_shifts();
            $projects = $test_date->get_projects();
            //$replacement_project = new Project("02-28-14", null, "Truck Delivery", 9, 12, 3, null, "new notes");
            foreach ($my_shifts as $value) {
                if($value instanceof Shift)
                {
                    echo "This is a shift value" . '</br>';
                }
                else
                {
                    echo "This is suppose to be a shift value" . '</br>';
                }
            }
            foreach ($my_project as $value) {
                if($value instanceof Project)
                {
                    echo "This is a project value" . '</br>';
                }
                else
                {
                    echo "This is suppose to be a project value" . '</br>';
                }   
            }
            if($test_date->get_id() == "02-28-10")
            {
                echo "ID test succedded" . '</br>';
            }
            else
            {
                 echo "ID test failed" . '</br>';
            }
            if($test_date->get_day() == "Sun")
            {
                echo "Day test succedded" . '</br>';
            }
            else
            {
                 echo "Day test failed" . '</br>';
            }
            if($test_date->get_day_of_week() == 7)
            {
                echo "Day of week test succedded" . '</br>';
            }
            else
            {
                 echo "Day of week test failed" . '</br>';
            }
            if($test_date->get_day_of_year() == 59)
            {
                echo "Day of year test succedded" . '</br>';
            }
            else
            {
                 echo "Day of Year test failed" . '</br>';
            }
            if($test_date->get_year() == 2010)
            {
                echo "Year test succedded" . '</br>';
            }
            else
            {
                 echo "Year test failed" . '</br>';
            }
            if($test_date->get_dom() == 28)
            {
                echo "Day of Month test succedded" . '</br>';
            }
            else
            {
                 echo "Day of Month test failed" . '</br>';
            }
            if($test_date->get_mgr_notes() == "manager notes")
            {
                echo "Manager Notes  test succedded" . '</br>';
            }
            else
            {
                 echo "Manager notes test failed" . '</br>';
            }
            if($test_date->get_name() == "February 28, 2010")
            {
                echo "Name test succedded" . '</br>';
            }
            else
            {
                 echo "Name test failed" . '</br>';
            }
            if($test_date->get_num_projects() == 1)
            {
                echo "Number of projects test succedded" . '</br>';
            }
            else
            {
                 echo "Number of projects test failed" . '</br>';
            }
            //$this->assertTrue($my_date->get_project($key) ==);
           
           //Tests the method of $my_date->get_projects() to see if each element mateches the elments in $my_project 
            if($projects == $my_project)
            {
                echo "Projects test succedded" . '</br>';
            }
            else
            {
                 echo "Projects test failed" . '</br>';
            }
            
            //Tests the method of $my_date->get_shifts() to see if each element mateches the elments in $my_shifts
          
            if($shifts == $my_shifts)
            {
                echo "Shifts test succedded" . '</br>';
            }
            else
            {
                 echo "Shifts test failed" . '</br>';
            }
          
            /**if($test_date->get_shift_id() == "02-28-10-9-13")
            {
                echo "Shift ID test succedded" . '</br>';
            }
            else
            {
                 echo "Shift ID test failed" . '</br>';
            }
            **/

            //$this->assertTrue($my_date->get_shift($key) == "Tue");
            
            //This test if $my_date->replace_project actually replaces the project 
            //$test_date->replace_project($projects, $replacement_project);
            /**if($test_date->get_projects() == $replacement_project)
            {
                echo "Replace project test succedded" . '</br>';
            }
            else
            {
                 echo "Replace project test failed" . '</br>';
            }
            **/
            $test_date->set_mgr_notes("new manager notes");
            if($test_date->get_mgr_notes() == "new manager notes")
            {
                echo "Set Manager Notes test succedded" . '</br>';
            }
            else
            {
                 echo "Set Manger Notes test failed" . '</br>';
            }
            
            
            
            echo("testBSCAHdate complete");
   
       

    }