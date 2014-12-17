<?php
    echo'<p><strong>Add New ' . ucfirst($_GET['frequency']) . ' Master Shift Form</strong></p>';
    echo'<p>You can add a new ' . $_GET['frequency'] . ' shift to the database. You can edit a shift by using this form with the shift\'s day and time</p>';
?>
<form method="GET" action="editMasterSchedule.php">
    <input type="hidden" name="_form_submit" value="1">

    <select name="day"> Day of week:
        <option value="Sun">Sunday</option>
        <option value="Mon">Monday</option>
        <option value="Tue">Tuesday</option>
        <option value="Wed">Wednesday</option>
        <option value="Thu">Thursday</option>
        <option value="Fri">Friday</option>
        <option value="Sat">Saturday</option>
    </select>
    at
    <select name="shift"> Shift Start:
        <option value="9-10">9 AM</option>
        <option value="10-11">10 AM</option>
        <option value="11-12">11 AM</option>
        <option value="12-13">12 PM</option>
        <option value="13-14">1 PM</option>
        <option value="14-15">2 PM</option>
        <option value="15-16">3 PM</option>
        <option value="16-17">4 PM</option>
        <option value="17-18">5 PM</option>
        <option value="18-19">6 PM</option>
        <option value="19-20">7 PM</option>
        <option value="20-21">8 PM</option>
        <option value="overnight">Overnight</option>
    </select>

    <input type="hidden" name="venue" value="<?php echo $_GET['frequency'];?>">

    <p>Hit <input type="submit" value="Submit" name="Submit Edits"> to manage this shift.<p>
</form>
<br>

    
