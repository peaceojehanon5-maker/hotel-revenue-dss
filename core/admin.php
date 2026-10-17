<?php
require "conn.php";
require "controller.php";

if(empty($_POST['email']) || empty($_POST['password'])){

    echo "All fileds required";
    
}else{
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $password = md5($_POST["password"]);

    $sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password' AND type = 'A' ";
    $run_query = mysqli_query($con,$sql)or die(mysqli_error($con));
    $count = mysqli_num_rows($run_query);

    if($count == 1){
        $row = mysqli_fetch_assoc($run_query);
        $_SESSION['userData'] = array(
            'id'        => $row['id'],
            'name'      => $row['name'],
            'email'     => $row['email'],
            'type'     => $row['type']
        );
        header('Location: ../index.php');
    }else{

        echo 'user nor found. please check your details properly';
    }
        
}



?>