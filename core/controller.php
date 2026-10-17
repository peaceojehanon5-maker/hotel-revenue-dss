<?php session_start();?>
<?php
/**
* Controls all logic of the app
* 
*/
require_once "conn.php";
//damages
if(isset($_POST['damage-details'])){

    $damage = $_POST['damage-details'];
    $price = $_POST['book-price'];
    $date = $_POST['damage-date'];

    $sql = "INSERT INTO damages (`desc`,`cost`,`date`) 
            VALUES ('$name','$price','$date')";

    $query = mysqli_query($con, $sql)or die(mysqli_error($con));

}

//issues
if(isset($_POST['ish-details'])){

    $details = $_POST['ish-details'];
    $name = $_POST['ish-name'];
    $date = $_POST['ish-date'];

    $sql = "INSERT INTO issues (`issue`,`stafff_id`,`date`) 
            VALUES ('$details','$name','$date')";

    $query = mysqli_query($con, $sql)or die(mysqli_error($con));

}

// expenditure

if(isset($_POST['ex-name'])){
    $name = $_POST['ex-name'];
    $type = $_POST['ex-type'];
    $price = $_POST['ex-price'];
    $date = $_POST['ex-date'];

    $sql = "INSERT INTO budget (`desc`,`price`,`type`,`date`) 
            VALUES ('$name','$price','$price','$date')";

    $query = mysqli_query($con, $sql)or die(mysqli_error($con));
}




//bookings
if(isset($_POST['book-date'])){
    $name = $_POST['book-name'];
    $room = $_POST['book-room'];
    $date = $_POST['book-date'];

    $sql = "INSERT INTO bookings (`name`,`room_id`,`date`) 
            VALUES ('$name','$room','$date')";

    $query = mysqli_query($con, $sql)or die(mysqli_error($con));

}


//submit works
if(isset($_POST['jtitle'])){
    $title = $_POST['jtitle'];
    $cname = $_POST['cname'];
    $from = $_POST['from'];
    $to = $_POST['to'];
    $id = $_SESSION['userData']['id'];


    $sql = "INSERT INTO work (`user_id`,`title`,`company`,`from`,`to`) 
            VALUES ('$id','$title','$cname','$from','$to')";

    $query = mysqli_query($con, $sql)or die(mysqli_error($con));
    echo 1;
}



?>