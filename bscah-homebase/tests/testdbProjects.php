<?php
/*
 * Created on Mar 18, 2014
 * @author Derek and Ka Ming
 */
include_once(dirname(__FILE__).'/../database/dbProjects.php');
include_once(dirname(__FILE__).'/../database/dbDates.php');
class testdbProjects extends UnitTestCase {
  function testdbProjectsModule() {
	$p1=new Project("02-25-08-15-18","Rec", 3, array(), array(), "", "");
	$this->assertTrue(insert_dbProjects($p1));
	$this->assertTrue(delete_dbProjects($p1));
	$p2=new Project("02-25-08-15-18","Rec",3, array(), array(), "", "");
	$this->assertTrue(insert_dbProjects($p2));
	$p2=new Project("02-25-08-15-18","Rec",2, array(), array(), "", "");
	$this->assertTrue(update_dbProjects($p2));
	$projects[] = $p2;
	$this->assertTrue(delete_dbProjects($p2));
	echo ("testdbProjects complete");
  }
}
?>
