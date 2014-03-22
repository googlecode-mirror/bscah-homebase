<?php
include_once(dirname(__FILE__).'/../domain/Person.php');
 echo 'testing dbPersons.php</br>';     
$m = new Person("Gabrielle","Booth", "female","14 Way St", "Harpswell", "ME", "04079","",
1112345678, 2071112345,"ted@bowdoin.edu","email", "Mother", 2077758989, "manager","","","active", "programmer", 
"Steve_2077291234","yes","","", "Mon:morning,Tue:morning","","","02-19-89", "03-14-08","","");

echo 'will test add_person </br>';
$result = add_person($m);
echo 'result is '. $result;
if ($result)
    echo "add_person succeeded </br>";
else
    echo "add_person failed</br>";

echo "test retrieve_person</br>";
$p = retrieve_person("Gabrielle1112345678");
if ($p == null)
    echo 'Retrieve failed</br>';
else {
    checkEquals($p->get_status(),"active");
    checkEquals($p->get_occupation(),"programmer");
    checkEquals($p->get_refs(), array("Steve_2077291234"));
}


echo("testdbPersons complete</br>");

function checkEquals($result, $expected)
{
    if ($result == $expected)
    {
        echo 'result ' . $result . ' is the same as expected value ' . $expected.'</br>';
        return true;
    }
 else {
           echo 'result ' . $result . ' does not equal the  expected value ' . $expected.'</br>';
        return false;
    }
}