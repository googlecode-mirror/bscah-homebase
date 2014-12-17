<?php
    /**
     * @author Matthew Freitas
     * @version 2014-12-15
     * The new frontend support for the Master Calendar
     */
    session_start();
    session_cache_expire(30);
    include_once("database/dbMasterSchedule.php")
?>

<?php
    /**
     * @return string A JSON representation of the Week's shifts
     */
    function get_fullcalendar_json($venue) {
        // In PHP, you can create a JSON from an array of associative arrays.
        // We will iterate over every shift in this week and add each shift as a new associative array
        $json_builder = [];
        $week_days = ["Sun" => "Sunday", "Mon" => "Monday", "Tue" => "Tuesday", "Wed" => "Wednesday",
            "Thu" => "Thursday", "Fri" => "Friday", "Sat" => "Saturday"];
        // For each shift in each day in each week, create a JSON element
        foreach($week_days as $day=>$fullday) {
            foreach (get_master_shifts($venue, $day) as $shift) {
                if($shift === null){
                    continue;
                }
                // Please check the FullCalendar.io documentation to learn what fields to put here
                // http://fullcalendar.io/docs/event_data/Event_Object/
                $json_element = [
                    'title' => generate_title($shift),
                    'start' => shift_times_to_iso8601($shift, true),
                    'end' => shift_times_to_iso8601($shift, false),
                ];

                $json_builder[] = $json_element;
                error_log(shift_times_to_iso8601($shift, true));
                error_log(shift_times_to_iso8601($shift, false));
            }
        }

        error_log(implode(" ", $json_builder));
        return json_encode($json_builder);
    }


    /**
     * @return string A title that is descriptive enough to identify this Shift object
     */
    function generate_title(MasterScheduleEntry $shift) {
        return $shift->get_Shifts();
    }

    /**
     * Fullcalendar.io strongly recommends that times are specified in ISO8601 format.
     * Our date and time objects are highly inconsistent. This method attempts to make sense of them.
     * @param Shift $shift The shift object to get the dates for
     * @param bool $startTime If true, will return the start time. If false, will return the end time
     * @return string ISO8601-formatted string, or null if parsing failed at any point
     */
    function shift_times_to_iso8601(MasterScheduleEntry $shift, $startTime) {

        $day = $shift->get_day();

        $date = getDay($day)->format("m-d-y");

        $date_format = "m-d-y H:i";

        // If we are dealing with an overnight shift, make sure you return either 9PM for the start-time or 10PM for the end-time
        if ($shift->get_time() === "overnight") {
            return DateTime::createFromFormat(
                $date_format,
                $date .' '. ($startTime ? "21:00" : "22:00")
            )->format("c"); // Formats in ISO8601
        }

        $time = ($startTime ? $shift->get_start_time() : $shift->get_end_time());


        // TODO: This is pretty janky, and makes some assumptions about what the contents of strings are based on just their length.
        // But coming up with a more robust solution might not be a priority right now since this will keep working until we change date-formats in the DB
        switch (strlen($time)) {
            case 1:
                // Turns "9" into "09:00"
                $formatted_time = "0" . $time . ":00";
                break;
            case 2:
                // Turns "13" into "13:00"
                $formatted_time = $time . ":00";
                break;
            case 3:
                // Turns "900" into "09:00"
                $formatted_time = implode(":",str_split("0".$time,2));;
                break;
            case 4:
                // Turns "1300" into "13:00"
                $formatted_time = implode(":",str_split($time,2));
                break;
            case 5:
                $formatted_time = $time;
                break;
            default:
                return null;
        }

        return DateTime::createFromFormat(
            $date_format,
            $date.' '.$formatted_time
        )->format("c");
    }

    /**
     * http://stackoverflow.com/questions/1431631/get-date-for-monday-and-friday-for-the-current-week-php
     * @param String $day
     * @return DateTime
     */
    function getDay($day)
    {
        $days = ['Sun' => 0, 'Mon' => 1, 'Tue' => 2, 'Wed' => 3, 'Thu' => 4, 'Fri' => 5, 'Sat' => 6];

        $today = new \DateTime();
        $today->setISODate($today->format('o'), $today->format('W'), $days[ucfirst($day)]);
        return $today;
    }
?>
