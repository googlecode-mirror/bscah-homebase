<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class projectTypes{
    
    public $TeamBuilding = [];
    public $Volunteer = []; 
    
    function __construct()
    {
        $this->TeamBuilding  = ['PB & J Sandwiches', 'Birthday Boxes', 'Hygiene Kits', 'Body Kits', 'Emergency Relief Kits', 'Virtual Can Drive'];
        $this->Volunteer = ['Pantry Volunteer','Garden Volunteer','Building Project'];
    }
    
   
}

