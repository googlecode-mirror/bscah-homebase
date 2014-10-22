<?php

/* 
 * homepageMain.php
 * This page is the first page a person seeking the BSCAH website will see and will serve as a portal
 * to the rest of the site.  
 * @author Rocco J. Sacramone
 * @version 10/15/2014
 */

    session_start();
    session_cache_expire(30);
?>

<html>
<head>
    <title>
        BSCAH Main
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    

<div id="header">
    <!--<br><br><img src="images/rmhHeader.gif" align="center"><br>
    <h1><br><br>Homebase <br></h1>-->

</div>

</head>
<body>
    
<div id="content">
<?PHP    
    echo("Hello and Welcome to the Bed-Stuy Campaign Against Hunger Homepage where we take a communities approach to caring!");
    echo("The BSCAH was founded in 1998 as a food pantry in a church basement and we have now grown over the years to be the largest food pantry in Brooklyn. "
            . "Our mission is to provide a well balanced diet to low-income and in need individuals. There are a multitude of ways for people to get involved"
            . "with our organization. There are opportunities ranging from Pantry Volunteering to making PB&J Saanwiches.");
?> 
    <br>
    *****Alpha Test Description*****
    <br>
    <br>
    If you are looking for more detailed information about different Volunteer opportunities, please visit our <a href = "projectInfo.php">Project Information Page</a>.
    <br>
    <br>
    If you are looking to sign up to be a volunteer, you can fill out a volunteer application <a href="personEdit.php">here</a>.
    <br>
    <br>
    If you are an existing or returning volunteer, please <a href="login_form.php">login here</a>.
    <br>
    
<?PHP include('footer.inc'); ?>
</div>
<!--</div>-->
</body>
</html>