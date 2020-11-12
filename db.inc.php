<?php
// database connnectivity is defined here
// start session for every page
session_start();
//  connecting to databese
//  parameers used : localhost, username, password, database name
$con=mysqli_connect('localhost','root','','employee_management_system');
?>