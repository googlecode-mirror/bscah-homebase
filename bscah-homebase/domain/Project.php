<?php

    include_once(dirname(__FILE__) . '/../database/dbProjects.php');
    include_once(dirname(__FILE__) . '/../database/dbPersons.php');

    /**
     * Description of Project
     *
     * @author Derek and Ka Ming
     */
    class Project {
        private $mm_dd_yy;      // String: "mm-dd-yy".
        private $address;        //location of project
        private $project_type;
        private $name;          // String: 'ss-ee' or 'overnight', where ss = start time and ee = end time e.g., '9-12'
        private $start_time;    // Integer: e.g. 10 (meaning 10:00am)
        private $end_time;      // Integer: e.g. 13 (meaning 1:00pm)
        private $dayOfWeek;     // 3 letters, Mon, Tue, etc //This is the equivalent of day from shift.php - GIOVI
        private $vacancies;     // number of vacancies in this project
        private $persons;       // array of person ids filling slots, followed by their name, ie "malcom1234567890+Malcom+Jones"
        private $age;
        private $id;            // "mm-dd-yy-projName is the unique key
        private $project_description;         // notes written by the manager

        /*
         * construct an empty project with a certain number of vacancies
         */

        function __construct($date, $addr,$type, $name, $start_time, $end_time, $vacancies, $persons, $age,
        $notes) {
            $this->mm_dd_yy = str_replace("/", "-", $date);
            $this->name = $name;
            $this->address = $addr;
            $this->project_type = $type;
            $this->start_time = $start_time;   // currently has to be integer - need to fix this
            $this->end_time = $end_time;     // currently has to be integer - need to fix this
            $this->vacancies = $vacancies;
            $this->persons = $persons;
            $this->age = $age;
            $this->dayOfWeek = date("D", mktime(0, 0, 0, substr($this->mm_dd_yy, 0, 2), substr($this->mm_dd_yy, 3, 2),
                                                "20" . substr($this->mm_dd_yy, 6, 2)));
            $this->id = $date . "-" . $start_time. "-" . $end_time . "-". $name;
            $this->project_description = $notes;
            error_log("in project constructor, date is " . $this->mm_dd_yy);
            error_log("in project constructor, addr is " . $addr);
            error_log("in project constructor, name is " . $name);
            error_log("in project constructor, start time is " . $this->start_time);
            error_log("in project constructor, end time is " . $this->end_time);
            error_log("in project constructor, day of week is " . $this->dayOfWeek);
            error_log("in project constructor, vacancies is " . $this->vacancies);
            error_log("in project constructor, id is " . $this->id);
            error_log("in project constructor, notes is " . $notes);
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
            $isValid =
                $st >= 0 && // Start-time is within bounds, and
                $st < $et && // Start-time is before end-time, and
                $et < 24 && // End-time is within bounds, and
                strpos(substr($this->id, 9), "-") !== false // There is a hyphen within the string (excluding the first 9 characters)
            ;

            // If the validity-test above failed, we will return false and exit this method
            if (!$isValid) return false;

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

        /*
         * getters and setters
         */
        function get_dayOfWeek() {
            return $this->dayOfWeek;
        }
        function get_type() {
            return $this->project_type;
        }
        
          function get_age() {
            return $this->age;
        }

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

        function get_address() {
            return $this->address;
        }

        function get_time_of_day() {
            if ($this->start_time == 0) {
                return "overnight";
            }
            else {
                if ($this->start_time <= 10) {
                    return "morning";
                }
                else {
                    if ($this->start_time <= 13) {
                        return "earlypm";
                    }
                    else {
                        if ($this->start_time <= 16) {
                            return "latepm";
                        }
                        else {
                            return "evening";
                        }
                    }
                }
            }
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
            if ($this->end_time == 1 && $this->start_time == 0) {

                return 12;
            }
            else {
                return $this->end_time - $this->start_time;
            }
        }

    }

    function report_projects_staffed_vacant($from, $to) {
        $min_date = "01/01/2000";
        $max_date = "12/31/2020";
        if ($from == '') {
            $from = $min_date;
        }
        if ($to == '') {
            $to = $max_date;
        }
        error_log("from date = " . $from);
        error_log("to date = " . $to);
        $from_date = date_create_from_mm_dd_yyyy($from);
        $to_date = date_create_from_mm_dd_yyyy($to);

        $reports = [
            'morning' => ['Mon' => [0], 'Tue' => [0], 'Wed' => [0], 'Thu' => [0],
                'Fri' => [0], 'Sat' => [0], 'Sun' => [0]],
            'earlypm' => ['Mon' => [0], 'Tue' => [0], 'Wed' => [0], 'Thu' => [0],
                'Fri' => [0], 'Sat' => [0], 'Sun' => [0]],
            'latepm' => ['Mon' => [0], 'Tue' => [0], 'Wed' => [0], 'Thu' => [0],
                'Fri' => [0], 'Sat' => [0], 'Sun' => [0]],
            'evening' => ['Mon' => [0], 'Tue' => [0], 'Wed' => [0], 'Thu' => [0],
                'Fri' => [0], 'Sat' => [0], 'Sun' => [0]],
            'overnight' => ['Mon' => [0], 'Tue' => [0], 'Wed' => [0], 'Thu' => [0],
                'Fri' => [0], 'Sat' => [0], 'Sun' => [0]],
            'total' => ['Mon' => [0], 'Tue' => [0], 'Wed' => [0], 'Thu' => [0],
                'Fri' => [0], 'Sat' => [0], 'Sun' => [0]],
        ];
        $all_projects = get_all_projects();
        foreach ($all_projects as $s) {
            $projects_date = date_create_from_mm_dd_yyyy($s->get_mm_dd_yy());
            if ($projects_date >= $from_date && $projects_date <= $to_date &&
                (strlen($s->get_persons()) > 0 || $s->get_vacancies() > 0)
            ) {
                
                $reports[$s->get_time_of_day()][$s->get_dayOfWeek()][0] += $s->get_vacancies();

                $reports['total'][$s->get_dayOfWeek()][0] += $s->get_vacancies();
            }
        }

        return $reports;
    }


?>
