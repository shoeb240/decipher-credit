<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//var_dump($apiresults);
foreach($apiresults->GetReportResult->Subject as $row){
    print_r($row);
    echo "<br />";
    echo "<br />";
    
}

?>

