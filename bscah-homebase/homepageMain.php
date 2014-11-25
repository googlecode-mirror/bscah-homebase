<?php

/* 
 * homepageMain.php
 * This page is the first page a person seeking the BSCAH website will see and will serve as a portal
 * to the rest of the site.  
 * @author Rocco J. Sacramone
 * @version 10/15/2014 revised 10/29/2014
 * 
 */

    //session_start();
    //session_cache_expire(30);
?>

<html>

<!--<div id="container">-->
<?PHP //include('header.php'); ?>
   
<div id="content">
<?php
    //$_SESSION['access_level'] = 0;
?>
    
    <p><strong>BSCAH Background</strong><br/><br/>
            Hello and Welcome to the Bed-Stuy Campaign Against Hunger Homepage where we take a communities approach to caring!
        `   The BSCAH was founded in 1998 as a food pantry in a church basement and we have now grown over the years to be the largest food pantry in Brooklyn. 
            Our mission is to provide a well balanced diet to low-income and in need individuals. There are a multitude of ways for people to get involved
            with our organization. There are opportunities ranging from Pantry Volunteering to making PB&J Sandwiches.

        <br>    
        <p> If you are looking for more detailed information about different Volunteer opportunities, please visit our <strong><a href = "projectInfo.php">Project Information Page</a></strong>.
        </p>
     
        <p> If you are looking to sign up to be a volunteer, you can fill out a volunteer application <strong><a href="personEdit.php?id=new">here</a></strong>.
        </p>

        <p> If you are an existing or returning volunteer, please <strong><a href="login_form.php">login here</a></strong>.
        </p>
        
    <p><strong>Background</strong><br/><br/>

            <a href="http://code.google.com/p/rmh-homebase/">
                <i>Homebase</i></a> is a web-based volunteer management and scheduling system developed at <a
                href="http://www.bowdoin.edu/computer-science" target="_blank">
                Bowdoin College</a> for the <a href="http://www.rmhportland.org/" target="_blank">Ronald McDonald House
                in Portland, Maine</a>.
            It was first implemented in 2008 by four Bowdoin Students (Oliver Radwan, Maxwell Palmer, Nolan McNair, and
            Taylor Talmage) and
            a Bowdoin instructor (Allen Tucker). It was adapted in 2011 for the Ronald McDonald House in Wilmington,
            Delaware,
            and its functionality was extended in 2012 by three more Bowdoin students (Jackson Moniaga, Johnny Coster,
            and Judy Wang) and the instructor.
            More information about the <i>Homebase</i> project can be found at <a
                href="http://myopensoftware.org/content/software-projects" target="_blank">myopensoftware.org</a>
            and in articles published by
            <a href="http://pressherald.mainetoday.com/story.php?id=174400&ac" TARGET="_BLANK">the Portland Press
                Herald</a> and
            <a href="http://www.bowdoin.edu/news/archives/1bowdoincampus/005118.shtml" target="_BLANK"> Bowdoin
                College</a>.

        <p>The current version was developed by and the instructor in fall 2013 with the assistance of RMH staff
            members Gabrielle Booth and Karla Prouty.

        <p>
            This project was supported by Bowdoin College as part of its ongoing commitment to serving the common good.
            It was inspired by the
            <a href="http://www.hfoss.org/">Humanitarian Free and Open Source (HFOSS) Project</a>, which aims to "build
            a community of academic computing departments,
            IT corporations, and local and global humanitarian and community organizations dedicated to
            building and using Free and Open Source Software to benefit humanity."


        <p><strong>System Access and Reuse</strong><br/><br/>
            Because Homebase must protect the privacy of individual volunteers at the Ronald McDonald House, access to
            the system by non-volunteers is
            limited. If you are a volunteer and have forgotten your Username or Password, please contact the <a
                href="mailto:housemngr@rmhportland.org">House Manager</a>.
        </p>

        <p> Homebase is free and open source software (see <a href="http://code.google.com/p/rmh-homebasecivi/"
                                                              target="_blank">http://code.google.com/p/rmh-homebasecivi/</a>).
            From this site, its source code can be freely downloaded and adapted
            to fit the volunteer scheduling needs of other nonprofit organizations. For more information about the
            capabilities or adaptability of Homebase to other settings, please contact
            either <a href="mailto:allen@myopensoftware.org">Allen Tucker</a> or visit the website <a
                href="http://myopensoftware.org/content/software-projects" target="_blank">http://myopensoftware.org</a>.
        </p>
        
       
<?PHP include('footer.inc'); ?>
</div>
</div>
<!--</body>-->
</html>