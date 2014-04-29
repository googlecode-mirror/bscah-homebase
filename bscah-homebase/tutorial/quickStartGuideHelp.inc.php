<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan,
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker.
 * This program is part of RMH Homebase, which is free software.  It comes with
 * absolutely no warranty. You can redistribute and/or modify it under the terms
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 */
?>

<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script
	src="lib/bootstrap/js/bootstrap.js"></script>

<script>
	$(function () {
		$('img[rel=popover]').popover({
			  html: true,
			  trigger: 'hover',
			  placement: 'right',
			  content: function(){return '<img border="3" src="'+$(this).data('img') + '" width="60%"/>';}
			});
	});
</script>

<body>
	<div align="left">
		<p>
		
		
		<h1>Signing in and out of the System</h1>


		<p>Access to BSCAH's Homebase requires a Username and a Password. The form
			looks like this:
		
		
		<p>
		
		
		<table align="center">
			<tr>
				<td>Username:</td>
				<td><input type="text" name="user" tabindex="1"></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="password" name="pass" tabindex="2"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" name="Login"
					value="Login"></td>
			</tr>
		</table>
		<p>
			If you are a <i>new applicant</i>, you can sign in with the Username
			<strong>guest</strong> and no Password. Once you sign in you will be
			able to fill out and submit an application form on-line.
		
		
		<p>
			If you are a <i>volunteer or staff member</i>, your Username is your
			first name followed by your phone number with no spaces.
		
		
		<ul>
			<li>For example, if your first name is John and your phone number is
				(207)-123-4567, your Username would be <strong>John2071234567</strong>.







			
			
			<li>Remember that your Username and Password are <em>case-sensitive</em>.
				</p>
		
		</ul>
		<p>
			Remember to <strong>logout</strong> when you are finished using
			Homebase. <br> <br> <br> <br>
		
		
		<p>
		
		<h1>Adding/Removing a Volunteer from a Shift</h1>


		<p>
			To begin, you must have already selected <strong>(edit this week)</strong>
			at the top of the calendar:
		
		
		<p>
			<B>First:</B> Click on an editable calendar shift.
		
		
		<p>
			<B>Removing a Volunteer from a Shift:</B> If a slot already has a
			volunteer, there will be a <b>Remove Person</b> button that looks
			like this: <BR> <BR> <a
				href="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png"
				class="image" title="addPersonToShiftHelp_removing_volunteer.png"
				horizontalalign="center"
				target="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png">
				&nbsp&nbsp&nbsp&nbsp<img
				src="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png"
				width="30%"
				data-img="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png"
				border="1px" align="center"> </a> <br> <br> Click that <b>Remove
				Person</b> button to remove that volunteer from that shift's slot,
			leaving an empty slot.
		
		
		<p>
			<B>Adding a Volunteer to a Shift:</B> If a slot doesn't have a
			volunteer yet (or you just removed a volunteer from that slot), there
			will be two buttons: <b>Assign Volunteer</b> and <b>Remove Vacancy</b>.
			<BR> <BR> <a
				href="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png"
				class="image" title="addPersonToShiftHelp_assign_volunteer.png"
				horizontalalign="center"
				target="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png">
				&nbsp&nbsp&nbsp&nbsp<img
				src="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png"
				width="30%"
				data-img="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png"
				border="1px" align="center"> </a> <br> <br> Click the <b>Assign
				Volunteer</b> button to come to a page where you can choose a new
			volunteer: <br> <br> <a
				href="tutorial/screenshots/addPersonToShiftHelp_add_view.png"
				class="image" title="addPersonToShiftHelp_add_view.png"
				horizontalalign="center"
				target="tutorial/screenshots/addPersonToShiftHelp_add_view.png">
				&nbsp&nbsp&nbsp&nbsp<img
				src="tutorial/screenshots/addPersonToShiftHelp_add_view.png"
				width="40%"
				data-img="tutorial/screenshots/addPersonToShiftHelp_add_view.png"
				border="1px" align="center"> </a> <br> <br> Select a Volunteer using
			the drop down lists. The first list contains volunteers who have
			listed that time as available, the second list contains every
			volunteer. Once you've chosen a volunteer, click the <b>Add Volunteer</b>
			button: <br> <br> <a
				href="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png"
				class="image" title="addPersonToShiftHelp_add_view_volunteer.png"
				horizontalalign="center"
				target="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png">
				&nbsp&nbsp&nbsp&nbsp<img
				src="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png"
				width="40%"
				data-img="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png"
				border="1px" align="center"> </a> <br> <br> This brings you back to
			the shift form, and the selected volunteer will be displayed. <br> <br>
			<br> <br>
		
		
		<p>
		
		
		<h1>How to Add Notes</h1>


		<p>Managers can record notes on any shift that will be read by all
			volunteers viewing the calendar. Managers may also enter a note for
			an entire day at the bottom of that day on the calendar.
		
		
		<p>
			To begin, you must have already selected <strong>(edit this week)</strong>
			at the top of the calendar.
		
		
		<p>
			<B>Step 1:</B> At the bottom of each shift there's a place to enter
			notes for that shift. <BR> <BR> <a
				href="tutorial/screenshots/calendarNotesHelp_note_slots.png"
				class="image" title="calendarNotesHelp_note_slots.png"
				horizontalalign="center"
				target="tutorial/screenshots/calendarNotesHelp_note_slots.png">
				&nbsp&nbsp&nbsp&nbsp<img
				src="tutorial/screenshots/calendarNotesHelp_note_slots.png"
				width="55%"
				data-img="tutorial/screenshots/calendarNotesHelp_note_slots.png"
				border="1px" align="center"> </a>
		
		
		<p>
			<B>Step 2:</B> Below all the shifts, there is an additional row
			marked "manager notes".<BR> <BR> <a
				href="tutorial/screenshots/calendarNotesHelp_manager_notes.png"
				class="image" title="calendarNotesHelp_manager_notes.png"
				horizontalalign="center"
				target="tutorial/screenshots/calendarNotesHelp_manager_notes.png">
				&nbsp&nbsp&nbsp&nbsp<img
				src="tutorial/screenshots/calendarNotesHelp_manager_notes.png"
				width="55%"
				data-img="tutorial/screenshots/calendarNotesHelp_manager_notes.png"
				border="1px" align="center"> </a>
		
		
		<p>
			<B>Step 3:</B> Once you have entered the notes, scroll down to the
			bottom of the calendar and click the button <strong>Save changes to
				all notes</strong>, like this:<BR> <BR> <a
				href="tutorial/screenshots/calendarNotesHelp_save_notes.png"
				class="image" title="calendarNotesHelp_save_notes.png"
				target="tutorial/screenshots/calendarNotesHelp_save_notes.png">
				&nbsp&nbsp&nbsp&nbsp<img
				src="tutorial/screenshots/calendarNotesHelp_save_notes.png"
				width="55%"
				data-img="tutorial/screenshots/calendarNotesHelp_save_notes.png"
				border="1px" align="middle"> </a>
		
		
		<p>The notes you entered will now appear whenever someone views that
			week on the calendar.

</body>
</html>



