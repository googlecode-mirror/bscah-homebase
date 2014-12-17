<?php

/* 
 * This will show details of all current projects
 * 
 * @author Rocco J. Sacramone, Ena Muslim
 * @version 11/5/2014
 */

    session_start();
    session_cache_expire(30);
?>

<html>
<head>
    <title>
        Current Projects 
    </title>
    <link rel="stylesheet" href="styles.css" type="text/css"/>

</head>
<body>
    
<div id="content">
<?php
include_once('header.php');
include_once('accessController.php');
include_once('domain/Project.php');
include_once ('database/dbProjects.php');

$all_projects = get_all_projects();
$projects=[];

foreach ($projects as $p) {
    $p-> get_project_name();
    
}
?>

    
    
    <p align= "center" style="font:50px Script; color:#EE162C">
       Take a look at our current projects! See anything you like?
       <br><a href="personEdit.php?id=new">Sign up to volunteer!</a>
    </p>
<div style="height:600px;width:1150px;border:0px solid #000;font:16px/26px Verdana;overflow:auto">
    
    <p align= "center" style="font:50px Impact; color:#04D33B">
        <?php $p->get_project_name(); ?>
    </p>
    <img src = "../../stock-kids-garden.jpg" width = "1100" height = "500" alt = "stock-kids-garden"/>
    <b style="color:#9006BF">Date: </b>June 10, 2015<br>
    <b style="color:#9006BF">Address: </b>555 Main Street New York, NY 10002<br>
    <b style="color:#FF0116">Description: </b>Notes here.....<br>
    </p>
    <b>Interested? Fill out a <a href="personEdit.php?id=new">volunteer application</a>!</b>

</div>

<?PHP include('footer.inc'); ?>
</div>
</body>
</html>



