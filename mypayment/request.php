<?php
//<!--Start session-->
session_start();
include('connection.php'); 
$id = $_SESSION['user_id'];
$requestemail = $_POST["requestemail"];
$amount = $_POST["amount"];
$memo = $_POST["memo"];
$sql = "SELECT * FROM users WHERE email = '$requestemail' and activation = 'activated'";
$result = mysqli_query($link, $sql);
if(!$result){
    echo '<div class="alert alert-danger">Error running the query!</div>'; exit;
}
$results = mysqli_num_rows($result);
if(!$results){
    echo '<div class="alert alert-danger">That email is not registered. Transaction Failed</div>';  exit;
}
$row = mysqli_fetch_array($result);
$reqid = $row['user_id'];


$rand =rand(1,100000);
$date=date("Y-m-d H:i:s");
$sql2 = "INSERT INTO request_transaction(`RTid`, `Sender_id`, `Requested_Id`, `Amount`, `Date`, `Memo`, `Status`) VALUES ('$rand','$id','$reqid','$amount','$date','$memo',true)";
$result2 = mysqli_query($link, $sql2);

if($result2) {

    echo"<script>alert('Request sent');location='homepage.php'</script>";

}
else {
    echo "error";

}

