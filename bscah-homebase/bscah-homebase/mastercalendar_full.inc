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
    function get_fullcalendar_json() {
        // In PHP, you can create a JSON from an array of associative arrays.
        // We will iterate over every shift in this week and add each shift as a new associative array
        $json_builder = [];
        $week_days = ["Sun" => "Sunday", "Mon" => "Monday", "Tue" => "Tuesday", "Wed" => "Wednesday",
            "Thu" => "Thursday", "Fri" => "Friday", "Sat" => "Saturday"];
        // For each shift in each day in each week, create a JSON element
        foreach($week_days as $day) {
            foreach (get_master_shifts($venue, $day) as $shift) {
                // Please check the FullCalendar.io documentation to learn what fields to put here
                // http://fullcalendar.io/docs/event_data/Event_Object/
                $json_element = [
                    'title' => generate_title($shift), // TODO: This should probably be a real, descriptive name, but our shifts don't actually have names yet
                    'allDay' => false,
                    'start' => shift_times_to_iso8601($shift, true),
                    'end' => shift_times_to_iso8601($shift, false),
                    'url' => "#", // We just want this to be clickable, JS will handle the actual onclick process
                    'color' => get_color($shift),
                    'borderColor' => get_border_color($shift),
                    // We can also add elements to the JSON that just come along for the ride.
                    // 'persons' and 'vacancies' are not parts of the FullCalendar API, but they are useful because
                    // we can reference them later from the callbacks available to us in the fullCalendar() method
                    'persons' => $shift->get_persons(),
                    'vacancies' => $shift->get_vacancies()
                ];

                $json_builder[] = $json_element;
            }
        }

        return json_encode($json_builder);
    }


    /**
     * @return string A title that is descriptive enough to identify this Shift object
     */
    function generate_title(Shift $shift) {
        return $shift->get_name() . " (" . count($shift->get_persons()) . " of " . $shift->get_total_slots() . " slots occupied)";
    }

    /**
     * Fullcalendar.io strongly recommends that times are specified in ISO8601 format.
     * Our date and time objects are highly inconsistent. This method attempts to make sense of them.
     * @param Shift $shift The shift object to get the dates for
     * @param bool $startTime If true, will return the start time. If false, will return the end time
     * @return string ISO8601-formatted string, or null if parsing failed at any point
     */
    function shift_times_to_iso8601(Shift $shift, $startTime) {

        $date = str_replace("/", "-", $shift->get_date());

        $date_format = "m-d-y H:i";

        // If we are dealing with an overnight shift, make sure you return either 9PM for the start-time or 10PM for the end-time
        if ($shift->get_time_of_day() === "Overnight") {
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
     * Calculates and returns what background color this event should have based on vacancy percentage
     * @param Shift $shift The shift to calculate a color for
     * @return string a CSS color code that represents how full this event is
     */
    function get_border_color(Shift $shift) {

        $number_of_people_in_shift = count($shift->get_persons());
        $total_slots_in_shift = $shift->get_vacancies() + $number_of_people_in_shift;

        // Shift is totally full
        if ($total_slots_in_shift == $number_of_people_in_shift) {
            return "#c0392b";
        }

        $fullness_of_shift = $number_of_people_in_shift / $total_slots_in_shift;

        // Shift is mostly full
        if ($fullness_of_shift >= 0.5) {
            return "#d35400";
        }

        // Shift is mostly empty
        return "#27ae60";
    }

    function get_color(Shift $shift){
        $venue = $shift->get_venue();

        if($venue === "garden") {
            return "#3498db";
        }
        else if($venue === "pantry") {
            return "#9b59b6";
        }
        else {
            return "";
        }
    }
?>
