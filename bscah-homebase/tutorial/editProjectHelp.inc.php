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

<p>
	<strong>How to Edit Project Information</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>Projects.</B>
</p>
<p>
	<B>Step 2:</B> This is the form where you enter the volunteer's information such as name, phone, 
        address, their shifts, etc.<BR> <BR> <a
		href="tutorial/screenshots/AddProject.png" class="image"
		title="AddProject.png"
		target="tutorial/screenshots/AddProject.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/AddProject.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/AddProject.png"
		border="1px" align="middle"> </a>
</p>
