<?php

include_once(dirname(__FILE__) . '/../database/dbProjects.php');
include_once(dirname(__FILE__) . '/../database/dbPersons.php');
include_once('reportsAjax.php');

/**
 * Description of Project
 *
 * @author Derek and Ka Ming
 */
class Project {
        private $mm_dd_yy;      // String: "mm-dd-yy".
        private $address;        //location of project
        private $project_type;
        private $name;
        private $start_time;    // Integer: e.g. 10 (meaning 10:00am)
        private $end_time;      // Integer: e.g. 13 (meaning 1:00pm)
        private $dayOfWeek;     // 3 letters, Mon, Tue, etc //This is the equivalent of day from shift.php - GIOVI
        private $vacancies;     // number of vacancies in this project
        private $persons;       // array of person ids filling slots, followed by their name, ie "malcom1234567890+Malcom+Jones"
        private $age;
        private $id;            // "mm-dd-yy-start_time-end_time-projName is the unique key
        private $project_description;         // notes written by the manager
    /*
     * construct an empty project with a certain number of vacancies
     */
        function __construct($date, $addr, $type, $name, $start_time, $end_time, $vacancies, $persons, $age, $notes) {
            $this->mm_dd_yy = str_replace("-", "/", $date); // Remember that '-' are for european dates (dd-mm-yyyy) and '/' are for american (mm/dd/yyy), the timestamp gets confused when we mix them up - GIOVI
            $this->name = str_replace(" ", "_", $name);
            $this->address = $addr;
            $this->project_type = $type;
            $this->start_time = $start_time;   // currently has to be integer - need to fix this
            $this->end_time = $end_time;     // currently has to be integer - need to fix this
            $this->vacancies = $vacancies;
            $this->persons = $persons;
            $this->age = $age;
            $this->dayOfWeek = date("D", mktime(0, 0, 0, substr($this->mm_dd_yy, 0, 2), substr($this->mm_dd_yy, 3, 2),
                                                "20" . substr($this->mm_dd_yy, 6, 2)));
            $this->id = str_replace("/", "-", $this->mm_dd_yy) . "-" . $start_time. "-" . $end_time . "-". $this->name;
            $this->project_description = $notes;
            //error_log("in project constructor, date is " . $this->mm_dd_yy);
            //error_log("in project constructor, addr is " . $addr);
            //error_log("in project constructor, name is " . $name);
            //error_log("in project constructor, start time is " . $this->start_time);
            //error_log("in project constructor, end time is " . $this->end_time);
            //error_log("in project constructor, day of week is " . $this->dayOfWeek);
            //error_log("in project constructor, vacancies is " . $this->vacancies);
            //error_log("in project constructor, id is " . $this->id);
            //error_log("in project constructor, notes is " . $notes);
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
        // The user's input is valid if all of the following is true
        $isValid = $st >= 0 && // Start-time is within bounds, and
                $st < $et && // Start-time is before end-time, and
                $et < 24 && // End-time is within bounds, and
                strpos(substr($this->id, 9), "-") !== false // There is a hyphen within the string (excluding the first 9 characters)
        ;

        // If the validity-test above failed, we will return false and exit this method
        if (!$isValid)
            return false;

        // If the validity-test above succeeded, we will continue and process the user's input
        $this->start_time = $st;
        $this->end_time = $et;
        $this->id = $this->mm_dd_yy . "-" . $this->start_time
                . "-" . $this->end_time;
        $this->name = substr($this->id, 9);

        return $this;
    }

    /*
     * @return the number of vacancies in this project.
     */

    function num_vacancies() {
        return $this->vacancies;
    }

    function ignore_vacancy() {
        if ($this->vacancies > 0) {
            --$this->vacancies;
        }
    }

    function add_vacancy() {
        ++$this->vacancies;
    }

    function num_slots() {
        if (!$this->persons[0]) {
            array_project($this->persons);
        }

        return $this->vacancies + count($this->persons);
    }
        function get_type() {
            return $this->project_type;
        }
        
          function get_age() {
            return $this->age;
        }

    /*
     * getters and setters
     */

    function get_dayOfWeek() {
        return $this->dayOfWeek;
    }

    function get_mm_dd_yy() {
        return $this->mm_dd_yy;
    }

