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
    <link rel="stylesheet" href="projectInfo.css" type ="text/css"/>
</head>  
<body>
  <div id="container">
        <?php
           include_once("header.php");
           include('accessController.php');
        ?>
        
    <div id="content">
        <?php
           if(($_GET['frequency'])!= "")
           {
               $frequency = $_GET['frequency'];
               show_project_info($frequency);
           }
           else{
               show_project_types();
           }
        ?>
    </div>
  </div>
</body>
</html>

<?php
function show_project_types()
{
    echo '<div id ="title"> Click on a type to learn more! </div>';
    echo '<div id="outer">';
        echo '<div class="projectbox" id="pantry">' . 
                ' <a href = "projectInfo.php?frequency=pantry"> <img id = "image" src = "http://classyclosets.com/images/pantries/05%20Traditional%20Gallery%20Pantry.jpg" alt="Pantry"></a></div>';
        echo '<div class="projectbox" id="garden">' .
                ' <a href ="projectInfo.php?frequency=garden"> <img id = "image" src = "http://www.smallgardentiller.org/wp-content/uploads/_vegetable-garden.jpg"Garden</a></div>';
        echo '<div class="projectbox" id="building">' .
                ' <a href ="projectInfo.php?frequency=building"> <img id = "image" src = "http://www.hiddenlakeestatespa.com/wp-content/uploads/2014/06/Rolled-Construction-Plans.jpg"Building</a></div>';
        echo '<div class="projectbox" id="team">' .
                ' <a href ="projectInfo.php?frequency=team"><img id = "image" src = "http://www.openheartedtransformation.com.au/wp-content/uploads/2009/09/hands-in-circle1.jpg" Team</a></div>';
    echo '</div>';
}

function show_project_info($frequency){
    if($frequency == "garden")
    {
        echo '<p><strong>Garden Volunteer: </strong><br/> 
        After the addition of a hoop house in our organic urban garden, located at Saratoga 
        and Fulton, our growing season is year round!  Volunteers working in the garden will help to harvest an
        array of organic produce to be distributed in our pantry, along with other gardening duties including: 
        watering, weeding, composting, general clean up.
        <br> 
        <p><strong>** Volunteers wishing to assist in our gardens should contact Jonathan, the garden manager, to set up 
        appropriate gardening hours. **</strong><br/> 
     
        <p><strong>Age limit - </strong>7 years (with supervision) or older.        
        <p><strong>Group size - </strong>8 volunteers (larger group may be accommodated on a case by case basis)
            <br><br> ';
    }
    else if($frequency == "pantry")
    {
        echo '<p><strong>Pantry Volunteer:</strong><br/>
        The food pantry is our flagship and the heart of the Bed-Stuy Campaign Against Hunger. We service over 25,000 individuals from low-income households in our pantry 
        per month. The Pantry is operated under the client choice system, which means that the food pantry
        functions similarly to a grocery store. Volunteers work as they would in a grocery store, stocking shelves, 
        assisting with customer service and helping in the storage area. 

    <p><strong>**Volunteers may be asked to lift boxes up to 20 lbs, however, this is not a requirement for volunteering.</strong><br/>

        <p><strong>Age limit - </strong>15 years or older.
        <p><strong>Group size - </strong>1-12 volunteers. 
        <p><strong>Other Specifications - </strong> none.
            <br><br>';
    }
    else if($frequency == "building")
    {
        echo '<p><strong>Building Projects: </strong><br/>
        Bed-Stuy Campaign Against Hunger is always expanding and improving! 
        Please feel free to contact us regarding upcoming projects in our gardens and pantry. 
        <br> 
        <p><strong>**Previous projects include: hoop house build for MLK day, painting the pantry, building new 
                composting bins etc. **</strong><br/>
        <p><strong>Age limit - </strong>12 years or older (other specifications may be made depending on project).
        <p><strong>Group size - </strong>5-20 volunteers (once again size of group depends on project type).
        <p><strong>Other Specifications - </strong>TBD.
            <br><br> ';
    }
    else if($frequency == "team")
    {
        echo '<p><strong>Team Building Projects:</strong><br/>
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
            <br><br>';
    }
    
    sign_up_for_selected_project($frequency);
}
function sign_up_for_selected_project($frequency)
{
//generates submit button to search for current projects of this frequency /type 
    echo('<form method="post">');
    echo('<input type="hidden" name = "frequency" value = "' . $frequency . '">');
    echo('<p><input type="hidden" name="s_submitted" value="1"><input type="submit" name="Search" value="Display Current Projects">');
    echo('</form></p>'); 

//generates select list of projects options for that frequency when display button is pressed
//project options only appear if the current logged in user is not already in that project
    if(isset($_POST['s_submitted']))
    {
        include_once('database/dbProjects.php');
        include_once('domain/Project.php');
        $projects = getonlythose_projects_by_type($_POST['frequency']);
        $id = $_SESSION['_id'];
        echo'<select name ="projectChoice"  onchange="location = this.options[this.selectedIndex].value;">' . '<option value = ""</option>';
        foreach($projects as $project)
        {
            if(strpos($project->get_persons(),$id) !== FALSE)
            {   
            echo '<option value = "projectSearch.php?id=' . $project->get_id() . '">' . $project->get_name() . " " . $project->get_date() . " (Remove yourself) ".'</option>';      
            }
            else
            {
            echo '<option value = "projectSearch.php?id=' . $project->get_id() . '">' . $project->get_name() . " " . $project->get_date() . '</option>';
            }
        }
        }
       echo '</select>'; 
    }
?>
