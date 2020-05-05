<?php
//<!--Start session-->
session_start();
include('connection.php'); 
$email = $_POST['email'];

$rtx = $_POST['rtx'];
$id = $_SESSION['user_id'];
$sendemail = $_SESSION["email"];

$amount = $_POST["amount"];
$memo = $_POST["memo"];
$sql = "SELECT * FROM users WHERE email = '$email' and activation = 'activated'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>'; exit;
}
$results = mysqli_num_rows($result);
if(!$results){
    echo '<div class="alert alert-danger">That email is not registered. Transaction Failed</div>';  exit;
}

$sql = "SELECT * FROM users WHERE email = '$sendemail'";
$result = mysqli_query($link, $sql);
$results = mysqli_fetch_array($result);
$balance = $results['balance'];
if($balance < $amount){
    echo '<div class="alert alert-danger">Insufficient Balance!</div>'; exit;
}

$sql = "update users set balance = balance - '$amount' where email = '$sendemail'";
$result = mysqli_query($link, $sql);



$sql1 = "update users set balance = balance + '$amount' where email = '$email'";
$result1 = mysqli_query($link, $sql1);


$sql2 = "insert into activity (`sender_email`, `rec_email`, `amount`, `comments`,`Status`) values ('$sendemail', '$email', '$amount', '$memo','requested')";
$result2 = mysqli_query($link, $sql2);


$sql3 = "UPDATE request_transaction SET Status='0' WHERE Requested_id='$id' AND RTid = '$rtx'";
$result3 = mysqli_query($link,$sql3);

if($result2 && $result3 && $result1 && $result) {

    echo"<script>alert('Transfer Done!!');location='homepage.php'</script>";

}
else {
    echo "error";

}
