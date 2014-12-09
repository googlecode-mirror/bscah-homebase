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
?>

<!--suppress CssUnusedSymbol -->
<style>
    /* Color-code the different week statuses for readability */
    .archived {
        background-color: #CCCCCC;
        display: none;
    }
    .published {
        background-color: #2ECC71;
    }
    .unpublished {
        background-color: #E74C3C;
    }
    /* Highlight currently-active week of calendar in a more visible color */
    a.ui-state-active {
        background: #E74C3C !important;
    }
    /* Bold the current calendar date */
    a.ui-state-highlight {
        font-weight: bold !important;
    }
</style>

<script src="lib/jquery-1.9.1.js"></script>
<!-- Use jQuery UI for date-picker -->
<script src="lib/jquery-ui.js"></script>
<link rel="stylesheet" href="lib/jquery-ui.css" type="text/css"/>

<script type="text/javascript">
    $(function() {
        var startDate;
        var endDate;

        var selectCurrentWeek = function() {
            window.setTimeout(function () {
                $('.week-picker').find('.ui-datepicker-current-day a').addClass('ui-state-active')
            }, 1);
        };

        $('.week-picker').datepicker( {
            showOtherMonths: true,
            selectOtherMonths: true,
            onSelect: function(dateText, inst) {
                var date = $(this).datepicker('getDate');
                startDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay());
                endDate = new Date(date.getFullYear(), date.getMonth(), date.getDate() - date.getDay() + 6);
                var dateFormat = inst.settings.dateFormat || $.datepicker._defaults.dateFormat;
                $('#startDate').val($.datepicker.formatDate( dateFormat, startDate, inst.settings ));

                selectCurrentWeek();
            },
            beforeShowDay: function(date) {
                var cssClass = '';
                if(date >= startDate && date <= endDate)
                    cssClass = 'ui-datepicker-current-day';
                return [true, cssClass];
            },
            onChangeMonthYear: function () {
                selectCurrentWeek();
            }
        });
        var picker = '.week-picker .ui-datepicker-calendar tr';
        $(picker).live('mousemove', function() { $(this).find('td a').addClass('ui-state-hover'); });
        $(picker).live('mouseleave', function() { $(this).find('td a').removeClass('ui-state-hover'); });
    });

    /**
     * Provides functionality for the "Show/Hide Archived Weeks" button by toggling the visibility of those HTML elements
     */
    function toggleArchiveVisibility() {
        var $archiveHideShow = $('#archiveHideShow');

        if ($archiveHideShow.text() == "Show Archived Weeks") {
            $archiveHideShow.text("Hide Archived Weeks");
            $('.archived').show();
        } else {
            $archiveHideShow.text("Show Archived Weeks");
            $('.archived').hide();
        }
    }

    function validateForm() {
        return $("#startDate").val() !== "";
    }
</script>

<div class="nextWeekTable">
    <form method="POST" action="addWeek.php">
        <table border="1">
            <tr>
                <td>Weeks</td>
                <td>Status (options)</td>
            </tr>
            <?php print_existing_weeks(); ?>
        </table>
        <div class="week-picker" name="week-picker" id="week-picker"></div>
        <input type="hidden" value="" name="start_date" id="startDate">
        <input type="submit" value="Add new week" name="Add new week" onsubmit="return validateForm()">
    </form>
    <button onclick="toggleArchiveVisibility()" id="archiveHideShow">Show Archived Weeks</button>
</div>

<?php
    /**
     * Prints all existing weeks to the document. Will not print "unpublished" weeks if the user is not a manager.
     */
    function print_existing_weeks() {
        $result = get_all_dbWeeks();

        for ($i = 0; $i < sizeof($result); ++$i) {
            $week = $result[$i];

            $weekStatus = $week->get_status();
            $showThisWeek = true;
            if ($weekStatus == "unpublished" && $_SESSION['access_level'] < 2) {
                $showThisWeek = false;
            }

            if ($showThisWeek) {
                echo sprintf(
                    "<tr class=\"$weekStatus\">" .
                    '<td>%s</td>' .
                    '<td>%s</td>' .
                    '</tr>',
                    $week->get_name(),
                    show_week_options($week)
                );
            }
        }
    }


    /**
     * determines what options apply to each week
     * @param Week $week The week to show options for
     * @return string Preformatted data to be inserted into the table generated by {@link #print_existing_weeks}
     */
    function show_week_options(Week $week) {
        $id = $week->get_id();
        $status = $week->get_status();

        // Possible options that can be used in the options for this week.
        // Depending on what type of week it is, only some of these options will be used,
        $view = "<a href='calendar_new.php?id=$id'>view</a>";
        $remove = "<a href='addWeek.php?remove=$id'>remove</a>";
        $edit = "<a href='calendar_new.php?id=$id&edit=true'>edit</a>";
        $publish = "<a href='addWeek.php?publish=$id'>publish</a>";
        $unpublish = "<a href='addWeek.php?publish=$id'>unpublish</a>";


        if ($status == "archived") {
            return "$status ($view) ($remove)";
        } else if ($status == "published") {
            return "$status ($edit) ($unpublish) ($view) ($remove)";
        } else {
            return "$status ($edit) ($publish) ($view) ($remove)";
        }
    }
?>
