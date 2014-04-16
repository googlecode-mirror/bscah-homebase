<?php

session_start();
session_cache_expire(30);
?>

<html>
    <head>
        <title>
            RMH Homebase
        </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <style>
        	#appLink:visited {
        		color: gray; 
        	}
        </style> 
    </head>
    <body>
        <div id="container">
        
            <div id="content">
       <?PHP        
         $_SESSION['logged_in'] = 1;
       $_SESSION['access_level'] = 2;  // for staff
     echo('<strong> Edit a Project:</strong> <a href="../projectEdit.php?id=new">edit</a>' );    
			

    ?>
                    </div>
                    <?PHP include('footer.inc'); ?>
        </div>
    </body>
</html>