<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once(dirname(__FILE__) . '/../domain/BSCAHdate.php');
echo 'testing dbDates.php</br>';

test_create_dbDates();
test_insert_dbDates();
test_delete_dbDates();
test_update_dbDates();
test_replace_dbDates();
test_select_dbDates();
test_get_shifts_text();

echo("testdbDates complete</br>");

function test_create_dbDates()
{
    $test = new date("04-01-14", "Tuesdays", "Note Example", "");
    echo 'will test add_person </br>';
    $result = create_dbDates($test);
}

function test_insert_dbDates()
{
    
}

function test_delete_dbDates()
{
    
}
function test_update_dbDates()
{
    
}
function test_replace_dbDates()
{
    
}
function test_select_dbDates()
{
    
}
function get_shifts_text()
{
    
}