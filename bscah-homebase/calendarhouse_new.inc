<?php
/**
 * @author Kevin Most
 * @version 2014-12-01
 * The new frontend support for the Weekly Calendar
 */
session_start();
session_cache_expire(30);
?>

<?php



///**
// * @param Week $week The current week
// * @param $edit boolean that decides whether we are going to set the edit flag
// * @param $venue string might not even be needed anymore
// */
//function do_week_nav2(Week $week, $edit, $venue) {
//    $nav_display_elements = [];
//
//    $id_format = "m-d-y";
//
//    $this_week_id = $week->get_id();
//
//    $this_week = DateTime::createFromFormat($id_format, $this_week_id);
//
//    $prev_week_id = $this_week->modify("-1 week")->format($id_format);
//    $next_week_id = $this_week->modify("+2 weeks")->format($id_format); // We have to add 2 weeks because the last modify we did was persisted
//
//
//
//    $prev_week_html = get_week_html($prev_week_id, $edit, $venue, "<< Previous Week");
//    $next_week_html = get_week_html($next_week_id, $edit, $venue, "Next Week >>");
//
//    if (!empty($prev_week_html)) {
//        $nav_display_elements[] = $prev_week_html;
//    }
//
//
//    $edit_or_view_html = get_edit_or_view_html($this_week_id, $edit, $venue);
//
//    if (!empty($edit_or_view_html)) {
//        $nav_display_elements[] = $edit_or_view_html;
//    }
//
//    if ($_SESSION['access_level'] >= 2) {
//        $nav_display_elements[] = "<a href='addWeek.php'>(manage weeks)</a>";
//    }
//
//    // Add "next week" after all others so things stay in our desired order
//    if (!empty($next_week_html)) {
//        $nav_display_elements[] = $next_week_html;
//    }
//
//
//    $full_width = 80;
//    $left_right_margins = (100 - $full_width)/2;
//
//    $each_span_width = $full_width/count($nav_display_elements);
//
//    $result = "<div style='width:$full_width%;margin-left:$left_right_margins%' id='row_container'>";
//
//    foreach($nav_display_elements as $element) {
//        $result .= "<div style='display:inline-block;width:$each_span_width%'>" . $element . "</div>";
//    }
//
//    $result .= "</div>";
//
//    echo $result;
//}
//
//
//function get_edit_or_view_html($id, $edit, $venue) {
//
//    if ($_SESSION['access_level'] < 1) {
//        return "";
//    }
//
//    $query_string = http_build_query([
//        'id' => $id,
//        'venue' => $venue,
//        'edit' => (($edit) ? 'false' : 'true'), // Note that here, we are using the opposite of the current edit value because this is a "toggle" option
//    ]);
//
//    $url = "calendar_new.php?" . $query_string;
//
//    if ($edit) {
//        $link_text = "(view this week)";
//    } else {
//        $link_text = "(edit this week)";
//    }
//
//    return "<a href='$url'>$link_text</a>";
//}
//
//
//function get_week_html($id, $edit, $venue, $link_text) {
//    $week = get_dbWeeks($id);
//
//    if (!$week instanceof Week) {
//        return "";
//    }
//
//    $query_string = http_build_query([
//        'id' => $id,
//        'edit' => (($edit) ? 'true' : 'false'),
//        'venue' => $venue,
//    ]);
//
//    $url = "calendar_new.php?" . $query_string;
//
//    return "<a href='$url' id='weeknavlink'>$link_text</a>";
//}

/**
 * @return string A JSON representation of the Week's shifts
 */
function get_fullcalendar_json() {
    // In PHP, you can create a JSON from an array of associative arrays.
    // We will iterate over every shift in this week and add each shift as a new associative array
    $json_builder = [];

    // For each shift in each day in each week, create a JSON element
    foreach(get_all_published_dbWeeks() as $week) {
        foreach ($week->get_dates() as $day) {
            foreach ($day->get_shifts() as $shift) {
                // Please check the FullCalendar.io documentation to learn what fields to put here
                // http://fullcalendar.io/docs/event_data/Event_Object/
                $json_element = [
                    'title' => generate_title($shift), // TODO: This should probably be a real, descriptive name, but our shifts don't actually have names yet
                    'allDay' => false,
                    'start' => shift_times_to_iso8601($shift, true),
                    'end' => shift_times_to_iso8601($shift, false),
                    'url' => "#", // We just want this to be clickable, JS will handle the actual onclick process
                    'color' => get_color($shift),

                    // We can also add elements to the JSON that just come along for the ride.
                    // 'persons' and 'vacancies' are not parts of the FullCalendar API, but they are useful because
                    // we can reference them later from the callbacks available to us in the fullCalendar() method
                    'persons' => $shift->get_persons(),
                    'vacancies' => $shift->get_vacancies()
                ];

                $json_builder[] = $json_element;
            }
        }
    }

    return json_encode($json_builder);
}


/**
 * @return string A title that is descriptive enough to identify this Shift object
 */
function generate_title(Shift $shift) {
    return $shift->get_venue() . " (" . count($shift->get_persons()) . " of " . $shift->get_total_slots() . " slots occupied)";
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
function get_color(Shift $shift) {

    $number_of_people_in_shift = count($shift->get_persons());
    $total_slots_in_shift = $shift->get_vacancies() + $number_of_people_in_shift;

    // Shift is totally full
    if ($total_slots_in_shift == $number_of_people_in_shift) {
        return "red";
    }

    $fullness_of_shift = $number_of_people_in_shift / $total_slots_in_shift;

    // Shift is mostly full
    if ($fullness_of_shift >= 0.5) {
        return "yellow";
    }

    // Shift is mostly empty
    return "green";
}
?>