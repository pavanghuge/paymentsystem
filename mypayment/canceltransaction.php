<?php
//<!--Start session-->
session_start();
include('connection.php'); 

$email = $_SESSION['email'];
$userid = $_SESSION['user_id'];
$takbac = $_POST['takeback'];
echo $takbac;
$tran_id = $_POST["transc_id"];
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

$sql = "SELECT * FROM users WHERE email = '$takbac'";
$result = mysqli_query($link, $sql);
$results = mysqli_fetch_array($result);
$balance = $results['balance'];
if($balance < $amount){
    echo '<div class="alert alert-danger">Insufficient Balance!</div>'; exit;
}

$sql = "update users set balance = balance + '$amount' where email = '$email'";
$result = mysqli_query($link, $sql);


$b = $balance - $amount;
$sql1 = "update users set balance = ".$b." where email = '$takbac'";
$result1 = mysqli_query($link, $sql1);


$sql2 = "insert into activity (`sender_email`, `rec_email`, `amount`, `comments`,`Status`) values ('$takbac', '$email', '$amount', '$memo','Cancel')";
$result2 = mysqli_query($link, $sql2);


if($result2 && $result1 && $result) {

    echo"<script>alert('Transaction Cancelled!!');location='homepage.php'</script>";

}
else {
    echo "error";

}
