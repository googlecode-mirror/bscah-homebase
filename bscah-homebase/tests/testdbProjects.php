<?php
include_once(dirname(__FILE__) . '/../domain/project.php');
include_once(dirname(__FILE__) . '/../database/dbProjects.php');
echo 'testing dbProjectsphp</br>';
error_log("in test db projects");
test_create_dbProjects();
echo("test complete</br>");

// tests the create_dbProjects() function in dbProjects.php
function test_create_dbProjects()   {
   
   $newProject = new Project ("03-12-14", "overnight", 10, 13, "weekly",15, "malcom1234567890+Malcom+Jones","matt1234567899+Matt+Smith", "Monday", "11-22-33-44-55", "notes");
    echo 'will test create_dbProjects </br>';
    $result = create_dbProjects($newProject);
    echo 'result is ' . $result;
    if ($result)
        echo "create_dbProjects succeeded </br>";
    else
        echo "create_dbProjects failed</br>";
}
function test_insert_dbProjects() {
   
    
   $newProject= new Project("03-12-14", "overnight", 10, 13, "weekly",15, "malcom1234567890+Malcom+Jones","matt1234567899+Matt+Smith", "Monday", "11-22-33-44-55", "notes");
    echo 'will test insert_dbProjects </br>';
    $result = insert_dbProjects ($newProject);
    echo 'result is ' . $result;
    if ($result)
        echo "insert_dbProjects succeeded </br>";
    else
        echo "insert_dbProjects failed</br>";
}
?>