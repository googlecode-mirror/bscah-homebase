<?php

/*
 * Created on Mar 17, 2014
 * @author Derek and Ka Ming
 */

include_once(dirname(__FILE__).'/../domain/Project.php');
class testProject extends UnitTestCase {
      function testProjectModule() {
         $noonproject = new Project("03-28-08-12-15", "Rec", 3, array(), array(), "", "");
         $this->assertEqual($noonproject->get_name(), "12-15");
         $this->assertTrue($noonproject->get_id() == "03-28-08-12-15");
         
// Test new function for resetting project's start/end time
		 $this->assertTrue($noonproject->set_start_end_time(15,17));
		 $this->assertEqual($noonproject->get_id(), "03-28-08-15-17");
		 $this->assertTrue($noonproject->get_name() == "15-17");
		 
// Be sure that invalid times are caught.
		 $this->assertFalse($noonproject->set_start_end_time(13,12));
		 $this->assertTrue($noonproject->get_id() == "03-28-08-15-17");
		 $this->assertTrue($noonproject->get_name() == "15-17");

         $this->assertTrue($noonproject->num_vacancies() == 3);

         $this->assertTrue($noonproject->get_day() == "Fri");
		 $this->assertFalse($noonproject->has_sub_call_list());

         $persons = array();
		 $persons[] = "alex1234567890+alex+jones";
         $noonproject->assign_persons($persons);
         $noonproject->ignore_vacancy();
         $persons[] = "malcom1234567890+malcom+jones";
         $noonproject->assign_persons($persons);
         $noonproject->ignore_vacancy();
         $persons[] = "nat1234567890+nat+jones";
         $noonproject->assign_persons($persons);
         $noonproject->ignore_vacancy();
         $this->assertTrue($noonproject->num_vacancies() == 0);
         $noonproject->add_vacancy();
         $this->assertTrue($noonproject->num_slots() == 4);
         $noonproject->ignore_vacancy();
		 $this->assertTrue($noonproject->num_slots() == 3);

         $noonproject->set_notes("Hello 3-5 project!");
         $this->assertTrue($noonproject->get_notes() == "Hello 3-5 project!");
 		 echo ("testProject complete");
  	  }
}

?>