    function get_name() {
        
        $spacednames = str_replace('_', ' ', $this->name);
        return $spacednames;
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

    function get_address() {
        return $this->address;
    }

    function get_time_of_day() {
        if ($this->start_time == 0) {
            return "overnight";
        } else {
            if ($this->start_time <= 10) {
                return "morning";
            } else {
                if ($this->start_time <= 13) {
                    return "earlypm";
                } else {
                    if ($this->start_time <= 16) {
                        return "latepm";
                    } else {
                        return "evening";
                    }
                }
            }
        }
    }
        function get_num_of_persons() 
        {
            $peoparr = explode('*', $this->persons);
            $numberofpeople = count($peoparr);
            return $numberofpeople;
        }

    function get_persons() {
        return $this->persons;
    }

    function get_id() {
        return $this->id;
    }

    //function get_day() {
    //     return $this->day;
    //}

    function get_project_description() {
        return $this->project_description;
    }


        function get_remaining_vacancies($id) //This returns the remaining vacancies a project has depending on how many people are already part of it - GIOVI
        {
            error_log("The id is " . $id);
            $proj = select_dbProjects($id);
            $peoparr = $proj->get_persons();
            $numofpeople = count($peoparr);
 
            $vacancies = $proj->get_vacancies() - $numofpeople;
            
            error_log("The remaining number of vacancies is $vacancies ----------------------------------------");
            
            return $vacancies;
        }

    function get_vacancies() {
        return $this->vacancies;
    }

        function set_notes($notes) {
            $this->project_description = $notes;
        }
        
    function assign_persons($p) {
        foreach ($this->persons as $person) {
            if (!in_array($person, $p)) {
                error_log("adding " . $person . " to removed persons");
                $this->removed_persons[] = $person;
            }
        }
        $this->persons = $p;
    }

    function duration() {
        $time = [0, 0];
        $st = ConvertTimeToHrMin($this->start_time);
        $et = ConvertTimeToHrMin($this->end_time);
           
        if ($st[0] > $et[0]) //If start time is greater than end time, the result will be negative so add to 24 - GIOVI
        {
            $diff = $et[0] - $st[0];
            $time[0] = 24 + $diff;
        }
        
        if ($st[0] <= $et[0]) //If start time is less, then subtract as normal - GIOVI
        {
            $time[0] = $et[0] - $st[0];
        }
        
        if ($st[1] > $et[1]) //These are for minutes - GIOVI
        {
            $diff = $et[1] - $st[1];
            $time[1] = 60 + $diff;
            --$time[0];
        }
        
        if ($st[1] <= $et[1]) //These are for minutes - GIOVI
        {
            $time[1] = $et[1] - $st[1];
        }
        
            $padtime[0] = str_pad($time[0], 2, 0, STR_PAD_LEFT); //These are to ensure the time will be 4 digits (00:00) - GIOVI
            $padtime[1] = str_pad($time[1], 2, 0, STR_PAD_LEFT);
            
            $dur = implode('', $padtime);

                return $dur;
            
    }

}

function report_projects_staffed_vacant($from, $to) { 
    $from_date = setFromDate($from);
    $to_date = setToDate($to);

        $reports = [];
        $all_projects = get_all_projects();
        $count = 0;
        
        foreach ($all_projects as $p) 
       {
            $projects_date = date_create_from_mm_dd_yyyy($p->get_mm_dd_yy());
            
            if ($projects_date >= $from_date && $projects_date <= $to_date && $p->get_vacancies() != 0) //&& (strlen($p->get_persons()) > 0 || $p->get_vacancies() > 0) Was removed; Its here in case its needed - GIOVI
            {
                if (!isset($reports[$p->get_id()][0])) { $reports[$p->get_id()][0] = NULL; }
                
                error_log("Getting the number of remaining vacancies--------------------------------------------");


                $reports[$p->get_id()][0] += $p->get_remaining_vacancies($p->get_id());
                $count++;
            }
        }

        error_log("------- " . $count . " vacancy(ies) recorded-----------");       
        return $reports;
}

function check_Age($perAge){
    $from = new DateTime($perAge);
    $to   = new DateTime('today');
    $interval = $from->diff($to);
    $diffInYears = $interval->format('%y'); 
    return $diffInYears;
    }

?>
