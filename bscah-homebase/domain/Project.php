<?php

include_once(dirname(__FILE__).'/../database/dbProjects.php');
include_once(dirname(__FILE__).'/../database/dbPersons.php');

/**
 * Description of Project
 *
 * @author Derek and Ka Ming
 */
class Project {





    private $mm_dd_yy;      // String: "mm-dd-yy".
    private $name;          // String: 'ss-ee' or 'overnight', where ss = start time and ee = end time e.g., '9-12'
    private $start_time;    // Integer: e.g. 10 (meaning 10:00am)
    private $end_time;      // Integer: e.g. 13 (meaning 1:00pm)
    private $venue;         //  "weekly" or "monthly"
    private $vacancies;     // number of vacancies in this project
    private $persons;       // array of person ids filling slots, followed by their name, ie "malcom1234567890+Malcom+Jones"
    private $removed_persons; // array of persons who have previously been removed from this project
    private $day;         // string name of day "Monday"...
    private $id;            // "mm-dd-yy-ss-ee" is a unique key for this project
    private $notes;  // notes written by the manager

    /*
     * construct an empty project with a certain number of vacancies
     */

    function __construct($id, $name, $start_time, $end_time, $venue, $vacancies, $persons, $removed_persons, $notes) {
    	$this->mm_dd_yy = substr($id, 0, 8);
        $this->name = substr($id, 9);
        $i = strpos($this->name, "-");
        if ($i>0) 
            {
        	$this->start_time = substr($this->name, 0, $i);
        	$this->end_time = substr($this->name, $i + 1, 2);
            }
        $this->venue = $venue;
        $this->vacancies = $vacancies;
        $this->persons = $persons;
        $this->removed_persons = $removed_persons;
        $this->day = date("D", mktime(0, 0, 0, substr($this->mm_dd_yy, 0, 2), substr($this->mm_dd_yy, 3, 2), "20" . substr($this->mm_dd_yy, 6, 2)));
        $this->id = $id;
        $this->notes = $notes;	
    }

    /**
     * This function (re)sets the start and end times for a project
     * and corrects its $id accordingly
     * Precondition:  0 <= $st && $st < $et && $et < 24
     * Postcondition: $this->start_time == $st && $this->end_time == $et
     *          && $this->id == $this->mm_dd_yy .  "-"
     *          . $this->start_time . "-" . $this->end_time . $this->venue
     *          && $this->name == substr($this->id, 9)
     */
    function set_start_end_time($st, $et) {
        if (0 <= $st && $st < $et && $et < 24 &&
                strpos(substr($this->id, 9), "-") !== false) {
            $this->start_time = $st;
            $this->end_time = $et;
            $this->id = $this->mm_dd_yy . "-" . $this->start_time
                    . "-" . $this->end_time;
            $this->name = substr($this->id, 9);
            return $this;
        }
        else
            return false;
    }

    /*
     * @return the number of vacancies in this project.
     */

    function num_vacancies() {
        return $this->vacancies;
    }

    function ignore_vacancy() {
        if ($this->vacancies > 0)
            --$this->vacancies;
    }

    function add_vacancy() {
        ++$this->vacancies;
    }

    function num_slots() {
        if (!$this->persons[0])
            array_project($this->persons);
        return $this->vacancies + count($this->persons);
    }

    /*
     * getters and setters
     */
    function get_mm_dd_yy() {
    	return $this->mm_dd_yy;
    }

    function get_name() {
        return $this->name;
    }

    function get_start_time() {
        return $this->start_time;
    }

    function get_end_time() {
        return $this->end_time;
    }
    
    
    function get_date() {
        return $this->mm_dd_yy;
    }
    
    function get_time_of_day() {
        if ($this->start_time == 0)
            return "overnight";
        else if ($this->start_time <= 10)
            return "morning";
        else if ($this->start_time <= 13)
            return "earlypm";
        else if ($this->start_time <= 16)
            return "latepm";
        else 
            return "evening";
    }
    
    function get_venue() {
        return $this->venue;
    }

    function get_persons() {
        return $this->persons;
    }
    
    function get_removed_persons() {
    	return $this->removed_persons;
    }

    function get_id() {
        return $this->id;
    }

    function get_day() {
        return $this->day;
    }

    function get_notes() {
        return $this->notes;
    }

    function get_vacancies() {
    	return $this->vacancies;
    }
    
    
    function set_notes($notes) {
        $this->notes = $notes;
    }
    
    function assign_persons($p) {
    	foreach ($this->persons as $person) {
    		if (!in_array($person, $p)) {
    			error_log("adding ".$person." to removed persons");
    			$this->removed_persons[] = $person;
    		}
    	}
        $this->persons = $p;
    }
    
    function duration () {
    	if ($this->end_time == 1 && $this->start_time == 0) {
    		
    		return 12;
    	} else return $this->end_time - $this->start_time;
    }
    
}

function report_projects_staffed_vacant($from, $to) {
	$min_date = "01/01/2000";
	$max_date = "12/31/2020";
	if ($from == '') $from = $min_date;
	if ($to == '') $to = $max_date;
	error_log("from date = " . $from);
	error_log("to date = ". $to);
	$from_date = date_create_from_mm_dd_yyyy($from);
	$to_date   = date_create_from_mm_dd_yyyy($to);
	$reports = array(
		'morning' => array('Mon' => array(0, 0), 'Tue' => array(0, 0), 'Wed' => array(0, 0), 'Thu' => array(0, 0),
    				'Fri' => array(0, 0), 'Sat' => array(0, 0), 'Sun' => array(0, 0)), 
		'earlypm' => array('Mon' => array(0, 0), 'Tue' => array(0, 0), 'Wed' => array(0, 0), 'Thu' => array(0, 0),
    				'Fri' => array(0, 0), 'Sat' => array(0, 0), 'Sun' => array(0, 0)),
		'latepm' => array('Mon' => array(0, 0), 'Tue' => array(0, 0), 'Wed' => array(0, 0), 'Thu' => array(0, 0),
    				'Fri' => array(0, 0), 'Sat' => array(0, 0), 'Sun' => array(0, 0)),
		'evening' => array('Mon' => array(0, 0), 'Tue' => array(0, 0), 'Wed' => array(0, 0), 'Thu' => array(0, 0),
    				'Fri' => array(0, 0), 'Sat' => array(0, 0), 'Sun' => array(0, 0)),
		'overnight' => array('Mon' => array(0, 0), 'Tue' => array(0, 0), 'Wed' => array(0, 0), 'Thu' => array(0, 0),
    				'Fri' => array(0, 0), 'Sat' => array(0, 0), 'Sun' => array(0, 0)),
		'total' => array('Mon' => array(0, 0), 'Tue' => array(0, 0), 'Wed' => array(0, 0), 'Thu' => array(0, 0),
    				'Fri' => array(0, 0), 'Sat' => array(0, 0), 'Sun' => array(0, 0)),
	);
	$all_projects = get_all_projects();
	foreach ($all_projects as $s) {
		$projects_date = date_create_from_mm_dd_yyyy($s->get_mm_dd_yy());
		if ($projects_date >= $from_date && $project_date <= $to_date && 
		    (strlen($s->get_persons())>0 || $s->get_vacancies()>0)) {
		    $reports[$s->get_time_of_day()][$s->get_day()][0] += 1;
			$reports[$s->get_time_of_day()][$s->get_day()][1] += $s->get_vacancies();
			$reports['total'][$s->get_day()][0] += 1;
			$reports['total'][$s->get_day()][1] += $s->get_vacancies();
		}
	}
	return $reports;
}



?>

}
