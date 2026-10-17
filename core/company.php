<?php session_start();?>
<?php
/**
* Controls all logic of the app
* 
*/
require_once "conn.php";

if($_POST['job-details']){
    $title = $_POST['job-title'];
    $cat = $_POST['radio1'];
    $loc = $_POST['job-location'];
    $pay = $_POST['salary'];
    $end = $_POST['job-deadline'];
    $exp = $_POST['radio3'];
    $details = $_POST['job-details'];
    $id      =  $_SESSION['userData']['id'];

    $sql = "INSERT INTO jobs (`user_id`,`title`,`cat`,`loc`,`price`,`end`,`level`,`details`) 
                VALUES ('$id','$title','$cat','$loc','$pay','$end','$exp','$details') ";

    $query = mysqli_query($con, $sql);  
}



?>