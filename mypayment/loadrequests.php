<?php

include('connection.php');

//get the user_id
$id = $_SESSION['user_id'];

//run a query to look for notes corresponding to user_id


$sql = "Select * from users join request_transaction on users.user_id = request_transaction.Requested_Id where users.user_id='$id' and request_transaction.Status='1'"; 
//shows notes or alert message
if($result = mysqli_query($link, $sql)){
    if(mysqli_num_rows($result)>0){
        while($row = mysqli_fetch_array($result)){
            

            $amount = $row['Amount'];
            $note_id = $row['Memo'];
            $date = $row['Date'];
            $rtxid = $row['RTid'];

            $sql1 = "Select * from users join request_transaction on request_transaction.Sender_id = users.user_id where request_transaction.Requested_Id='$id'";
            $result1 = mysqli_query($link,$sql1);
           $row1 = mysqli_fetch_array($result1);
            $name = $row1['username'];
            $e = $row1['email'];
            echo "
            <form method='post' action='transfer2.php'>
            <input type='hidden' value='$e'name='email'>
            <input type='hidden' value='$amount' name='amount'>
            <input type='hidden' value='$note_id'name='memo'>
            <input type='hidden' value='$rtxid'name='rtx'>
        <div class='note'>
            
            <div class='noteheader' id=''>
            <div class='text'>Request Sent by:- $name </div>
                <div class='text'>Amount: $ $amount</div>
                <div class='text'>Memo: $note_id</div>
                <div class='timetext'>Date: $date</div>    
            </div>
        </div>
        <input class='btn green' name='submit' type='submit' value='Settle'>
        </form>";
        }
        
    }else{
        echo '<div class="alert alert-warning">No Transactions yet!!</div>';
    }
    
}else{
    echo '<div class="alert alert-warning">An error occured!</div>';
//    echo "ERROR: Unable to excecute: $sql." . mysqli_error($link);
}

?>