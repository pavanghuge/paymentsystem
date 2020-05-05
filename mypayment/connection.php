<?php
date_default_timezone_set("America/New_York");
$link = mysqli_connect("localhost", "root", "root", "digitalWallet");
if(mysqli_connect_error()){
    die('ERROR: Unable to connect:' . mysqli_connect_error()); 
    echo "<script>window.alert('Hi!')</script>";
}
    ?>