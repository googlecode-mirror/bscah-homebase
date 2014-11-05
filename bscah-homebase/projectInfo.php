<?php

/* 
 * projectInfo.php
 * This page contains information on all the events and volunteer projects BSCAH has to offer.
 * @author Rocco J. Sacramone
 * @version 10/19/2014 Revised: 10/29/2014
 */

    session_start();
    session_cache_expire(30);
?>

<html>
<head>
    <title>
        Project Information 
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    

<div id="header">
    <!--<br><br><img src="images/rmhHeader.gif" align="center"><br>
    <h1><br><br>Homebase <br></h1>-->

</div>
</head>
<body>
    
<div id="content">
<?php
   /*if (!isset($_SESSION['logged_in'])) 
       {
            error_log('in projectInfo.php, default access level is set to 0');
            $_SESSION['access_level'] = 0;
       } //all people who view this page are given an access level of zero by default.
   else {
            if($_SESSION['access_level'] == 1 || $_SESSION['access_level'] == 2)
            {
                error_log('in projectInfo.php, continue...user logged in');
            }
        } //possibly not working
    * 
    */
?>
    
    Please check out our <strong><a href="currentProjectDetailed.php">Current Projects</a></strong>!   
    
<p><strong>This is our Project and Event information page. It is here where potential volunteers can recieve information about volunteering.</strong><br/><br/>

    <p><strong>Pantry Volunteer:</strong><br/>
        The food pantry is our flagship and the heart of the Bed-Stuy Campaign Against Hunger. We service over 25,000 individuals from low-income households in our pantry 
        per month. The Pantry is operated under the client choice system, which means that the food pantry
        functions similarly to a grocery store. Volunteers work as they would in a grocery store, stocking shelves, 
        assisting with customer service and helping in the storage area. 

    <p><strong>**Volunteers may be asked to lift boxes up to 20 lbs, however, this is not a requirement for volunteering.</strong><br/>

        <p><strong>Age limit - </strong>15 years or older.
        <p><strong>Group size - </strong>1-12 volunteers. 
        <p><strong>Other Specifications - </strong> none.
            <br><br>
            
    <p><strong>Garden Volunteer: </strong><br/> 
        After the addition of a hoop house in our organic urban garden, located at Saratoga 
        and Fulton, our growing season is year round!  Volunteers working in the garden will help to harvest an
        array of organic produce to be distributed in our pantry, along with other gardening duties including: 
        watering, weeding, composting, general clean up.
        <br> 
        <p><strong>** Volunteers wishing to assist in our gardens should contact Jonathan, the garden manager, to set up 
        appropriate gardening hours. **</strong><br/> 
     
        <p><strong>Age limit - </strong>7 years (with supervision) or older.        
        <p><strong>Group size - </strong>8 volunteers (larger group may be accommodated on a case by case basis)
            <br><br> 
            
    <p><strong>Building Projects: </strong><br/>
        Bed-Stuy Campaign Against Hunger is always expanding and improving! 
        Please feel free to contact us regarding upcoming projects in our gardens and pantry. 
        <br> 
        <p><strong>**Previous projects include: hoop house build for MLK day, painting the pantry, building new 
                composting bins etc. **</strong><br/>
        <p><strong>Age limit - </strong>12 years or older (other specifications may be made depending on project).
        <p><strong>Group size - </strong>5-20 volunteers (once again size of group depends on project type).
        <p><strong>Other Specifications - </strong>TBD.
            <br><br> 
            
    <p><strong>Team Building Projects:</strong><br/>
        Gather your coworkers, teammates, classmates or friends to work together to create a difference in Bed-
        Stuy!
        <br><br> 
        
    <p><strong>PB&J Sandwiches:</strong><br/> 
        Just like the ones mom packed you for lunch! Our clients love receiving
        these kind bags of comfort food, whether it’s for a snack or lunch to bring to work/school. Our
        clients appreciate this gesture and look forward to these sandwiches all month. 
        <br><br>
        
    <p><strong>Birthday Boxes:</strong><br/>
        Many people forget that the simple celebration of birthdays can be difficult for those
        living in poverty.  Help the families of Bed-Stuy celebrate their child’s special day by assembling our 
        boxes.  Each box contains: cake mix, icing, candles, and a small gift (anything under $5) along
        with any other special touch you’d like to add (ie: party decorations, plates, napkins, balloons…). 
        <strong>Price: </strong>$250 for 60 boxes 
            <br><br>
            
    <p><strong>Hygiene Kits:</strong><br/>
        Distributed to clients on the first day they register for the pantry is a hygiene kit, this 
        contains a few toothbrushes, floss, tooth paste, and soap along with anything else you would like to 
        supply (shampoo, conditioner, deodorant, baby toothbrushes, razor, etc.)
            <br><br> 
            
    <p><strong>Baby Kit: </strong><br/>
        These kits are designed for the babies of Bed-Stuy, to give them what they need to be kept
        clean and healthy: diapers, baby lotion, baby shampoo, baby wipes, ????????
            <br><br> 
            
    <p><strong>Emergency Relief Kit:</strong><br/>
        All New Yorkers experience the fear of a natural disaster when Hurricane Sandy 
        hit, help members of our community feel prepared by assembling an emergency relief kit.  These kits 
        contain: flashlights, batteries, swiss army knife, non-perishable food, water bottles, hand sanitizer,
        matches, etc.
            <br><br> 
            
    <p><strong>Virtual Can Drive: </strong><br/>
        Create a virtual food drive for BSCAH at yougivegoods.com, it’s a hassle free way to 
        ensure the most efficient use of your donations.
            <br><br>
            
    Please <strong><a href="login_form.php">login here</a></strong> to sign up for these events!
    <br><br>
    
    Please fill out an <strong><a href="personEdit.php?id=new">volunteer application</a></strong> if you are a new to BSCAH.
    <br>
    
<?PHP include('footer.inc'); ?>
</div>
<!--</div>-->
</body>
</html>

